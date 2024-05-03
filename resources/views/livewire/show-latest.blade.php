
<div class="p-6 w-full mx-auto lg:p-8">
    <div class="flex justify-center">
        <div class="font-bold mt-6 text-6xl font-semibold text-gray-900 dark:text-white">
            LATEST DECKS
        </div>
    </div>
    <div class="mx-auto flex-1 w-2/3 h-auto justify-center  mt-6 px-4">
        @foreach ($decks as $deck)
            <div class="bg-white flex-none rounded-lg h-60 my-4">
                <h2>Deck: {{isset($deck->deckType) ? $deck->deckType->name : 'notfound'}}</h2>
                <h2>Player: {{$deck->player_name}} - {{$deck->player_username}}</h2>
                <h2>Tournament: {{$deck->tournamentStanding->tournament->name}}</h2>
                <h2>Placement: {{$deck->tournamentStanding->placement}} / {{$deck->tournamentStanding->tournament->players}}</h2>
                <h2>Date: {{date("dS M Y", strtotime($deck->tournamentStanding->tournament->date))}}</h2>
                @foreach($deck->cards as $card)
                    {{$card->name}} x {{$card->count}}, 
                @endforeach
            </div>
        @endforeach
    </div>
</div>
