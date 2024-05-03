<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Tournament;
use App\Models\TournamentStanding;
use App\Models\TournamentPairing;
use App\Models\Deck;
use App\Models\DeckCard;

class GetTournaments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-tournaments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls all tournament data from Limitless';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client([
            'base_uri' => 'https://play.limitlesstcg.com/api/'
        ]);
        $response = $client->request('GET', 'tournaments', [
            'headers' =>  
            [
                'X-Access-Key'=> env("LIMITLESS_KEY")
            ],
            'query' =>  
            [  
                'game' => 'PTCG',
                'format' => 'EX'
            ]
        ]);
        $tournaments = json_decode($response->getBody()->getContents());
        foreach ($tournaments as $tournament) {
            $t = Tournament::firstOrCreate(
                [
                    'limitless_id' => $tournament->id
                ],
                [
                    'format'    =>  $tournament->format,
                    'name'      =>  $tournament->name,
                    'players'   =>  $tournament->players,
                    'date'      =>  gmdate("Y-m-d\TH:i:s", strtotime($tournament->date))
                ]
            );
            $response = $client->request('GET', 'tournaments/' . $tournament->id . '/standings', [
                    'headers' =>  
                [
                    'X-Access-Key'=> env("LIMITLESS_KEY")
                ],
            ]);
            $standings = json_decode($response->getBody()->getContents());
            foreach($standings as $standing) {
                $s = TournamentStanding::create(
                    [
                        'tournament_limitless_id'   =>  $t->limitless_id,
                        'player_username'           =>  $standing->player,
                        'player_name'               =>  $standing->name,
                        'country'                   =>  $standing->country,
                        'placement'                 =>  $standing->placing,
                        'drop'                      =>  $standing->drop
                    ]
                );

                $d = Deck::create(
                    [
                        'tournament_standing_id'    =>  $s->id,
                        'identifier'                =>  !empty($standing->deck->id) ? $standing->deck->id : null,
                        'player_username'           =>  $standing->player,
                        'player_name'               =>  $standing->name,
                    ]
                );
                
                $deck = $standing->decklist;
                if(!empty($deck)) {
                    foreach ($deck as $cardType) {
                        foreach($cardType as $card) {
                            $dl = DeckCard::create(
                                [
                                    'deck_id'                   =>  $s->id,
                                    'name'                      =>  $card->name,
                                    'count'                     =>  $card->count,
                                    'set'                       =>  $card->set,
                                    'number'                    =>  $card->number,
                                ]
                            );
                        }
                    }       
                }
            }
        }
    }
}
