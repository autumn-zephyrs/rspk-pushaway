
<div class="w-screen">
    <div class="lg:grid lg:grid-cols-12">
        <div class="hidden lg:flex col-start-1 col-end-3">
            <div class="w-2/12 fixed h-screen bg-holon-200">

            </div>
        </div>

        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 lg:px-8 px-4 bg-gray-50 rounded mb-8 pb-4">
            <div class="items-center flex">
                <div x-on:click="open = false" x-show="open != false"  class="lg:my-4 flex pagination items-center rounded-lg lg:px-4 px-1 py-1">
                    <a href="/tournaments" class="hover:cursor-pointer relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-holon-600 cursor-default leading-5 rounded-md select-none">
                        Back
                    </a>
                </div>
                <div class="text-sm text-gray-600">
                    {{$tournament->name}}
                </div>
            </div>
            <div x-data="{ page: 'standings' }" class="bg-holon-200 flex-none rounded-lg my-4">
                <div class="lg:px-12 px-4 py-4">
                    <div class="flex gap-2 justify-between items-top mb-4">
                        <div class="items-center gap-2">
                            <div class="mb-2">
                                <div class="flex justify-between items-top">
                                    <div class="items-center flex gap-2">
                                        <div href="" class="hover:text-slate-700 text-2xl font-bold">{{$tournament->name}}</div>
                                    </div>
                                </div>
                                <h2 class="text-base">{{date("dS M Y", strtotime($tournament->date))}}</h2>
                                <h3 class="text-sm text-gray-600">{{$tournament->players}} Players</h3>
                            </div>
                            <div class="flex items-center gap-2">
                                Winner: {{$tournament->winner->player->name}} ({{$tournament->winner->player_username}})
                                @if($tournament->winner->player->country != 'XX')
                                    <img class="h-4" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/flags/{{$tournament->winner->player->country}}.png"> 
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
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
                    <div class="flex gap-2 mb-4">
                        <div x-on:click="page = 'standings'" class="px-2 cursor-pointer text-xs lg:text-sm p-1 bg-holon-700 rounded-lg text-gray-100 font-bold hover:scale-105 transition-all">Standings</div>
                        <div x-on:click="page = 'pairings'" class="px-2 cursor-pointer text-xs lg:text-sm p-1 bg-holon-700 rounded-lg text-gray-100 font-bold hover:scale-105 transition-all">Pairings</div>
                        <div x-on:click="page = 'metagame'" class="px-2 cursor-pointer text-xs lg:text-sm p-1 bg-holon-700 rounded-lg text-gray-100 font-bold hover:scale-105 transition-all">Metagame</div>
                    </div>
                    <hr>
                    <div  x-show="page == 'standings'" class="">
                        <div class="py-1 text-gray-900 text-lg text-left font-semibold">
                            Standings
                        </div>
                        @foreach ($tournament->tournamentStandings as $index => $standing)
                            @if(!is_null($standing->deck->deckType))
                                <a href="/tournaments/standings/{{$standing->id}}" class="{{($index % 2 === 0) ? 'bg-holon-100' : 'bg-gray-50'}} flex grid grid-cols-10 py-1 flex items-center hover:text-slate-600 text-gray-800">
                                    <div class="text-xs lg:text-base text-gray-900 font-semibold text-sm col-span-1 pl-2">
                                        <span>
                                            {{$index+1}}
                                        </span>
                                    </div>
                                    <div class="text-xs lg:text-base flex col-span-3 py-1 items-center align-right gap-2">
                                        {{$standing->player->name}}
                                        @if($standing->drop)   
                                            <span class="text-gray-400 text-xs">Dropped</span>
                                        @endif
                                    </div>
                                    <div class="text-xs lg:text-base col-span-1"> 
                                        @if($standing->player->country != 'XX')
                                            <img class="h-3 lg:h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/flags/{{$standing->player->country}}.png"> 
                                        @endif
                                    </div>
                                    <div class="hidden lg:flex text-xs lg:text-base col-span-1">  
                                        {{$standing->winrate[0]}} - {{$standing->winrate[1]}} - {{$standing->winrate[2]}}
                                    </div>
                                    <div class="lg:hidden flex text-xs lg:text-base col-span-1">  
                                        {{$standing->winrate[0]}}-{{$standing->winrate[1]}}-{{$standing->winrate[2]}}
                                    </div>
                                    <div class="text-xs lg:text-base items-center flex gap-2 justify-between col-span-4 pr-2">
                                        <div class="hover:text-slate-700 ">{{isset($standing->deck->deckType) ? $standing->deck->deckType->name : 'notfound'}}</div>

                                        <div class="flex gap-2">
                                            @if($standing->deck->deckType->icon_primary !== 'substitute')
                                                <img class="max-h-3 lg:max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_primary}}.png">
                                                @if($standing->deck->deckType->icon_secondary)
                                                    <img class="max-h-3 lg:max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_secondary}}.png">
                                                @endif
                                            @else
                                                <img class="max-h-3 lg:max-h-6" src="/images/substitute.png">
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                        @foreach ($tournament->drops as $index => $standing)
                            @if(!is_null($standing->deck->deckType))
                                <a href="/tournaments/standings/{{$standing->id}}" class="{{($index % 2 === 0) ? 'bg-holon-100' : 'bg-gray-50'}} flex grid grid-cols-10 py-1 flex items-center hover:text-slate-600 text-gray-800">
                                    <div class="text-xs lg:text-base text-gray-900 font-semibold text-sm col-span-1 pl-2">
                                        
                                    </div>
                                    <div class="text-xs lg:text-base flex col-span-3 py-1 items-center align-right gap-2">
                                        {{$standing->player->name}}
                                        @if($standing->drop)   
                                            <span class="hidden lg:flex text-gray-400 text-xs">Dropped</span>
                                            <span class="lg:hidden flex text-gray-400 text-xs">D</span>
                                        @endif
                                    </div>
                                    <div class="text-xs lg:text-base col-span-1">  
                                        @if($standing->player->country != 'XX')
                                            <img class="h-3 lg:h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/flags/{{$standing->player->country}}.png"> 
                                        @endif
                                    </div>
                                    <div class="hidden lg:flex text-xs lg:text-base col-span-1">  
                                        {{$standing->winrate[0]}} - {{$standing->winrate[1]}} - {{$standing->winrate[2]}}
                                    </div>
                                    <div class="lg:hidden flex text-xs lg:text-base col-span-1">  
                                        {{$standing->winrate[0]}}-{{$standing->winrate[1]}}-{{$standing->winrate[2]}}
                                    </div>
                                    <div class="text-xs lg:text-base items-center flex gap-2 justify-between col-span-4 pr-2">
                                        <div class="hover:text-slate-700 ">{{isset($standing->deck->deckType) ? $standing->deck->deckType->name : 'notfound'}}</div>

                                        <div class="flex gap-2">
                                            @if($standing->deck->deckType->icon_primary !== 'substitute')
                                                <img class="max-h-3 lg:max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_primary}}.png">
                                                @if($standing->deck->deckType->icon_secondary)
                                                    <img class="max-h-3 lg:max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_secondary}}.png">
                                                @endif
                                            @else
                                                <img class="max-h-3 lg:max-h-6" src="/images/substitute.png">
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <div x-show="page == 'pairings'" x-data="{ round:  1 }">
                        <div class="flex items-center gap-4">
                            <div class="py-1 text-gray-900 text-lg text-left font-semibold mb-2">
                                Pairings
                            </div>
                            <div class="flex lg:gap-2 gap-1">
                                @for($i = 1; $i <= $tournament->tournamentPairings->sortByDesc('round')->first()->round; $i++)
                                    <button @click="round = {{$i}}" class="text-xs lg:text-sm p-1 bg-gray-800 rounded-lg text-gray-100 font-bold hover:scale-105 transition-all">R{{$i}}</button>
                                @endfor
                            </div>
                        </div>
                        <div class="w-full">
                            @foreach ($tournament->tournamentPairings->sortBy('match')->sortBy('round') as $index => $pairing)
                                @if($pairing->phase === 1)
                                    <div x-show="round === {{$pairing->round}}" class="{{($index % 2 === 0) ? 'bg-holon-100' : 'bg-gray-50'}} rounded pl-2 text-gray-800 grid grid-cols-12 text-xs lg:text-base">
                                        <div class="col-start-1 col-end-1 text-xs lg:text-sm font-bold items-center flex">
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
                                    <div x-show="round === {{$pairing->round}}" class="rounded pl-2 text-gray-800 grid grid-cols-12 text-xs lg:text-base">
                                        <div class="col-start-1 col-end-1 text-xs lg:text-sm font-bold items-center flex">
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
