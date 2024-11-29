
<div class="w-screen">
    <div class="grid grid-cols-12">

        <div class="col-start-1 col-end-3">
            <div class="w-2/12 fixed h-screen bg-holon-200">
                <div class="py-1 px-2">
                    <h3 class="text-base font-bold my-2 flex items-center text-gray-800">Search Tournaments</h3>
                </div>
                <div class="flex justify-center mx-2">
                    <input type="text" wire:model.live="query" class="h-8 w-11/12 shadow-inner rounded border-holon-400" placeholder="Stambler...">
                </div>
            </div>
        </div>

        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-4 px-8 bg-gray-50 rounded mb-8 pb-4">
            <div class="items-center">
                <div class="text-xl font-bold">Latest Tournaments</div>
                <div class="pagination items-center mb-4">
                    {{$tournaments->links()}}
                </div>
            </div>
            <div class="grid grid-cols-10 px-6 flex items-center">
                <div class="col-span-1 flex items-center gap-4 py-1">Date</div>
                <div class="col-span-5 ml-2">Name</div>
                <div class="col-span-1 ml-2">Players</div>
                <div class="col-span-3 ml-2f flex items-center justify-between">Winner</div>
            </div>
            <hr>
            @foreach ($tournaments as $index=>$tournament)
                <a href="/tournaments/{{$tournament->limitless_id}}" class="{{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}} hover:bg-holon-200 hover:text-slate-700 hover:cursor-pointer grid grid-cols-10 px-6 flex items-center">
                    <div class="col-span-1 flex items-center gap-4">{{date("d M y", strtotime($tournament->date))}}</div>
                    <div class="col-span-5 ml-2 border-r border-holon-400 py-1">{{$tournament->name}}</div>
                    <div class="col-span-1 ml-2">{{$tournament->players}}</div>
                    <div class="col-span-1 ml-2">
                        @if($tournament->winner->player->country != 'XX')
                            <img class="h-4" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/flags/{{$tournament->winner->player->country}}.png"> 
                        @endif
                    </div>
                    <div class="col-span-2 ml-f flex items-center justify-between">
                        <div class="flex items-center justify-between">
                            {{$tournament->winner->player->name}}
                        </div>
                        <div class="flex gap-2">
                            @if($tournament->winner->deck->deckType)
                                @if($tournament->winner->deck->deckType->icon_primary !== 'substitute')
                                    <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$tournament->winner->deck->deckType->icon_primary}}.png">
                                    @if($tournament->winner->deck->deckType->icon_secondary)
                                        <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$tournament->winner->deck->deckType->icon_secondary}}.png">
                                    @endif
                                @else
                                    <img class="max-h-6" src="/images/substitute.png">
                                @endif
                            @else
                                <img class="max-h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/unown.png">
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
