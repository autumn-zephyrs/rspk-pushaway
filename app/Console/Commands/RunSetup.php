<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\Console\Output\ConsoleOutput;

class RunSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the three setup commands';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo("Getting cards... \n");
        $this->call('get:cards');
        echo("Getting deck types... \n");
        $this->call('get:decks');
        echo("Getting tournaments... \n");
        $this->call('get:tournaments');
    }
}
