<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Player;

class ShowPlayer extends Component
{
    use WithPagination;

    public $player;

    public function mount($id) 
    {
        $this->player = Player::find($id);
    }

    public function render()
    {
        return view('livewire.show-player');
    }

}
