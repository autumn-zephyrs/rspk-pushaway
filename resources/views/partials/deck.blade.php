
<div x-data="{ card: 'none' }" class="mb-4 mt-4 grid grid-cols-4 md:grid-cols-6 lg:grid-cols-10 gap-2 bg-black/80 rounded shadow-inner p-4">
    @foreach($deck->deckCards as $deckCard)
        <div class="flex transition-all hover:scale-105 cursor-pointer items-end justify-center">  
            <img x-on:click="card = {{$deckCard->card->id}}" src="{{$deckCard->card->image_small}}">
            <div class="absolute bg-black/50 w-6 h-6 rounded-xl mx-auto text-gray-200 font-bold text-center">{{$deckCard->count}}</div>                      
        </div>
        <div x-show="card == {{$deckCard->card->id}}" class="fixed z-20 transition-all w-screen h-screen left-0 top-0 flex items-center bg-black/50 ease-in-out delay-150" >
            <img x-on:click.outside="card = 'none'" x-on:click="card = {{$deckCard->card->id}}" src="{{$deckCard->card->image_large}}" class="h-2/3 mx-auto">
        </div>
    @endforeach   
</div>
<hr class="">
<div class="lg:grid grid-cols-3 mt-4 gap-4">
    <div class="col-span- rounded-b mb-2 lg:mb-0">
        <div class="pl-3 bg-holon-600 text-white font-semibold text-lg rounded-t py-1">
            Pokémon
        </div>
        <div class="text-sm leading">
            @foreach($deck->deckCards as $index => $deckCard)
                @if($deckCard->card->type === 'Pokémon')
                    <div class="pl-2 py-1 {{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}}">{{$deckCard->count}} {{$deckCard->card->name}} <span class="text-gray-400 text-xs">({{$deckCard->card->set_code}} {{$deckCard->card->number}})</span></div>
                    <hr>
                @endif
            @endforeach
        </div>
    </div>
    <div class="col-span-1 mb-2 lg:mb-0">
        <div class="pl-3 bg-holon-600 text-white font-semibold text-lg rounded-t py-1">
            Trainers
        </div>
        <div class="text-sm leading">
            @foreach($deck->deckCards as $index => $deckCard)
                @if($deckCard->card->type === 'Trainer')
                    <div class="pl-2 py-1 {{($index % 2 == 0) ? 'bg-holon-50' : 'bg-holon-100'}}">{{$deckCard->count}} {{$deckCard->card->name}}</div>
                    <hr>
                @endif
            @endforeach
        </div>
    </div>
    <div class="col-span-1 ">
        <div class="pl-3 bg-holon-600 text-white font-semibold text-lg rounded-t py-1">
            Energy
        </div>
        <div class="text-sm leading ">
            @foreach($deck->deckCards as $index => $deckCard)
                @if($deckCard->card->type === 'Energy')
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
