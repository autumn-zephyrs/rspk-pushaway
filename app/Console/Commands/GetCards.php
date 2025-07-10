<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Card;
use Pokemon\Pokemon;

class GetCards extends Command
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
    protected $description = 'Populates the cards table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $progressBar = $this->output->createProgressBar(1959);
        $progressBar->setMessage('Importing cards...');
        $progressBar->start();

        //Import main sets
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
                $progressBar->advance();
            }
        }

        //Import POP sets
        $sets = Pokemon::set()->where(['series' => 'POP'])->all();
        $i = 1; 
        foreach ($sets as $set) {
            $cards = Pokemon::Card()->where(['set.id' => $set->getId()])->all();
                foreach ($cards as $card) {
                    $c = Card::firstOrCreate(
                        [
                            'set_code'                  =>  'P' . $i,
                            'set_id'                    =>  $set->getId(),
                            'set_name'                  =>  $set->getName(),
                            'number'                    =>  $card->getNumber(),
                            'type'                      =>  $card->getSupertype(),
                            'name'                      =>  $card->getName(),
                            'image_small'               =>  $card->getImages()->getSmall(),
                            'image_large'               =>  $card->getImages()->getLarge(),
                        ],
                    );
                    $progressBar->advance();
                }
                $i++;
            }

        //Import Black Star sets
        $sets = Pokemon::set()->where(['series' => 'NP'])->all();
        foreach ($sets as $set) {
            $cards = Pokemon::Card()->where(['set.id' => $set->getId()])->all();
            foreach ($cards as $card) {
                $c = Card::firstOrCreate(
                    [
                        'set_code'                  =>  'NP',
                        'set_id'                    =>  $set->getId(),
                        'set_name'                  =>  $set->getName(),
                        'number'                    =>  $card->getNumber(),
                        'type'                      =>  $card->getSupertype(),
                        'name'                      =>  $card->getName(),
                        'image_small'               =>  $card->getImages()->getSmall(),
                        'image_large'               =>  $card->getImages()->getLarge(),
                    ],
                );
                $progressBar->advance();
            }
        }
        $progressBar->finish();
        echo("\r\n");
    }
}
