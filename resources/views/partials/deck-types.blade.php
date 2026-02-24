<div class="hidden lg:flex col-start-1 col-end-3">
    <div class="w-2/12 fixed h-screen bg-holon-200">
        <div class="py-1 px-2">
            <h3 class="text-base font-bold my-2 flex items-center text-gray-800">Deck Archetypes</h3>
        </div>
        <hr>
        <div class="flex-1 bg-holon-50 overflow-auto h-1/2 shadow-inner">
            <div wire:click="setIdentifier(null)" class="cursor-pointer px-4 text-base text-sm text-gray-800 hover:text-gray-100 hover:bg-holon-500 py-2 bg-holon-50">All decks</div>
            <hr>
            <div class="divide-y overflow-scroll-y divide-holon-200">
                @foreach($types as $index => $type)
                <div wire:click="setIdentifier('{{$type->identifier}}')" wire:change="setIdentifier('{{$type->identifier}}')" class="{{($index % 2 == 0) ? 'bg-holon-100' : 'bg-holon-50'}} text-gray-800 hover:bg-holon-500 hover:text-gray-100 cursor-pointer px-4 text-base">
                    <div  class="justify-between flex items-center gap-1">
                        <div class="">
                            <div class="text-sm">{{$type->name}}</div>
                            <div class="text-xs">{{$type->tournamentStandings->count()}} Decks</div>
                        </div>
                        <div class="flex gap-2">
                            @if($type->icon_primary !== 'substitute')
                                <img class="h-6 aspect-square" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$type->icon_primary}}.png">
                                @if($type->icon_secondary)
                                    <img class="h-6 aspect-square" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$type->icon_secondary}}.png">
                                @endif
                            @else
                                <img class="max-h-6" src="/images/substitute.png">
                            @endif
                        </div>
                </div>
                    
                </div>
                @endforeach
            </div>
        </div>
        <div class="mt-2">
            <div class="py-1 px-2">
                <h3 class="text-base font-bold my-2 flex items-center text-gray-800">Search by Username</h3>
            </div>
            <div class="flex justify-center mx-2">
                <input type="text" wire:change.live="search()" wire:model.live="query" class="h-8 w-11/12 shadow-inner rounded border-holon-400" placeholder="jklacz...">
            </div>
        </div>
    </div>
</div>