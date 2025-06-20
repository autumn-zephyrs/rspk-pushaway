<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\DeckType;
use App\Models\Card;
use Pokemon\Pokemon;

class getDeckTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sets = Pokemon::set()->where(['series' => 'EX'])->all();
        foreach ($sets as $set) {
            $cards = Pokemon::Card()->where(['set.id' => $set->getId()])->all();
            foreach ($cards as $card) {
                $c = Card::firstOrCreate(
                    [
                        'set_code'                  =>  $set->getPtcgoCode(),
                        'set_id'                    =>  $set->getId(),
                        'set_name'                  =>  $set->getName(),
                        'number'                    =>  $card->getNumber(),
                        'type'                      =>  $card->getSupertype(),
                        'name'                      =>  $card->getName(),
                        'image_small'               =>  $card->getImages()->getSmall(),
                        'image_large'               =>  $card->getImages()->getLarge(),
                    ],
                );
            }
        }

    }
}
