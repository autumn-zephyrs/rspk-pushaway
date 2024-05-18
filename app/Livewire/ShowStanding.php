<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TournamentStanding;
use App\Models\TournamentPairing;
use Illuminate\Support\Facades\DB;

class ShowStanding extends Component
{
    public $standing;
    public $pairings;

    public function mount($id)

    {
        $this->standing = TournamentStanding::find($id);
        $p1 = TournamentPairing::where('tournament_limitless_id', '=', $this->standing->tournament_limitless_id)->where('player_1', '=', $this->standing->player_username)->get();
        $p2 = TournamentPairing::where('tournament_limitless_id', '=', $this->standing->tournament_limitless_id)->where('player_2', '=', $this->standing->player_username)->get();
        $this->pairings = $p1->merge($p2);
    }

    public function render()
    {
        return view('livewire.show-standing');
    }
}
