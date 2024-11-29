
<div class="w-screen">
    <div class="grid grid-cols-12">

        <div class="col-start-1 col-end-3">
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
                        <div wire:click="setIdentifier('{{$type->identifier}}')" class="{{($index % 2 == 0) ? 'bg-holon-100' : 'bg-holon-50'}} text-gray-800 hover:bg-holon-500 hover:text-gray-100 cursor-pointer px-4 text-base">
                            <div  class="justify-between flex items-center gap-1">
                                <div class="">
                                    <div class="text-sm">{{$type->name}}</div>
                                    <div class="text-xs">{{$type->decks->count()}} Decks</div>
                                </div>
                                <div class="flex gap-2">
                                    @if($type->icon_primary !== 'substitute')
                                        <img class="h-6 aspect-square" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$type->icon_primary}}.png">
                                        @if($type->icon_secondary)
                                            <img class="h-6 aspect-square" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$type->icon_secondary}}.png">
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
                        <input type="text" wire:model.live="query" class="h-8 w-11/12 shadow-inner rounded border-holon-400" placeholder="jklacz...">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 px-8 bg-gray-50 rounded mb-8 pb-4">
            <div class="items-center">
                <div class="text-xl font-bold">Latest Decks</div>
                <div class="pagination items-center mb-4">
                    {{$decks->withQueryString()->links()}}
                </div>
            </div>
            <hr>
            <div>
                @foreach ($decks as $index => $deck)
                    @if ($index === 0 || $decks[$index]->tournamentStanding->tournament->id != $decks[$index-1]->tournamentStanding->tournament->id )
                        <div class="bg-holon-300 py-1 px-4">
                            <a href="/tournaments/{{$decks[$index]->tournamentStanding->tournament->limitless_id}}" class="text-sm font-bold flex items-center text-gray-800"> {{$deck->tournamentStanding->tournament->name}} - {{date("dS M Y", strtotime($deck->tournamentStanding->tournament->date))}}</a>
                        </div>
                    @endif
                    <div class="{{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}} hover:bg-holon-200 flex-none hover:text-slate-700 hover:cursor-pointer ">
                        <a href="/decks/{{$deck->id}}" class="grid grid-cols-10 px-6">
                            <div class="col-span-5 flex items-center gap-4 border-r border-holon-400 py-1">
                                <div class="items-center flex gap-2">
                                    <div class="text-base">{{isset($deck->deckType) ? $deck->deckType->name : 'notfound'}}</div>
                                    <div class="flex gap-2">
                                        @if($deck->deckType->icon_primary !== 'substitute')
                                            <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$deck->deckType->icon_primary}}.png">
                                            @if($deck->deckType->icon_secondary)
                                                <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$deck->deckType->icon_secondary}}.png">
                                            @endif
                                        @else
                                            <img class="max-h-6" src="/images/substitute.png">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1 ml-2 flex items-center text-gray-800">{{$deck->tournamentStanding->placement === -1 ? "DNF" : $deck->tournamentStanding->placement . ' / ' . $deck->tournamentStanding->tournament->players}} </div>
                            <h2 class="col-span-3 flex items-center text-gray-800">
                                {{$deck->player->name}} ({{$deck->player_username}})
                                
                            </h2>
                        </a>
                    </div>
                @endforeach
            <div>
        </div>
    </div>
</div>
