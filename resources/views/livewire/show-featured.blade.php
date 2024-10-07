
<div class="w-screen">
    <div class="grid grid-cols-12">

        <div class="col-start-1 col-end-3">
            <div class="w-2/12 fixed  h-screen bg-gray-700">
                <div class="bg-gray-700 my-4 flex pagination items-center rounded-lg px-4 py-1">
                    {{$decks->links()}}
                </div>
            </div>
        </div>

        <div class="col-start-4 col-span-8 mx-auto flex-1 h-auto justify-center w-full mt-6 px-4">

            @foreach ($decks as $deck)
                <div class="bg-gray-100 flex-none rounded-lg my-4">
                    <div class="bg-gray-200 rounded-t-lg w-full h-8 flex items-center px-2 italic drop-shadow-sm">
                    </div>
                    <div class="px-12 py-4">
                        <div class="flex justify-between items-top">
                            <div class="items-center gap-2">
                                <h2 class="text-2xl font-bold mb-2">{{isset($deck->deckType) ? $deck->deckType->name : 'notfound'}}</h2>
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
                                <h2 class="text-gray-700 italic mt-1 mb-2">By {{$deck->player_name}} ({{$deck->player_username}})</h2>
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
