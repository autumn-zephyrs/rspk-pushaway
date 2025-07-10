<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\DeckType;

class CalculateWinrates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:winrates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates winrate information for DeckTypes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
    }
}
