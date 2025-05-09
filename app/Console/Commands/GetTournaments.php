<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Tournament;
use App\Models\TournamentStanding;
use App\Models\TournamentPairing;
use App\Models\Player;
use App\Models\Deck;
use App\Models\DeckCard;
use App\Models\Card;
use Symfony\Component\Console\Output\ConsoleOutput;
Use PokemonTCG\Pokemon;

class GetTournaments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:tournaments';

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

        $progressBar = $this->output->createProgressBar(count($tournaments));
        $progressBar->setMessage('Importing decks and tournament data...');
        $progressBar->start();

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
                $s = TournamentStanding::updateOrCreate(
                    [
                        'tournament_limitless_id'   =>  $t->limitless_id,
                        'player_username'           =>  $standing->player,
                    ],
                    [   
                        'placement'                 =>  $standing->placing ?? $tournament->players, // -1 implies DQ from Tourney?
                        'drop'                      =>  $standing->drop
                    ]
                );

                if ($standing->player) {
                    $p = Player::updateOrCreate(
                        [
                            'username' => $standing->player,
                        ],
                        [
                            'name' => $standing->name,
                            'country' => $standing->country ?? 'XX', // XX is the unknown coutnry code
                        ],
                    );          
                }

                $d = Deck::firstOrCreate(
                    [
                        'tournament_standing_id'    =>  $s->id,
                        'tournament_limitless_id'   =>  $t->limitless_id,
                    ],
                    [
                        'identifier'                =>  !empty($standing->deck->id) ? $standing->deck->id : null,
                        'player_username'           =>  $standing->player,
                        'date'                      =>  gmdate("Y-m-d\TH:i:s", strtotime($tournament->date)),
                        'placement'                 =>  $standing->placing ?? $tournament->players // -1 implies DQ from Tourney?
                    ]
                );

                $cards = DeckCard::where('deck_id', $d->id)->delete();
                
                $deck = $standing->decklist;
                if(!empty($deck)) {
                    foreach ($deck as $cardType => $cards) {
                        foreach($cards as $card) {
                            if($card->name === "Lightning Energy") {
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  'RS',
                                        'number'                    =>  109,
                                    ],
                                    [
                                        'type'                      => 'energy',
                                        'name'                      => 'Lightning Energy',
                                    ]
                                );
                            }
                            elseif($card->name === "Fire Energy") {
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  'RS',
                                        'number'                    =>  108,
                                    ],
                                    [
                                        'type'                      => 'energy',
                                        'name'                      => 'Fire Energy',
                                    ]
                                );
                            }
                            elseif($card->name === "Fighting Energy") {
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  'RS',
                                        'number'                    =>  105,
                                    ],
                                    [
                                        'type'                      => 'energy',
                                        'name'                      => 'Fighting Energy',
                                    ]
                                );
                            }
                            elseif($card->name === "Psychic Energy") {
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  'RS',
                                        'number'                    =>  107,
                                    ],
                                    [
                                        'type'                      => 'energy',
                                        'name'                      => 'Psychic Energy',
                                    ]
                                );
                            }
                            elseif($card->name === "Metal Energy") {
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  'RS',
                                        'number'                    =>  94,
                                    ],
                                    [
                                        'type'                      => 'energy',
                                        'name'                      => 'Metal Energy',
                                    ]
                                );
                            }
                            elseif($card->name === "Water Energy") {
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  'RS',
                                        'number'                    =>  106,
                                    ],
                                    [
                                        'type'                      => 'energy',
                                        'name'                      => 'Water Energy',
                                    ]
                                );
                            }
                            elseif($card->name === "Darkness Energy") {
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  'RS',
                                        'number'                    =>  93,
                                    ],
                                    [
                                        'type'                      => 'energy',
                                        'name'                      => 'Darkness Energy',
                                    ]
                                );
                            }
                            elseif($card->name === "Grass Energy") {
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  'RS',
                                        'number'                    =>  104,
                                    ],
                                    [
                                        'type'                      => 'energy',
                                        'name'                      => 'Grass Energy',
                                    ]
                                );
                            } else{
                                $c = Card::firstOrCreate(
                                    [
                                        'set_code'                  =>  $card->set,
                                        'number'                    =>  $card->number,
                                    ],
                                    [
                                        'type'                      => $cardType,
                                        'name'                      => $card->name,
                                    ]
                                );
                            }
                            $dc = DeckCard::create(
                                [
                                    'deck_id'                   =>  $s->id,
                                    'card_id'                   =>  $c->id,
                                    'count'                     =>  $card->count,
                                ]
                            );
                        }
                    }       
                }
            }

            $response = $client->request('GET', 'tournaments/' . $tournament->id . '/pairings', [
                    'headers' =>  
                [
                    'X-Access-Key'=> env("LIMITLESS_KEY")
                ],
            ]);

            $pairings = json_decode($response->getBody()->getContents());

            foreach($pairings as $pairing) {    
                $p = TournamentPairing::firstOrCreate(
                    [
                        'tournament_limitless_id'   =>  $t->limitless_id,
                        'phase'                     =>  isset($pairing->phase) ? $pairing->phase : null,
                        'round'                     =>  $pairing->round,
                        'player_1'                  =>  $pairing->player1,
                    ],
                    [   
                        'table'                     =>  isset($pairing->table) ? $pairing->table : null,
                        'match'                     =>  isset($pairing->match) ? $pairing->match : null,
                        'winner'                    =>  isset($pairing->winner) ? $pairing->winner : null,
                        'player_2'                  =>  isset($pairing->player2) ? $pairing->player2 : null
                    ]
                );
            }

        $pairings = json_decode($response->getBody()->getContents());

            $progressBar->advance();
        }
        $progressBar->finish();
        echo("\r\n");
    }
}
