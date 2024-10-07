
<div class="w-screen">
    <div class="grid grid-cols-12">

        <div class="col-start-1 col-end-3">

        </div>

        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-6 px-4">
            <div class="bg-gray-100 flex-none rounded-lg my-4">
                <div class="bg-gray-200 rounded-t-lg w-full h-8 flex items-center px-2 italic drop-shadow-sm">
                </div>
                <div class="px-12 py-4">
                    <div class="flex gap-2 justify-between items-top mb-4">
                        <div class="items-center gap-2">
                            <div class="hover:text-slate-700 text-2xl font-bold mb-2">{{$tournament->name}}</div>
                            <h2 class="text-gray-700 italic mt-1 mb-2">{{date("dS M Y", strtotime($tournament->date))}}</h2>
                            <h2>Players: {{$tournament->players}}</h2>
                            <div class="flex items-center gap-2">
                                Winner: {{$tournament->tournamentStandings->first()->player_name}} ({{$tournament->tournamentStandings->first()->player_username}}) - 
                                @if($tournament->tournamentStandings->first()->deck->deckType)
                                    {{$tournament->tournamentStandings->first()->deck->deckType->name}}
                                    @if($tournament->tournamentStandings->first()->deck->deckType->icon_primary !== 'substitute')
                                        <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$tournament->tournamentStandings->first()->deck->deckType->icon_primary}}.png">
                                        @if($tournament->tournamentStandings->first()->deck->deckType->icon_secondary)
                                            <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$tournament->tournamentStandings->first()->deck->deckType->icon_secondary}}.png">
                                        @endif
                                    @else
                                        <img class="max-h-6" src="/images/substitute.png">
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                    </div>
                    <div class="py-1 text-gray-900 text-lg text-left font-semibold">
                        Standings
                    </div>
                    <div class="w-full grid grid-cols-2 gap-x-2 grid-flow-row-dense mb-4">

                        @foreach ($tournament->tournamentStandings as $index => $standing)
                            @if(!is_null($standing->deck->deckType))
                                <a href="/tournaments/standings/{{$standing->id}}" class="{{($index <= $tournament->players/2) ? 'col-start-1 col-end-2' : 'col-start-2'}} {{($index % 2 === 0) ? 'bg-gray-100' : 'bg-gray-200'}} py-1 flex items-center gap-4 transition-all hover:scale-105 rounded pl-2 hover:text-slate-600 text-gray-800">
                                    <div class="text-gray-900 font-semibold text-sm">
                                        <span>
                                            @switch($index+1)
                                                @case(1)
                                                    1st
                                                    @break

                                                @case(2)
                                                    2nd
                                                    @break

                                                @case(3)
                                                    3rd
                                                    @break

                                                @default
                                                    {{$index+1 . 'th'}}
                                            @endswitch
                                        </span>
                                    </div>
                                    <div>
                                        <div class="flex py-1 items-center align-right gap-2">
                                            {{$standing->player_name}} ({{$standing->player_username}}) @if($standing->country)[{{$standing->country}}]@endif
                                            @if($standing->drop)   
                                                <span class="text-gray-400 text-xs">Dropped</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="flex items-center">
                                                @if($standing->deck->deckType->icon_primary !== 'substitute')
                                                    <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_primary}}.png">
                                                    @if($standing->deck->deckType->icon_secondary)
                                                        <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_secondary}}.png">
                                                    @endif
                                                @else
                                                    <img class="max-h-6" src="/images/substitute.png">
                                                @endif
                                            </span>
                                            <span>
                                                {{$standing->deck->deckType->name}} 
                                            </span>   
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <div x-data="{ round:  1 }">
                        <div class="flex items-center gap-4">
                            <div class="py-1 text-gray-900 text-lg text-left font-semibold mb-2">
                                Pairings
                            </div>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= $tournament->tournamentPairings->sortByDesc('round')->first()->round; $i++)
                                    <button @click="round = {{$i}}" class="text-sm p-1 bg-gray-800 rounded-lg text-gray-100 font-bold hover:scale-105 transition-all">R{{$i}}</button>
                                @endfor
                            </div>
                        </div>
                        <div class="w-1/2">
                            @foreach ($tournament->tournamentPairings->sortBy('match')->sortBy('round') as $index => $pairing)
                                @if($pairing->phase === 1)
                                    <div x-show="round === {{$pairing->round}}" class="{{($index % 2 === 0) ? 'bg-gray-100' : 'bg-gray-200'}}  rounded pl-2 text-gray-800 grid grid-cols-12">
                                        <div class="col-start-1 col-end-1 text-sm font-bold items-center flex">
                                            @if($pairing->table)T{{$pairing->table}}@endif
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
                                @else
                                    <div x-show="round === {{$pairing->round}}" class="rounded pl-2 text-gray-800 grid grid-cols-12">
                                        <div class="col-start-1 col-end-1 text-sm font-bold items-center flex">
                                            {{$pairing->match}}
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
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
