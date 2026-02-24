
<div class="w-screen">
    <div class="lg:grid lg:grid-cols-12">
        <!-- This is the left panel section -->
        <div class="hidden lg:flex col-start-1 col-end-3">
            <div class="w-2/12 fixed h-screen bg-holon-200">
                <div class="py-1 px-2">
                    <h3 class="text-base font-bold my-2 flex items-center text-gray-800">Deck Archetypes</h3>
                </div>
                <hr>
                <div class="flex-1 bg-holon-50 overflow-auto h-1/2 shadow-inner">
                    <a href="/decks/?page=1">
                        <div class="cursor-pointer px-4 text-base text-sm text-gray-800 hover:text-gray-100 hover:bg-holon-500 py-2 bg-holon-50">All decks</div>
                    </a>
                    <hr>
                    <div class="divide-y overflow-scroll-y divide-holon-200">
                        @foreach($types as $index => $type)

                        <a href="/decks/?page=1&identifier={{$type->identifier}}" class="{{($index % 2 == 0) ? 'bg-holon-100' : 'bg-holon-50'}} flex items-center justify-between text-gray-800 hover:bg-holon-500 hover:text-gray-100 cursor-pointer px-4 text-base">
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
                        </a>
                        @endforeach
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 lg:px-8 px-4 bg-gray-50 rounded mb-8 pb-4">
            <div class="items-center flex">
                <div  x-on:click="open = false" x-show="open != false"  class="my-4 flex pagination items-center rounded-lg lg:px-4 px-2 py-1">

                </div>
                <div class="text-sm text-gray-600">
                    <a href="/tournaments/{{$standing->tournament->limitless_id}}" class="hover:text-holon-500">{{$standing->tournament->name}}</a> -> {{$standing->player->name}}
                </div>
            </div>
            <div x-data="{ page: 'decklist' }" class="bg-holon-200 flex-none rounded-lg my-4">
                <div class="lg:px-12 px-4 py-4">
                    <div class="flex gap-2 justify-between items-top mb-4">
                        <div class="items-center gap-2">
                            <a href="/players/{{$standing->player->id}}" class="hover:text-slate-700 text-2xl font-bold mb-2">{{$standing->player->name}} ({{$standing->player_username}})</a>
                            <div class="items-center flex gap-2">
                                <a href="/decks?identifier={{$standing->identifier}}" class="hover:text-slate-700  text-lg font-semibold">{{isset($standing->deckType) ? $standing->deckType->name : 'notfound'}}</a>
                                <div class="flex gap-2">
                                    @if($standing->deckType->icon_primary !== 'substitute')
                                        <img class="max-h-8" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$standing->deckType->icon_primary}}.png">
                                        @if($standing->deckType->icon_secondary)
                                            <img class="max-h-8" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$standing->deckType->icon_secondary}}.png">
                                        @endif
                                    @else
                                        <img class="max-h-8" src="/images/substitute.png">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="items-center gap-2">
                            <a href="/tournaments/{{$standing->tournament->limitless_id}}" class="hover:text-slate-700 text-lg font-bold mb-2">{{$standing->tournament->name}}</a>
                            <h2 class="text-gray-700 italic text-sm mt-1 mb-2">{{date("dS M Y", strtotime($standing->tournament->date))}}</h2>
                        </div>
                    </div>
                    <div class="flex gap-2 mb-4">
                        <div x-on:click="page = 'pairings'" class="px-2 cursor-pointer text-sm p-1 bg-holon-700 rounded-lg text-gray-100 font-bold hover:scale-105 transition-all">Pairings</div>
                        <div x-on:click="page = 'decklist'" class="px-2 cursor-pointer text-sm p-1 bg-holon-700 rounded-lg text-gray-100 font-bold hover:scale-105 transition-all">Decklist</div>
                    </div>
                    <div x-show="page == 'pairings'">
                        <div class="py-1 text-gray-900 text-lg text-left font-semibold">
                            Pairings
                        </div>
                        <div class="grid mb-4 x">
                            @foreach($pairings as $index => $pairing)
                                <div class="{{($index % 2 === 0) ? 'bg-holon-50' : 'bg-holon-100'}}  rounded pl-2 text-gray-800 grid grid-cols-12">
                                    <div class="col-start-1 col-end-1 text-sm font-bold items-center flex">
                                        @if($pairing->table)R{{$pairing->round}}@else{{$pairing->match}}@endif
                                    </div>
                                    <div class="col-start-2 col-end-12">
                                        @if ($pairing->winner === '-1')
                                            <div class="flex justify-between py-1 px-4 items-center align-right gap-2 py-1">
                                                <span class="font-semibold text-left text-red-700">{{$pairing->player_1}}</span>
                                                <span class="text-gray-600 text-center italic ">Loss</span>
                                            </div>
                                        @elseif (($pairing->winner === $pairing->player_1) && ($pairing->player_2 === null))
                                            <div class="flex justify-between py-1 px-4 items-center align-right gap-2 py-1">
                                                <span class="font-semibold text-left text-green-700">{{$pairing->player_1}}</span>
                                                <span class="text-gray-600 text-center italic ">Bye</span>
                                            </div>
                                        @else
                                            <div class="flex justify-between py-1 px-4 items-center align-right gap-2 py-1">
                                                <span class="{{($pairing->winner === 0) ? 'text-yellow-700' : (($pairing->winner === $pairing->player_1) ? 'text-green-700' : 'text-red-700')}} font-semibold w-1/3 text-left">{{$pairing->player_1}}</span> 
                                                <span class="text-gray-600 text-center italic w-1/3">vs</span> 
                                                <span class="{{($pairing->winner === 0) ? 'text-yellow-700' : (($pairing->winner === $pairing->player_2) ? 'text-green-700' : 'text-red-700')}} font-semibold w-1/3 text-right">{{$pairing->player_2}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div x-show="page == 'decklist'">
                        @include('partials/deck')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
