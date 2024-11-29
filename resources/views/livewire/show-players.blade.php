
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
            <div class="items-center">
                <div class="text-xl font-bold">Players</div>
                <div class="pagination items-center mb-4">
                    {{$players->links()}}
                </div>
            </div>
            <div class="grid grid-cols-9 px-6 flex items-center">
                <div class="col-span-1 flex items-center gap-4 py-1">Country</div>
                <div class="col-span-2 ml-2">Name</div>
                <div class="col-span-2 ml-2">Username</div>
            </div>
            <hr>
            @foreach ($players as $index=>$player)
                <a href="" class="{{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}} hover:bg-holon-200 hover:text-slate-700 hover:cursor-pointer grid grid-cols-9 px-6 flex items-center">
                    <div class="col-span-1 ml-2">
                        @if($player->country != 'XX')
                            <img class="h-6" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/flags/{{$player->country}}.png"> 
                        @endif
                    </div>
                    <div class="col-span-2 ml-2 border-holon-400 py-1">{{$player->name}}</div>
                    <div class="col-span-2 ml-2">{{$player->username}}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>
