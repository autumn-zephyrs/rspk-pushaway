<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Tournament;


class ShowTournaments extends Component
{
    use WithPagination;


    #[Url (keep:true)]
    public $page = 1;

    #[Url (keep:true)]
    public $query = '';

    public function mount() 
    {

    }

    public function setQuery($input) {
        $this->resetPage();
        $this->query = $input;
    }

    public function next() 
    {
        $this->page++;
        $this->nextPage();
    }

    public function previous() 
    {
        $this->page--;
        $this->previousPage();
    }

    public function render()
    {
        $tournaments = Tournament::has('tournamentStandings')->where('name', 'like', '%'.$this->query.'%')->orderBy('date', 'DESC')->paginate(20);
        return view('livewire.show-tournaments', compact('tournaments'));
    }

}
