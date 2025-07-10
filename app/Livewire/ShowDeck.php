<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TournamentStanding;
use App\Models\DeckType;

class ShowDeck extends Component
{

    public $deck;

    public function mount($id) 
    {
        $this->deck = TournamentStanding::find($id);
    }

    public function render()
    {
        $types = DeckType::has('tournamentStandings')->withCount(['tournamentStandings'])->orderBy('name', 'ASC')->get();
        return view('livewire.show-deck', compact('types'));
    }
}
