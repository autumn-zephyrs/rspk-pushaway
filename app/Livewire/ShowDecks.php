<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Deck;
use App\Models\DeckType;

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

    public function next() 
    {
        $this->page++;
        $this->nextPage();
    }

    public function getCard()
    {

    }

    public function previous() 
    {
        $this->page--;
        $this->previousPage();
    }

    public function render()
    {
        return view('livewire.show-decks', [
            'decks' => Deck::has('deckCards')->where('identifier', 'like', '%'.$this->identifier.'%')->simplePaginate(10),
            'types' => DeckType::has('decks')->orderBy('name', 'ASC')->get()
        ]);
    }

    public function paginationView()
    {
        return 'livewire.custom-pagination-links';
    }
}
