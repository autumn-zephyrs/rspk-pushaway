<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Player;

class ShowPlayers extends Component
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

    public function previous() 
    {
        $this->page--;
        $this->previousPage();
    }

    public function render()
    {
        return view('livewire.show-players', [
            'players' => Player::where('name', 'like', '%'.$this->query.'%')->orWhere('username', 'like', '%'.$this->query.'%')->orderBy('name', 'asc')->paginate(30),
        ]);
    }

}
