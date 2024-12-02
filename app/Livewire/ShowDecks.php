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

    #[Url]
    public $query = '';

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
            'decks' => Deck::has('deckCards')->where('identifier', 'like', '%'.$this->identifier.'%')->orderBy('id', 'ASC')->where('player_username', 'like', '%'.$this->query.'%')->paginate(20),
            'types' => DeckType::has('decks')->withCount(['decks'])->orderBy('decks_count', 'DESC')->get()
        ]);
    }
}
