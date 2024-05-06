<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Pokemon\Pokemon;
use App\Models\Card;

class GetSetNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-set-names';

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

        $cards = Card::where('set_name', '=', null)->get();
        $progressBar = $this->output->createProgressBar(count($cards));
        $progressBar->start();
        foreach($cards as $card) {
            if (in_array($card->set_code, ['P1','P2', 'P3', 'P4', 'P5'])) {
                $card->set_name = str_replace('P', 'Pop Series ', $card->set_code);
                $progressBar->advance();
            } else {
                $card->set_name = Pokemon::Set()->where(['ptcgoCode' => $card->set_code])->all()[0]->getName();
                $progressBar->advance();
            }
            $card->save();
        }
        $progressBar->finish();
    }
}
