
<div class="w-screen">
    <div class="lg:grid lg:grid-cols-12">
        <div class="hidden lg:flex col-start-1 col-end-3">
            <div class="w-2/12 fixed h-screen bg-holon-200">
                <div class="py-1 px-2">
                    <h3 class="text-base font-bold my-2 flex items-center text-gray-800">Deck Archetypes</h3>
                </div>
                <hr>
                <div class="flex-1 bg-holon-50 overflow-auto h-1/2 shadow-inner">
                    <a href="/archetypes" class="flex cursor-pointer py-2 px-4 text-base text-sm text-gray-800 hover:text-gray-100 hover:bg-holon-500 py-2 bg-holon-50">All archetypes</a>
                    <hr>
                    <div class="divide-y overflow-scroll-y divide-holon-200">
                        @foreach($types as $index => $type)
                        <a href="/archetypes/{{$type->id}}" class="{{($index % 2 == 0) ? 'bg-holon-100' : 'bg-holon-50'}} py-2 flex text-gray-800 hover:bg-holon-500 hover:text-gray-100 cursor-pointer px-4 text-base justify-between items-center">
                            <div class="">
                                <div class="text-sm">{{$type->name}}</div>
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
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-start-4 lg:col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 lg:px-8 bg-gray-50 rounded mb-8 pb-4 z-1">
            <div class="items-center lg:px-0 px-4 mb-4">
                <div class="text-xl font-bold lg:mb-0 mb-4">Archetype Data</div>
                <form wire:submit="redirect" class="hidden lg:hidden flex mb-2">
                    <select name="identifier" id="identifier" wire:model="identifier">
                        <option wire:click="" value="">All decks</option>
                        @foreach ($types as $type)
                            <option value="{{$type->identifier}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <hr>
            <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 lg:px-8 px-4 bg-gray-50 rounded mb-8 pb-4">
                <div class="items-center">
                    <a href="/archetypes" class="my-4 flex pagination items-center rounded-lg px-4 py-1">
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
                                <div class="items-center flex gap-2 mb-4">
                                    <a href="/decks/?identifier={{$archetype->identifier}}" class="hover:text-slate-700 text-2xl font-bold">{{$archetype->name}}</a>
                                    <div class="flex gap-2">
                                        @if($archetype->icon_primary !== 'substitute')
                                            <img class="max-h-8" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$archetype->icon_primary}}.png">
                                            @if($archetype->icon_secondary)
                                                <img class="max-h-8" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$archetype->icon_secondary}}.png">
                                            @endif
                                        @else
                                            <img class="max-h-8" src="/images/substitute.png">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr class="" >
                        </div>
                        <div class="lg:grid lg:grid-cols-3 gap-4  divide-x-2 divide-gray-400">
                            <div class="lg:col-span-1">
                                <div class="text-xs lg:text-sm text-gray-800 flex justify-between py-1">
                                    <div>Yearly Winrate: </div>
                                    <div>{{$archetype->yearlyWinrate->percentage}}</div>
                                </div>
                                <div class="text-xs lg:text-sm text-gray-800 flex justify-between py-1">
                                    <div>All-time Winrate: </div>
                                    <div>{{$archetype->winrate->percentage}}</div>
                                </div>
                                <div class="text-xs lg:text-sm text-gray-800 flex justify-between py-1">
                                    <div>Yearly W/L/T: </div>
                                    <div>{{$archetype->yearlyWinrate->wins}} / {{$archetype->yearlyWinrate->losses}} / {{$archetype->yearlyWinrate->ties}}</div>
                                </div>
                                <div class="text-xs lg:text-sm text-gray-800 flex justify-between py-1">
                                    <div>All-time W/L/T: </div>
                                    <div>{{$archetype->winrate->wins}} / {{$archetype->winrate->losses}} / {{$archetype->winrate->ties}}</div>
                                </div>
                                <div class="lg:hidden block text-xs lg:text-sm text-gray-800 flex justify-between items-center">
                                    <div>Yearly Best Finish:</div>
                                    @if ($archetype->yearlyBestFinish)
                                        <div>
                                            <div class="pt-1 text-xs lg:text-sm">
                                                {{$archetype->yearlyBestFinish->tournamentStanding->placement}} / {{$archetype->yearlyBestFinish->tournament->players}} - {{$archetype->yearlyBestFinish->player->name ? $archetype->yearlyBestFinish->player->name : $archetype->bestFinish->player->name}}
                                            </div>
                                            <div class="pb-1 text-gray-600 text-xs">
                                                @ {{$archetype->yearlyBestFinish->tournament->name}} - {{date("d M y", strtotime($archetype->yearlyBestFinish->tournament->date))}}
                                            </div>
                                        </div>
                                    @else
                                        <div>
                                            <div class="pt-1">
                                                None this year
                                            </div>
                                            <div class="pb-1 text-gray-600 text-xs">
                                                (Maybe next year!)
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="lg:hidden block text-xs lg:text-sm text-gray-800 flex justify-between items-center">
                                    <div>All-time Best Finish:</div>
                                    <div>
                                        <div class="pt-1 text-xs lg:text-sm">
                                            {{$archetype->bestFinish->tournamentStanding->placement}} / {{$archetype->bestFinish->tournament->players}} - {{$archetype->bestFinish->player->name ? $archetype->bestFinish->player->name : $archetype->bestFinish->player->name}}
                                        </div>
                                        <div class="pb-1 text-gray-600 text-xs">
                                            @ {{$archetype->bestFinish->tournament->name}} - {{date("d M y", strtotime($archetype->bestFinish->tournament->date))}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden lg:block lg:col-span-2 pl-2">
                                <div class="text-xs lg:text-sm text-gray-800 flex justify-between">
                                    <div>Yearly Best Finish:</div>
                                    @if ($archetype->yearlyBestFinish)
                                        <div>
                                            <div class="pt-1">
                                                {{$archetype->yearlyBestFinish->tournamentStanding->placement}} / {{$archetype->yearlyBestFinish->tournament->players}} - {{$archetype->yearlyBestFinish->player->name ? $archetype->yearlyBestFinish->player->name : $archetype->bestFinish->player->name}}
                                            </div>
                                            <div class="pb-1 text-gray-600 text-xs">
                                                @ {{$archetype->yearlyBestFinish->tournament->name}} - {{date("d M y", strtotime($archetype->yearlyBestFinish->tournament->date))}}
                                            </div>
                                        </div>
                                    @else
                                        <div>
                                            <div class="pt-1">
                                                None this year
                                            </div>
                                            <div class="pb-1 text-gray-600 text-xs">
                                                (Maybe next year!)
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-xs lg:text-sm text-gray-800 flex justify-between">
                                    <div>All-time Best Finish:</div>
                                    <div>
                                        <div class="pt-1">
                                            {{$archetype->bestFinish->tournamentStanding->placement}} / {{$archetype->bestFinish->tournament->players}} - {{$archetype->bestFinish->player->name ? $archetype->bestFinish->player->name : $archetype->bestFinish->player->name}}
                                        </div>
                                        <div class="pb-1 text-gray-600 text-xs">
                                            @ {{$archetype->bestFinish->tournament->name}} - {{date("d M y", strtotime($archetype->bestFinish->tournament->date))}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            @foreach($types as $index => $type) 
                                <div class="{{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}} grid grid-cols-9 flex items-center">
                                    <div class="pl-3 text-gray-800 text-sm lg:text-sm lg:col-span-4 col-span-6 ml-2 border-holon-400 flex justify-between items-center">
                                        {{$type->name}}
                                        <div class="flex gap-2 pr-2">
                                            @if($type->icon_primary !== 'substitute')
                                                <img class="max-h-4 lg:max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$type->icon_primary}}.png">
                                                @if($type->icon_secondary)
                                                    <img class="max-h-4 lg:max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$type->icon_secondary}}.png">
                                                @endif
                                            @else
                                                <img class="max-h-4 lg:max-h-6" src="/images/substitute.png">
                                            @endif
                                        </div>
                                    </div>
                                    @if ($matchups[$type->identifier] === null)
                                        <div class="text-xs lg:text-sm col-span-3 lg:col-span-5 pl-2 py-1 border-l-2 border-holon-400">{{'No data'}}</div>
                                    @elseif ($matchups[$type->identifier] >= 75)
                                        <div class="text-xs lg:text-sm col-span-3 lg:col-span-5 pl-2 py-1 border-l-2 border-holon-400 bg-green-200/75">{{$matchups[$type->identifier]}}%</div>
                                    @elseif (($matchups[$type->identifier] < 75) && ($matchups[$type->identifier] >= 55))
                                        <div class="text-xs lg:text-sm col-span-3 lg:col-span-5 pl-2 py-1 border-l-2 border-holon-400 bg-green-100/75">{{$matchups[$type->identifier]}}%</div>
                                    @elseif ($matchups[$type->identifier] < 55 && $matchups[$type->identifier] >= 45)
                                        <div class="text-xs lg:text-sm col-span-3 lg:col-span-5 pl-2 py-1 border-l-2 border-holon-400 bg-yellow-100/50">{{$matchups[$type->identifier]}}%</div>
                                    @elseif ($matchups[$type->identifier] < 45 && $matchups[$type->identifier] >= 35)
                                        <div class="text-xs lg:text-sm col-span-3 lg:col-span-5 pl-2 py-1 border-l-2 border-holon-400 bg-red-100/60">{{$matchups[$type->identifier]}}%</div>
                                    @elseif ($matchups[$type->identifier] < 35)
                                        <div class="text-xs lg:text-sm col-span-3 lg:col-span-5 pl-2 py-1 border-l-2 border-holon-400 bg-red-200/75">{{$matchups[$type->identifier]}}%</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
