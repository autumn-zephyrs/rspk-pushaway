
<div class="w-screen">
    <div class="lg:grid lg:grid-cols-12">
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
                        <a href="" class="{{($index % 2 == 0) ? 'bg-holon-100' : 'bg-holon-50'}} py-2 flex text-gray-800 hover:bg-holon-500 hover:text-gray-100 cursor-pointer px-4 text-base justify-between items-center">
                            <div class="">
                                <div class="text-sm">{{$type->name}}</div>
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
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-start-4 lg:col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 lg:px-8 bg-gray-50 rounded mb-8 pb-4 z-1">
            <div class="items-center lg:px-0 px-4 mb-4">
                <div class="text-xl font-bold lg:mb-0 mb-4">Archetype Data</div>
                <form class="hidden mb-2">
                    <select onchange="" name="identifier" id="identifier" wire:model="identifier">
                        <option wire:click="" value="">All decks</option>
                        @foreach ($types as $type)
                            <option wire:click="" value="{{$type->identifier}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </form>
                <div class="pagination items-center mb-4">
                    {{$archetypes->withQueryString()->links()}}
                </div>
            </div>
            <hr>
            <div class="grid grid-cols-12 px-6 flex items-center">
                <div class="lg:flex text-xs lg:text-sm col-span-6 lg:col-span-4 flex items-center gap-4 py-1">Archetype</div>
                <div class="text-xs lg:text-sm lg:col-span-1 col-span-2 ml-2">Winrate<br> <span class="text-xs text-gray-600">(Yearly)</span></div>
                <div class="text-xs lg:text-sm lg:col-span-1 col-span-2 ml-2">Winrate<br> <span class="text-xs text-gray-600">(All-time)</span></div>
                <div class="text-xs lg:text-sm lg:col-span-1 col-span-2 ml-2">Total Games<br> <span class="text-xs text-gray-600">(Yearly)</span></div>
                <div class="text-xs lg:text-sm lg:col-span-1 col-span-2 ml-2">Total Games<br> <span class="text-xs text-gray-600">(All-time)</span></div>
            </div>
            <hr>
            <div class="overflow-scroll-y h-60">
                @foreach ($archetypes as $index=>$archetype)
                    <div class="border-b-1 hover:bg-holon-200 hover:text-slate-700 grid grid-cols-12 px-6 flex items-center">
                        <div class="text-gray-800 text-sm lg:text-base lg:col-span-4 col-span-6 ml-2 border-holon-400 py-1 flex justify-between items-center">
                            {{$archetype->name}}
                            <div class="flex gap-2 pr-4">
                                @if($archetype->icon_primary !== 'substitute')
                                    <img class="max-h-4 lg:max-h-6" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$archetype->icon_primary}}.png">
                                    @if($archetype->icon_secondary)
                                        <img class="max-h-4 lg:max-h-6" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$archetype->icon_secondary}}.png">
                                    @endif
                                @else
                                    <img class="max-h-4 lg:max-h-6" src="/images/substitute.png">
                                @endif
                            </div>

                        </div>
                        <div class="text-gray-800 text-xs lg:text-base col-span-2 lg:col-span-1 ml-2">{{$archetype->yearlyWinrate}}</div>
                        <div class="text-gray-800 text-xs lg:text-base col-span-2 lg:col-span-1 ml-2">{{$archetype->winrate}}</div>
                        <div class="text-gray-800 text-xs lg:text-base col-span-2 lg:col-span-1 ml-2">{{$archetype->yearlyWins + $archetype->yearlyLosses + $archetype->yearlyTies}}</div>
                        <div class="text-gray-800 text-xs lg:text-base col-span-2 lg:col-span-1 ml-2">{{$archetype->wins + $archetype->losses + $archetype->ties}}</div>
                    </div>
                    <hr>
                @endforeach
            <div>
        </div>
    </div>
</div>
