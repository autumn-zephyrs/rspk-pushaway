<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DeckType;
use App\Models\Deck;
use App\Models\TournamentPairing;
use Illuminate\Support\Facades\DB;

class ShowArchetype extends Component
{
    public $archetype;

    public function mount($id) 
    {
        $this->archetype = DeckType::find($id);
    }

    public function render()
    {
        $types = DeckType::has('tournamentStandings')->orderBy('name', 'ASC')->get();
        $output = [];
        $pairingsData = [];

        foreach($types as $type) {
            $pairings = collect(DB::select('SELECT tournament_pairings.player_1, player_1_deck.identifier as "player_1_deck", tournament_pairings.player_2, player_2_deck.identifier as "player_2_deck", tournament_pairings.winner FROM rspk_pushaway.tournament_pairings
            inner join decks as player_1_deck on player_1_deck.player_username = tournament_pairings.player_1 and player_1_deck.tournament_limitless_id = tournament_pairings.tournament_limitless_id
            inner join decks as player_2_deck on player_2_deck.player_username = tournament_pairings.player_2 and player_2_deck.tournament_limitless_id = tournament_pairings.tournament_limitless_id
            where (player_1_deck.identifier = "' . $this->archetype->identifier . '" or player_2_deck.identifier = "' . $this->archetype->identifier . '")
            and (player_1_deck.identifier = "' . $type->identifier . '" or player_2_deck.identifier = "' . $type->identifier . '")'));

            $wins = 0;
            $losses = 0;
            $ties = 0;

            $player = '';

            if (count($pairings) == 0) {
                $output[$type->identifier] = null;
                continue;
            } 
    
            foreach($pairings as $pairing) {
                if(($this->archetype->identifier !== $type->identifier)) {
                    if ($pairing->player_1_deck == $this->archetype->identifier) {
                        $player = $pairing->player_1;
                    } else {
                        $player = $pairing->player_2;
                    }
                    if          ($pairing->winner == $player) {
                        //If player 1 wins and we are player 1
                        $wins++;
                    } else if   ($pairing->winner == -1) {
                        //If the round is a double loss
                        $losses++;
                    } else if   ($pairing->winner == 0) {
                        //If the round is a double loss
                        $ties++;
                    }else if   ($pairing->player_2 == null) {
                        //If the round is a bye
                        $wins++;
                    } else {
                        //At this point surely we lose
                        $losses++;
                    }
                    $output[$type->identifier] = round(($wins === 0 ? 0 : $wins / ($wins + $losses + $ties)) * 100, 2);
                } else {
                    $output[$type->identifier] = 50;
                }
            }
        }
        $matchups = collect($output);

        return view('livewire.show-archetype', compact('types', 'matchups'));
    }
}
