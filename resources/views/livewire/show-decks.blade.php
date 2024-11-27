
<div class="w-screen">
    <div x-data="{ open: false }" class="grid grid-cols-12">

        <div class="col-start-1 col-end-3">
            <div class="w-2/12 fixed h-screen bg-holon-100">
                <div class="flex-1 bg-holon-50 h-3/4 mx-4 overflow-auto shadow-inner mt-4">
                    <div class="divide-y overflow-scroll-y divide-holon-200">
                        <div wire:click="setIdentifier(null)" class="hover:text-gray-400 cursor-pointer px-4 text-base text-gray-700">All decks</div>
                        @foreach($types as $type)
                            <div  x-on:click="open = false" wire:click="setIdentifier('{{$type->identifier}}')" class="hover:text-gray-100 cursor-pointer px-4 text-base text-gray-700 flex items-center gap-1">{{$type->name}}
                                @if($type->icon_primary !== 'substitute')
                                    <img class="max-h-5" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$type->icon_primary}}.png">
                                    @if($type->icon_secondary)
                                        <img class="max-h-5" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$type->icon_secondary}}.png">
                                    @endif
                                @else
                                    <img class="max-h-5" src="/images/substitute.png">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-6 px-8 bg-gray-50 rounded mb-8 pb-4">
            <div class="flex items-center">
                <div class="my-4 text-xl font-bold">Latest Decks</div>
                <div  x-show="open == false"  class="my-4 flex pagination items-center px-4 py-1">
                    {{$decks->links()}}
                </div>
                <div  x-on:click="open = false" x-show="open != false"  class="my-4 flex pagination items-center rounded-lg px-4 py-1">
                    <span class="hover:cursor-pointer relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-holon-600 cursor-default leading-5 rounded-md select-none">
                        Back
                    </span>
                </span>
                </div>
            </div>
            <hr>
            <div>
                @foreach ($decks as $index => $deck)
                    @if ($index === 0 || $decks[$index]->tournamentStanding->tournament->id != $decks[$index-1]->tournamentStanding->tournament->id )
                        <div x-show="open == false" class="bg-holon-200 py-1 px-4">
                            <h3 class="text-sm font-bold flex items-center text-gray-800"> {{$deck->tournamentStanding->tournament->name}} - {{date("dS M Y", strtotime($deck->tournamentStanding->tournament->date))}}</h3>
                        </div>
                    @endif
                    <div x-show="open == false" x-on:click="open = {{$deck->id}}" class="{{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}} py-1 flex-none hover:text-slate-700 hover:cursor-pointer ">
                        <div class="grid grid-cols-10 px-6">
                            <div class="col-span-3 flex items-center gap-4">
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
                            <div class="col-span-1 flex items-center text-gray-800">{{$deck->tournamentStanding->placement === 1000000 ? "Dropped" : $deck->tournamentStanding->placement . ' / ' . $deck->tournamentStanding->tournament->players}} </div>
                            <h2 class="col-span-3 flex items-center text-gray-800">{{$deck->player_name}} ({{$deck->player_username}})</h2>
                        </div>
                    </div>
                    <div x-show="open == {{$deck->id}}" class="flex-none rounded-lg my-4">
                        <div class="px-12 py-4">
                            <div class="mb-2">
                                <div class="flex justify-between items-top">
                                    <div class="items-center flex gap-2">
                                        <a href="/tournaments/standings/{{$deck->tournamentStanding->id}}" class="hover:text-slate-700 text-2xl font-bold">{{isset($deck->deckType) ? $deck->deckType->name : 'notfound'}}</a>
                                        <div class="flex gap-2">
                                            @if($deck->deckType->icon_primary !== 'substitute')
                                                <img class="max-h-8" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$deck->deckType->icon_primary}}.png">
                                                @if($deck->deckType->icon_secondary)
                                                    <img class="max-h-8" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$deck->deckType->icon_secondary}}.png">
                                                @endif
                                            @else
                                                <img class="max-h-8" src="/images/substitute.png">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h2 class="text-base">By {{$deck->player_name}} ({{$deck->player_username}})</h2>
                                <h3 class="text-sm">{{$deck->tournamentStanding->placement === 1000000 ? "Dropped" : $deck->tournamentStanding->placement . ' / ' . $deck->tournamentStanding->tournament->players}} in {{$deck->tournamentStanding->tournament->name}} - {{date("dS M Y", strtotime($deck->tournamentStanding->tournament->date))}}</h3>
                            </div>
                            <hr class="">
                            <div class="mb-4 mt-4 grid sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-10 gap-2 bg-black/80 rounded shadow-inner p-4">
                                @foreach($deck->deckCards as $deckCard)
                                    <div class="flex transition-all hover:scale-105 cursor-pointer items-end justify-center">  
                                        <img src="{{$deckCard->card->image_small}}">
                                        <div class="absolute bg-black/50 w-6 h-6 rounded-xl mx-auto text-gray-200 font-bold text-center">{{$deckCard->count}}</div>                      
                                    </div>
                                @endforeach   
                            </div>
                            <hr class="">
                            <div class="grid grid-cols-3 mt-4 gap-4">
                                <div class="col-span- rounded-b">
                                    <div class="pl-3 bg-holon-600 text-white font-semibold text-lg rounded-t py-1">
                                        Pokemon
                                    </div>
                                    <div class="text-sm leading">
                                        @foreach($deck->deckCards as $index => $deckCard)
                                            @if($deckCard->card->type === 'pokemon')
                                                <div class="pl-2 py-1 {{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}}">{{$deckCard->count}} {{$deckCard->card->name}} <span class="text-gray-400 text-xs">({{$deckCard->card->set_code}} {{$deckCard->card->number}})</span></div>
                                                <hr>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <div class="pl-3 bg-holon-600 text-white font-semibold text-lg rounded-t py-1">
                                        Trainers
                                    </div>
                                    <div class="text-sm leading">
                                        @foreach($deck->deckCards as $index => $deckCard)
                                            @if($deckCard->card->type === 'trainer')
                                                <div class="pl-2 py-1 {{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}}">{{$deckCard->count}} {{$deckCard->card->name}}</div>
                                                <hr>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <div class="pl-3 bg-holon-600 text-white font-semibold text-lg rounded-t py-1">
                                        Energy
                                    </div>
                                    <div class="text-sm leading ">
                                        @foreach($deck->deckCards as $index => $deckCard)
                                            @if($deckCard->card->type === 'energy')
                                                <div class="pl-2 py-1 {{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}}">{{$deckCard->count}} {{$deckCard->card->name}}</div>
                                                <hr>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4"
                                x-data='{
                                    copied: false,
                                    copy () {
                                        $clipboard("{{$deck->cardlist}}")      
                                        this.copied = true
                                    }
                                }'
                            >
                                <div class="text-sm w-auto flex gap-2 text-gray-800">
                                    <button button x-on:click="copy" class="rounded bg-holon-600 h-6 w-6 p-1.5 flex items-center justify-center hover:scale-105 cursor-pointer">
                                        <svg class="text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M208 0H332.1c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9V336c0 26.5-21.5 48-48 48H208c-26.5 0-48-21.5-48-48V48c0-26.5 21.5-48 48-48zM48 128h80v64H64V448H256V416h64v48c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48z"/></svg>
                                    </button>
                                    <div x-text="copied ? `Copied to clipboard!` : `Export to TCG One`">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            <div>
        </div>
    </div>
</div>
