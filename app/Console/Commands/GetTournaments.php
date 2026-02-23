<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Tournament;
use App\Models\TournamentStanding;
use App\Models\TournamentPairing;
use App\Models\TournamentPhase;
use App\Models\Player;
use App\Models\Deck;
use App\Models\DeckCard;
use App\Models\Card;
use Symfony\Component\Console\Output\ConsoleOutput;

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
            if (!Tournament::where('limitless_id', $tournament->id)->first()) {
                //Import main tournament data
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

                //Import tournament phase data
                $response = $client->request('GET', 'tournaments/' . $tournament->id . '/details', [
                    'headers' =>  
                    [
                        'X-Access-Key'=> env("LIMITLESS_KEY")
                    ],
                ]);
        
                $details = json_decode($response->getBody()->getContents());

                foreach($details->phases as $phase){
                    $ts = TournamentPhase::create(
                        [
                            'tournament_limitless_id'   =>  $tournament->id,
                            'phase'                     =>  $phase->phase,
                            'type'                      =>  $phase->type,
                            'rounds'                    =>  $phase->rounds,
                            'mode'                      =>  $phase->mode,
                        ]
                    );
                }
    
                //Import tournament pairing data
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

                //Import tournament standing data, including decks
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
                            'identifier'                =>  !empty($standing->deck->id) ? $standing->deck->id : null,
                            'wins'                      =>  $standing->record->wins,
                            'losses'                    =>  $standing->record->losses,
                            'ties'                      =>  $standing->record->ties,
                            'placement'                 =>  $standing->placing ?? $tournament->players, // -1 implies DQ from Tourney?
                            'drop'                      =>  $standing->drop,
                            'date'                      =>  gmdate("Y-m-d\TH:i:s", strtotime($tournament->date)),
                        ]
                    );
    
                    if ($standing->player) {
                        $p = Player::updateOrCreate(
                            [
                                'username' => $standing->player,
                            ],
                            [
                                'name' => $standing->name,
                                'country' => $standing->country ?? 'XX', // XX is the unknown country code
                            ],
                        );          
                    }

                    if(!empty($standing->decklist)) {
                        $decklist = $standing->decklist;
                        foreach ($decklist as $cardType => $cards) {
                            foreach($cards as $card) {
                                var_export($card);
                                if ($cardType == 'energy') {
                                    $c = Card::where('name', str_replace('Delta', 'δ', $card->name))->first();
                                } elseif ($card->name == 'Unown') { 
                                    $c = Card::where('set_code', $card->set)->where('number', $card->number[0])->first();
                                } else {
                                    $c = Card::where('set_code', $card->set)->where('number', $card->number)->first();
                                } 
                                
                                if (!isset($c)) {
                                    $c = Card::where('name', $card->name)->first();
                                }

                                $dc = DeckCard::create(
                                    [
                                        'tournament_standing_id'    =>  $s->id,
                                        'card_id'                   =>  $c->id,
                                        'count'                     =>  $card->count,
                                    ]
                                );

                            }
                        }       
                    }
                }

            }
            $progressBar->advance();
        }

        $progressBar->finish();
        echo("\r\n");
    }
}
