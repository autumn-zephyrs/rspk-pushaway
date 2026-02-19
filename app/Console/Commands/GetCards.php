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

    protected $sets = [
        'ex1' => [
            'id' => 'ex1',
            'code' => 'RS',
            'name' => 'EX Ruby & Sapphire',
        ],
        'ex2' => [
            'id' => 'ex2',
            'code' => 'SS',
            'name' => 'EX Sandstorm',
        ],
        'ex3' => [
            'id' => 'ex3',
            'code' => 'DR',
            'name' => 'EX Dragon',
        ],
        'ex4' => [
            'id' => 'ex4',
            'code' => 'MA',
            'name' => 'EX Team Magma vs Team Aqua',
        ],  
        'ex5' => [
            'id' => 'ex5',
            'code' => 'HL',
            'name' => 'EX Hidden Legends',
        ],
        'ex6' => [
            'id' => 'ex6',
            'code' => 'RG',
            'name' => 'EX FireRed & LeafGreen',
        ],
        'ex7' => [
            'id' => 'ex7',
            'code' => 'TR',
            'name' => 'EX Team Rocket Returns',
        ],
        'ex8' => [
            'id' => 'ex8',
            'code' => 'DX',
            'name' => 'EX Deoxys',
        ],
        'ex9' => [
            'id' => 'ex9',
            'code' => 'EM',
            'name' => 'EX Emerald',
        ],
        'ex10' => [
            'id' => 'ex10',
            'code' => 'UF',
            'name' => 'EX Unseen Forces',
        ],
        'ex11' => [
            'id' => 'ex11',
            'code' => 'DS',
            'name' => 'EX Delta Species',
        ], 
        'ex12' => [
            'id' => 'ex12',
            'code' => 'LM',
            'name' => 'EX Legend Maker',
        ],
        'ex13' => [
            'id' => 'ex13',
            'code' => 'HP',
            'name' => 'EX Holon Phantoms',
        ],
        'ex14' => [
            'id' => 'ex14',
            'code' => 'CG',
            'name' => 'EX Crystal Guardians',
        ],
        'ex15' => [
            'id' => 'ex15',
            'code' => 'DF',
            'name' => 'EX Dragon Frontiers',
        ],
        'ex16' => [
            'id' => 'ex16',
            'code' => 'PK',
            'name' => 'EX Power Keepers',
        ],
        'pop1' => [
            'id' => 'pop1',
            'code' => 'P1',
            'name' => 'POP Series 1',
        ],
        'pop2' => [
            'id' => 'pop2',
            'code' => 'P2',
            'name' => 'POP Series 2',
        ],
        'pop3' => [
            'id' => 'pop3',
            'code' => 'P3',
            'name' => 'POP Series 3',
        ],
        'pop4' => [
            'id' => 'pop4',
            'code' => 'P4',
            'name' => 'POP Series 4',
        ],
        'pop5' => [
            'id' => 'pop5',
            'code' => 'P5',
            'name' => 'POP Series 5',
        ],
        'np' => [
            'id' => 'np',
            'code' => 'NP',
            'name' => 'Black Star Promos',
        ]
    ];


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cardsPath = resource_path('cards');
        $allCards = [];

        if (is_dir($cardsPath)) {
            foreach (glob($cardsPath . '/*.json') as $file) {
                $setId = pathinfo($file, PATHINFO_FILENAME);
                $json = @file_get_contents($file);
                if ($json === false) {
                    continue;
                }
                $decoded = json_decode($json, true);
                if (!is_array($decoded)) {
                    continue;
                }

                foreach ($decoded as $card) {
                    $card['set_id'] = $setId;

                    if (isset($card['images']) && is_array($card['images'])) {
                        $card['image_small'] = $card['images']['small'] ?? null;
                        $card['image_large'] = $card['images']['large'] ?? null;
                    }

                    $allCards[] = $card;
                }
            }
        }

        $total = count($allCards);
        $progressBar = $this->output->createProgressBar(max(1, $total));
        $progressBar->setMessage('Importing cards...');
        $progressBar->start();

        foreach ($allCards as $card) {
            $setId = $card['set_id'] ?? null;

            $attrs = [
                'set_id'    => $this->sets[$setId]['id'] ?? $setId,
                'set_code'  => $this->sets[$setId]['code'] ?? null,
                'set_name'  => $this->sets[$setId]['name'] ?? null,
                'number'    => $card['number'] ?? null,
                'type'      => $card['supertype'] ?? ($card['type'] ?? null),
                'name'      => $card['name'] ?? null,
                'image_small' => $card['image_small'] ?? null,
                'image_large' => $card['image_large'] ?? null,
            ];

            Card::firstOrCreate([
                'set_id' => $attrs['set_id'],
                'number' => $attrs['number'],
            ], $attrs);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->line('');
    }
}
