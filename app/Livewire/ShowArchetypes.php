<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeckType;

class ShowArchetypes extends Component
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

    public function render()
    {
       
        $archetypes = DeckType::has('tournamentStandings')->orderBy('name', 'ASC')->paginate(20);

        $types = DeckType::has('tournamentStandings')->orderBy('name', 'ASC')->get();
        
        return view('livewire.show-archetypes', compact('types', 'archetypes'));
    }
}
