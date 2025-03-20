<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deck;
use App\Models\DeckType;

class ShowDeck extends Component
{

    public $deck;

    public function mount($id) 
    {
        $this->deck = Deck::find($id);
    }

    public function render()
    {
        $types = DeckType::has('decks')->withCount(['decks'])->orderBy('name', 'ASC')->get();
        return view('livewire.show-deck', compact('types'));
    }
}
