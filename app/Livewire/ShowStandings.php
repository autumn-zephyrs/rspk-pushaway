<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tournament;

class ShowStandings extends Component

{
    public $tournament;

    public function mount($limitless_id)

    {
        $this->tournament = Tournament::where('limitless_id', '=', $limitless_id)->first();
    }

    public function render()
    {
        return view('livewire.show-standings');
    }
}
