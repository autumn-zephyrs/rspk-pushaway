<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\DeckType;
use App\Repositories\DeckTypeRepository;

class getDeckTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:decks';

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
        $client = new Client([
            'base_uri' => 'https://play.limitlesstcg.com/api/games/PTCG/'
        ]);
        $response = $client->request('GET', 'decks', [
            'headers' =>  
            [
                'X-Access-Key'=> env("LIMITLESS_KEY")
            ],
            'query' =>  
            [  
                'generation' => '3',
            ]
        ]);
        $decks = json_decode($response->getBody()->getContents());
        $progressBar = $this->output->createProgressBar(count($decks));
        $progressBar->setMessage('Importing deck types...');
        $progressBar->start();
        foreach ($decks as $deck) { 
            if(isset($deck->generation)){
                if($deck->generation === 3) {
                    $d = DeckType::firstOrCreate(
                        [   
                            'identifier'        =>  $deck->identifier   
                        ],
                        [
                            'name'              =>  $deck->name,
                            'icon_primary'      =>  isset($deck->icons[0]) ? $deck->icons[0] : null,
                            'icon_secondary'    =>  isset($deck->icons[1]) ? $deck->icons[1] : null 
                        ]   
                    );
                    foreach($deck->variants as $variant) {
                        $v = DeckType::firstOrCreate(
                            [   
                                'identifier'        =>  $variant->identifier   
                            ],
                            [
                                'name'              =>  $variant->name,
                                'parent'            =>  $deck->name,
                                'icon_primary'      =>  isset($deck->icons[0]) ? $deck->icons[0] : null,
                                'icon_secondary'    =>  $variant->icon, 
                            ]   
                        );
                    }
                }
            }
            $progressBar->advance();
        }
        $decks = new DeckTypeRepository;
        foreach ($decks->decks as $deck) {
            DeckType::firstOrCreate(
                [   
                    'identifier'        =>  $deck['identifier']  
                ],
                [
                    'name'              =>  $deck['name'],
                    'parent'            =>  $deck['parent'],
                    'icon_primary'      =>  isset($deck['icon_primary']) ? $deck['icon_primary'] : null,
                    'icon_secondary'    =>  isset($deck['icon_secondary']) ? $deck['icon_secondary'] : null 
                ]   
            );
        }
        $o = DeckType::firstOrCreate(
            [   
                'identifier'        =>  'other'   
            ],
            [
                'name'              =>  'Other',
                'icon_primary'      =>  'substitute',
                'icon_secondary'    =>  null 
            ]   
        );
        $progressBar->finish();
        echo("\r\n");
    }
}
