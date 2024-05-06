<?php

namespace App\Livewire;

use Livewire\Component;

class Pagniator extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div class="bg-gray-700 mx-auto my-4 rounded-lg px-4 py-1">
            <div class="flex items-center gap-2">

                <button type="button" wire:click="previous" class="{{$page <= 1 ? 'pointer-events-none bg-gray-600 text-gray-500' : ''}} hover:-translate-x-0.5 transition ease-in-out justify-center font-bold text-center text-gray-200 bg-gray-500 rounded-lg w-8 h-8 cursor-pointer items-center flex">
                    <
                </button>

                <button type="button" wire:click="next" class="hover:translate-x-0.5 transition ease-in-out justify-center font-bold text-center text-gray-200 bg-gray-500 rounded-lg w-8 h-8 cursor-pointer items-center flex">
                    >
                </button>            
                <div class="text-gray-200 font-semibold italic text-sm">Page {{$page}}</div>
            </div>
        </div>
        HTML;
    }
}
