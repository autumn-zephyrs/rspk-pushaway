
<div class="w-screen">
    <div class="lg:grid lg:grid-cols-12">
        <div class="hidden lg:flex col-start-1 col-end-3">
            <div class="w-2/12 fixed h-screen bg-holon-200">
                <div class="py-1 px-2">
                    <h3 class="text-base font-bold my-2 flex items-center text-gray-800">Search Tournaments</h3>
                </div>
                <div class="flex justify-center mx-2">
                    <input type="text" wire:model.live="query" class="h-8 w-11/12 shadow-inner rounded border-holon-400" placeholder="Stambler...">
                </div>
            </div>
        </div>

        <div class="lg:col-start-4 lg:col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 lg:px-8 px-4 bg-gray-50 rounded mb-8 pb-4 z-1">
            <div class="items-center lg:px-0 px-4">
                <div class="text-xl font-bold lg:mb-0 mb-2">Latest Tournaments</div>
                <form class="lg:hidden flex mb-2">
                    <input type="text" name="query" id="query" wire:model="query" placeholder="Stambler...">
                </form>  
                <div class="pagination items-center mb-4">
                    {{$tournaments->links()}}
                </div>
            </div>
            <div class="grid grid-cols-10 lg:px-6 flex items-center">
                <div class="text-xs lg:text-sm col-span-1 flex items-center gap-4 py-1">Date</div>
                <div class="text-xs lg:text-sm col-span-5 ml-2">Name</div>
                <div class="hidden lg:flex text-xs lg:text-sm col-span-1 ml-2">Players</div>
                <div class="text-xs lg:text-sm lg:col-span-3 col-span-4 ml-2f flex items-center justify-between">Winner</div>
            </div>
            <hr>
            @foreach ($tournaments as $index=>$tournament)
                <a href="/tournaments/{{$tournament->limitless_id}}" class="{{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}} hover:bg-holon-200 hover:text-slate-700 hover:cursor-pointer grid grid-cols-10 lg:px-6 flex items-center">
                    <div class="text-xs lg:text-base col-span-1 flex items-center gap-4">{{date("d M y", strtotime($tournament->date))}}</div>
                    <div class="text-xs lg:text-base col-span-5 ml-2 border-r border-holon-400 py-1">{{$tournament->name}}</div>
                    <div class="hidden lg:flex text-xs lg:text-base col-span-1 ml-2">{{$tournament->players}}</div>
                    <div class="lg:flex hidden text-sm lg:text-base col-span-1 ml-2">
                        @if($tournament->winner->player->country != 'XX')
                            <img class="h-4" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/flags/{{$tournament->winner->player->country}}.png"> 
                        @endif
                    </div>
                    <div class="lg:col-span-2 col-span-3 ml-f flex items-center justify-between">
                        <div class="text-xs lg:text-base flex items-center justify-between">
                            {{$tournament->winner->player->name}}
                        </div>
                        <div class="flex gap-2">
                            @if($tournament->winner->deck->deckType)
                                @if($tournament->winner->deck->deckType->icon_primary !== 'substitute')
                                    <img class="max-h-3 lg:max-h-4" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$tournament->winner->deck->deckType->icon_primary}}.png">
                                    @if($tournament->winner->deck->deckType->icon_secondary)
                                        <img class="max-h-3 lg:max-h-4" src="https://r2.limitlesstcg.net/pokemon/gen9/{{$tournament->winner->deck->deckType->icon_secondary}}.png">
                                    @endif
                                @else
                                    <img class="max-h-3 lg:max-h-4" src="/images/substitute.png">
                                @endif
                            @else
                                <img class="max-h-3 lg:max-h-4" src="https://r2.limitlesstcg.net/pokemon/gen9/unown.png">
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
