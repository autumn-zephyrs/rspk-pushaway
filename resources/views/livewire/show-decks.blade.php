
<div class="w-screen">
    <div class="grid grid-cols-12">

        <div class="col-start-1 col-end-3">
            <div class="w-2/12 fixed  h-screen bg-gray-700">
                <div class="bg-gray-700 my-4 flex pagination items-center rounded-lg px-4 py-1">
                    {{$decks->links()}}
                </div>
                <div class="flex-1 bg-gray-600 rounded-lg h-3/4 mx-4 overflow-auto shadow-inner">
                    <div class="divide-y overflow-scroll-y divide-gray-700">
                        <div wire:click="setIdentifier(null)" class="hover:text-gray-100 cursor-pointer px-4 text-base text-gray-300">All decks</div>
                        @foreach($types as $type)
                            <div wire:click="setIdentifier('{{$type->identifier}}')" class="hover:text-gray-100 cursor-pointer px-4 text-base text-gray-300 flex items-center gap-1">{{$type->name}}

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

        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-6 px-4">

            @foreach ($decks as $deck)
                <div class="bg-gray-100 flex-none rounded-lg my-4">
                    <div class="bg-gray-200 rounded-t-lg w-full h-8 flex items-center px-2 italic drop-shadow-sm">
                        <h2>{{date("dS M Y", strtotime($deck->tournamentStanding->tournament->date))}} - {{$deck->tournamentStanding->tournament->name}}</h2>
                    </div>
                    <div class="px-12 py-4">
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
                            <div>
                                <h2>Player: {{$deck->player_name}} - {{$deck->player_username}}</h2>
                                <h2>Placement: {{$deck->tournamentStanding->placement}} / {{$deck->tournamentStanding->tournament->players}}</h2>
                            </div>
                        </div>
                        <div class="my-2 grid sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-10 gap-2 bg-black/80 rounded shadow-inner p-4">
                            @foreach($deck->deckCards as $deckCard)
                                <div class="flex transition-all hover:scale-105 cursor-pointer items-end justify-center">  
                                    <img src="{{$deckCard->card->image_small}}">
                                    <div class="absolute bg-black/50 w-6 h-6 rounded-xl mx-auto text-gray-200 font-bold text-center">{{$deckCard->count}}</div>                      
                                </div>
                            @endforeach
                                    
                        </div>
                        <div class="grid grid-cols-3 mt-4 gap-4">
                            <div class="col-span-1">
                                <div class="bg-gray-200 text-center font-semibold">
                                    Pokemon
                                </div>
                                <div>
                                    @foreach($deck->deckCards as $deckCard)
                                        @if($deckCard->card->type === 'pokemon')
                                            <div class="text-sm leading">{{$deckCard->card->name}} <span class="text-gray-400 text-xs">({{$deckCard->card->set_code}} {{$deckCard->card->number}})</span> x {{$deckCard->count}}</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-span-1">
                                <div class="bg-gray-200 text-center font-semibold">
                                    Trainers
                                </div>
                                <div class="text-sm leading">
                                    @foreach($deck->deckCards as $deckCard)
                                        @if($deckCard->card->type === 'trainer')
                                            <div>{{$deckCard->card->name}} x {{$deckCard->count}}</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-span-1">
                                <div class="bg-gray-200 text-center font-semibold">
                                    Energy
                                </div>
                                <div class="text-sm leading">
                                    @foreach($deck->deckCards as $deckCard)
                                        @if($deckCard->card->type === 'energy')
                                            <div>{{$deckCard->card->name}} x {{$deckCard->count}}</div>
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
                                <button button x-on:click="copy" class="rounded bg-gray-600 h-6 w-6 p-1.5 flex items-center justify-center hover:scale-105 cursor-pointer">
                                    <svg class="text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M208 0H332.1c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9V336c0 26.5-21.5 48-48 48H208c-26.5 0-48-21.5-48-48V48c0-26.5 21.5-48 48-48zM48 128h80v64H64V448H256V416h64v48c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48z"/></svg>
                                </button>
                                <div x-text="copied ? `Copied!` : `Export to TCG One`">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
