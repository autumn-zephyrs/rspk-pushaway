
<div class="w-screen">
    <div class="grid grid-cols-12">

        <div class="col-start-1 col-end-3">
            <div class="w-2/12 fixed h-screen bg-holon-200">
                <div class="py-1 px-2">
                    <h3 class="text-base font-bold my-2 flex items-center text-gray-800">Search Players</h3>
                </div>
                <div class="flex justify-center mx-2">
                    <input type="text" wire:model.live="query" class="h-8 w-11/12 shadow-inner rounded border-holon-400" placeholder="Tord...">
                </div>
            </div>
        </div>

        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 px-8 bg-gray-50 rounded mb-8 pb-4">
            <div class="items-center flex">
                <div class="my-4 flex pagination items-center rounded-lg px-4 py-1">
                    <a href="/players" class="hover:cursor-pointer relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-holon-600 cursor-default leading-5 rounded-md select-none">
                        Back
                    </a>
                </div>
            </div>
            <hr>
            <div class="bg-holon-200 flex-none rounded-lg my-4">
                <div class="px-12 py-4">
                    <div class="flex gap-2 justify-between items-top mb-4">
                        <div class="mb-2">
                            <div class="flex justify-between items-top">
                                <div class="items-center flex gap-2">
                                    <div class="text-2xl font-bold">{{$player->name}}</div>
                                </div>
                            </div>
                            <h2 class="text-base text-gray-600">{{$player->username}}</h2>
                            <div class="">
                                @if($player->country != 'XX')
                                    <img class="h-6 mt-2" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/flags/{{$player->country}}.png"> 
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="">
                        <div class="py-1 text-gray-900 text-lg text-left font-semibold">
                            Latest Tournaments
                        </div>
                        @foreach ($player->tournamentStandings as $index => $standing)
                            @if(!is_null($standing->deck->deckType))
                                <a href="/tournaments/standings/{{$standing->id}}" class="{{($index % 2 === 0) ? 'bg-holon-100' : 'bg-gray-50'}} flex grid grid-cols-10 py-1 flex items-center hover:text-slate-600 text-gray-800">
                                    <div class="flex col-span-4 py-1 items-center align-right gap-2 pl-2">
                                        {{$standing->tournament->name}}
                                    </div>
                                    <div class="col-span-1"> 
                                        {{date("d M y", strtotime($standing->tournament->date))}}
                                    </div>
                                    <div class="text-gray-900 font-semibold text-sm col-span-1 ml-4">
                                        <span>
                                            {{$standing->placement == -1 ? 'DNF' : $standing->placement}} / {{$standing->tournament->players}}
                                        </span>
                                    </div>
                                    <div class="col-span-1">  
                                        {{$standing->winrate[0]}} - {{$standing->winrate[1]}} - {{$standing->winrate[2]}}
                                    </div>
                                    <div class="items-center flex gap-2 justify-between col-span-3 pr-2">
                                        <div class="hover:text-slate-700 ">{{isset($standing->deck->deckType) ? $standing->deck->deckType->name : 'notfound'}}</div>

                                        <div class="flex gap-2">
                                            @if($standing->deck->deckType->icon_primary !== 'substitute')
                                                <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_primary}}.png">
                                                @if($standing->deck->deckType->icon_secondary)
                                                    <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_secondary}}.png">
                                                @endif
                                            @else
                                                <img class="max-h-6" src="/images/substitute.png">
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
