<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tournament;
use App\Models\DeckType;

class ShowStandings extends Component

{
    public $tournament;

    public function mount($limitless_id)

    {
        $this->tournament = Tournament::where('limitless_id', '=', $limitless_id)->first();
    }

    public function render()
    {
        $types = DeckType::has('tournamentStandings')->withCount(['tournamentStandings'])->orderBy('name', 'ASC')->get();
        return view('livewire.show-standings', compact('types'));
    }
}
