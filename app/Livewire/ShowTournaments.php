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

    #[Url]
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
        return view('livewire.show-tournaments', [
            'tournaments' => Tournament::has('tournamentStandings')->where('name', 'like', '%'.$this->query.'%')->orderBy('date', 'DESC')->paginate(20),
        ]);
    }

    // public function paginationView()
    // {
    //     return 'livewire.custom-pagination-links';
    // }
}
