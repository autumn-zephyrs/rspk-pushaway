<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeckType;

class ShowArchetypes extends Component
{

    use WithPagination;

    public function mount() 
    {

    }

    public function render()
    {
       
        $archetypes = DeckType::has('decks')->get()->sortByDesc(function($deckType){
            return $deckType->yearlyWinrate->percentage;
        });

        $types = DeckType::has('decks')->orderBy('name', 'ASC')->get();
        
        return view('livewire.show-archetypes', compact('types', 'archetypes'));
    }
}
