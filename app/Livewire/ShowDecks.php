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

    protected $listeners = ['search'];


    #[Url]
    public $page = 1;

    #[Url (keep:true)]
    public $identifier = '';

    #[Url]
    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function mount() 
    {

    }

    public function setIdentifier($input) {
        $this->resetPage();
        $this->identifier = $input;
    }

    public function render()
    {
        return view('livewire.show-decks', [

            'tournaments' => Tournament::orderBy('date', 'DESC')->get(),
            'decks' => Deck::has('deckCards')
                ->where('identifier', 'like', '%'.$this->identifier.'%')
                ->orderBy('date', 'DESC')
                ->orderBy('placement', 'ASC')
                ->where('player_username', 'like', '%'.$this->query.'%')
                ->paginate(20),
            'types' => DeckType::has('decks')->withCount(['decks'])->orderBy('decks_count', 'DESC')->get()
        ]);
    }
}
