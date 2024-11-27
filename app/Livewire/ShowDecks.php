<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Deck;
use App\Models\DeckType;
use App\Models\Tournament;

class ShowDecks extends Component
{
    use WithPagination;

    #[Url (keep:true)]
    public $page = 1;

    #[Url]
    public $identifier = '';

    public function mount() 
    {

    }

    public function setIdentifier($input) {
        $this->resetPage();
        $this->identifier = $input;
    }

    public function copyDeck() {

    }

    public function render()
    {
        return view('livewire.show-decks', [
            'decks' => Deck::has('deckCards')->where('identifier', 'like', '%'.$this->identifier.'%')->orderBy('id', 'ASC')->simplePaginate(20),
            'types' => DeckType::has('decks')->orderBy('name', 'ASC')->get()
        ]);
    }

    public function paginationView()
    {
        return 'livewire.custom-pagination-links';
    }
}
