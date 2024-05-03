<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deck;

class ShowLatest extends Component
{
    public $decks;

    public function mount() {
        $this->decks = Deck::has('cards')->get();
    }

    public function render()
    {
        
        return view('livewire.show-latest');
    }
}
