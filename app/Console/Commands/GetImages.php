<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Pokemon\Pokemon;
use App\Models\Card;

class GetImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:images';

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
        Pokemon::Options(['verify' => true]);
        Pokemon::ApiKey(env('PTCGIO_KEY'));
        
        Pokemon::Options(['verify' => true]);
        Pokemon::ApiKey(env('PTCGIO_KEY'));

        $cards = Card::where(
            [
                ['image_small', '=', null] ,
                ['image_large', '=', null] ,
            ]
        )->get();

        $progressBar = $this->output->createProgressBar(count($cards));
        $progressBar->start();

        foreach($cards as $card) {
   
            $i = Pokemon::Card()->where(
                [
                    'set.name' => $card->set_name,
                    "number" => $card->number
                ]
            )->all();
            if (!empty($i)) {
                $images = $i[0]->getImages();
                $card->image_small = $images->getSmall();
                $card->image_large = $images->getLarge();
                $card->save();
            } else {
                var_dump('Image for ' . $card->name . ' - ' . $card->set_name . ' not found.');
            } 
            $progressBar->advance();
        }
        $progressBar->finish();
        echo("\r\n");
    }
}
