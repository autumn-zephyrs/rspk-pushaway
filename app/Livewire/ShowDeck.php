<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deck;
use App\Models\DeckType;

class ShowDeck extends Component
{

    public $deck;
    public $types;

    public function mount($id) 
    {
        $this->deck = Deck::find($id);
        $this->types = DeckType::has('decks')->withCount(['decks'])->orderBy('decks_count', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.show-deck');
    }
}
