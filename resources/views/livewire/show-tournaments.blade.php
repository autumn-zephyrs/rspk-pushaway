
<div class="w-screen">
    <div class="grid grid-cols-12">

        <div class="col-start-1 col-end-3">
            <div class="w-2/12 fixed  h-screen bg-gray-700">
                <div class="bg-gray-700 my-4 flex pagination items-center rounded-lg px-4 py-1">
                    {{$tournaments->links()}}
                </div>
            </div>
        </div>

        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-6 px-4">

            @foreach ($tournaments as $tournament)
                <div class="bg-gray-100 flex-none rounded-lg my-4">
                    <div class="bg-gray-200 rounded-t-lg w-full h-8 flex items-center px-2 italic drop-shadow-sm">
                    </div>
                    <div class="px-12 py-4">
                        <div class="flex gap-2 justify-between items-top">
                            <div class="items-center gap-2 w-1/4">
                                <a href="/tournaments/{{$tournament->limitless_id}}" class="hover:text-slate-700 text-2xl font-bold mb-2">{{$tournament->name}}</a>
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
                            <div class="w-3/5">
                                <div class="pl-2 py-1 text-gray-900 text-left font-semibold">
                                    Top Standings
                                </div>

                                @foreach ($tournament->topStandings as $index => $standing)
                                    @if(!is_null($standing->deck->deckType))
                                        <div class="text-right text-gray-800">
                                            <a href="/tournaments/standings/{{$standing->id}}" class="{{($index % 2 == 0) ? 'bg-gray-200' : 'bg-gray-100'}} transition-all hover:scale-105 rounded pl-2 hover:text-slate-600 flex py-1 items-center align-right gap-2">
                                                <div class="text-gray-900 font-semibold text-sm">
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
                                                </div>
                                                @if($standing->deck->deckType->icon_primary !== 'substitute')
                                                    <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_primary}}.png">
                                                    @if($standing->deck->deckType->icon_secondary)
                                                        <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_secondary}}.png">
                                                    @endif
                                                @else
                                                    <img class="max-h-6" src="/images/substitute.png">
                                                @endif
                                                {{$standing->player_name}} ({{$standing->player_username}}) @if($standing->country)[{{$standing->country}}]@endif - {{$standing->deck->deckType->name}} 
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                                
                                <a href="/tournaments/{{$tournament->limitless_id}}" class="text-right text-gray-900 hover:text-slate-600">
                                    @if($tournament->players > 8)
                                        {{$tournament->tournamentStandings->count() - 8}} more...
                                    @endif
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
