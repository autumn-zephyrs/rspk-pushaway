
<div class="w-screen">
    <div class="lg:grid lg:grid-cols-12">
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
                                <div class="text-xs">{{$type->decks->count()}} Decks</div>
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
            <div class="items-center">
                <a href="{{ url()->previous() }}" class="my-4 flex pagination items-center rounded-lg px-4 py-1">
                    <span class="hover:cursor-pointer relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-holon-600 cursor-default leading-5 rounded-md select-none">
                        Back
                    </span>
                </a>
            </div>
            <hr>
            <div class="bg-holon-200 flex-none rounded-lg my-4">
                <div class="lg:px-12 px-4 py-4">
                    <div class="mb-2">
                        <div class="flex justify-between items-top">
                            <div class="items-center flex gap-2">
                                <a href="/tournaments/standings/{{$deck->tournamentStanding->id}}" class="hover:text-slate-700 text-2xl font-bold">{{isset($deck->deckType) ? $deck->deckType->name : 'notfound'}}</a>
                                <div class="flex gap-2">
                                    @if($deck->deckType->icon_primary !== 'substitute')
                                        <img class="max-h-8" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$deck->deckType->icon_primary}}.png">
                                        @if($deck->deckType->icon_secondary)
                                            <img class="max-h-8" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$deck->deckType->icon_secondary}}.png">
                                        @endif
                                    @else
                                        <img class="max-h-8" src="/images/substitute.png">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="/players/{{$deck->player->id}}" class="text-base flex items-center gap-2">By {{$deck->player->name}} ({{$deck->player_username}})
                            @if($deck->tournamentStanding->player->country != 'XX')
                            <img class="h-4" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/flags/{{$deck->tournamentStanding->player->country}}.png"> 
                            @endif
                        </a>
                        <h3 class="text-sm">{{$deck->tournamentStanding->placement === -1 ? "DQd" : $deck->tournamentStanding->placement . ' / ' . $deck->tournamentStanding->tournament->players}} in {{$deck->tournamentStanding->tournament->name}} - {{date("dS M Y", strtotime($deck->tournamentStanding->tournament->date))}}</h3>
                    </div>
                    <hr class="">
                    @include('partials/deck')
                </div>
            </div>
        </div>
    </div>
</div>
