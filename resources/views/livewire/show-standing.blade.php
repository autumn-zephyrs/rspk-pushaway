
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
                            <div class="text-2xl font-bold mb-2">{{$standing->player_name}} ({{$standing->player_username}})</div>
                            <div class="items-center flex gap-2">
                                <a href="/decks?identifier={{$standing->deck->identifier}}" class="hover:text-slate-700  text-lg font-semibold">{{isset($standing->deck->deckType) ? $standing->deck->deckType->name : 'notfound'}}</a>
                                <div class="flex gap-2">
                                    @if($standing->deck->deckType->icon_primary !== 'substitute')
                                        <img class="max-h-8" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_primary}}.png">
                                        @if($standing->deck->deckType->icon_secondary)
                                            <img class="max-h-8" src="https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/{{$standing->deck->deckType->icon_secondary}}.png">
                                        @endif
                                    @else
                                        <img class="max-h-8" src="/images/substitute.png">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="items-center gap-2">
                            <a href="/tournaments/{{$standing->tournament->limitless_id}}" class="hover:text-slate-700 text-lg font-bold mb-2">{{$standing->tournament->name}}</a>
                            <h2 class="text-gray-700 italic text-sm mt-1 mb-2">{{date("dS M Y", strtotime($standing->tournament->date))}}</h2>
                        </div>
                    </div>
                    <div class="py-1 text-gray-900 text-lg text-left font-semibold">
                        Pairings
                    </div>
                    <div class="w-1/2 grid mb-4">
                        @foreach($pairings as $index => $pairing)
                            <div class="{{($index % 2 === 0) ? 'bg-gray-100' : 'bg-gray-200'}}  rounded pl-2 text-gray-800 grid grid-cols-12">
                                <div class="col-start-1 col-end-1 text-sm font-bold items-center flex">
                                    @if($pairing->table)R{{$pairing->round}}@else{{$pairing->match}}@endif
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
                        @endforeach
                    </div>
                    <div class="my-2 grid sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-10 gap-2 bg-black/80 rounded shadow-inner p-4">
                            @foreach($standing->deck->deckCards as $deckCard)
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
                                    @foreach($standing->deck->deckCards as $deckCard)
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
                                    @foreach($standing->deck->deckCards as $deckCard)
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
                                    @foreach($standing->deck->deckCards as $deckCard)
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
                                    $clipboard("{{$standing->deck->cardlist}}")      
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
            </div>
        </div>
    </div>
</div>
