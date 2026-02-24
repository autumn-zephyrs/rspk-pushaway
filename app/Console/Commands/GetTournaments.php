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
use Illuminate\Support\Facades\DB;

class GetTournaments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:tournaments {--chunk=50}';

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

        //Set up the base endpoint
        $client = new Client([
            'base_uri' => 'https://play.limitlesstcg.com/api/'
        ]);

        $end = 0;
        //Get the full list of tournaments from Limitless
        for ($page = 0; $end < 1; $page++) {
            echo("Pulling the next {$this->option('chunk')} batches of tournament data from Limitless API, page {$page}...");
            echo("\r\n");

            $response = $client->request('GET', 'tournaments', [
                'headers' =>  
                [
                    'X-Access-Key'=> env("LIMITLESS_KEY")
                ],
                'query' =>  
                [  
                    'game' => 'PTCG',
                    'format' => 'EX',
                    'limit' => $this->option('chunk'),
                    'page' => $page,
                ]
            ]);
            $tournaments = json_decode($response->getBody()->getContents());

            if (count($tournaments) < $this->option('chunk')) {
                $end = 1;
            }

            //Create our progress bar using the number of tournaments as our limit
            $progressBar = $this->output->createProgressBar(count($tournaments));
            $progressBar->setMessage('Importing decks and tournament data...');
            $progressBar->start();


            //Begin parsing through the list of tournaments
            foreach ($tournaments as $tournament) {
                try {
                    DB::transaction(function () use ($client, $tournament) {
                        // Check if tournament already exists
                        $exists = Tournament::where('limitless_id', $tournament->id)->exists();
                        
                        if (!$exists) {
                            $t = Tournament::create(
                                [
                                    'limitless_id' => $tournament->id,
                                    'format'    =>  $tournament->format,
                                    'name'      =>  $tournament->name,
                                    'players'   =>  $tournament->players,
                                    'date'      =>  gmdate("Y-m-d\TH:i:s", strtotime($tournament->date))
                                ]
                            );

                            $this->importTournamentPhases($client, $tournament);
                            $this->importTournamentPairings($client, $tournament);
                            $this->importTournamentStandings($client, $tournament);
                        }
                    });
                } catch (\Exception $e) {
                    $this->error("Error importing tournament {$tournament->id}: " . $e->getMessage());
                    continue;
                }
                $progressBar->advance();
            }

            $progressBar->finish();
            echo("\r\n");
        }
    }

    /**
     * Import tournament standing data from Limitless API.
     *
     * @param object $tournament The tournament object
     * @return void
     */
    private function importTournamentStandings($client, $tournament) {
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
                    'tournament_limitless_id'   =>  $tournament->id,
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
                $deckCardsToInsert = [];
                foreach ($standing->decklist as $cardType => $cards) {
                    foreach($cards as $card) {
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
                        if ($c) {
                            $deckCardsToInsert[] = [
                                'tournament_standing_id'    =>  $s->id,
                                'card_id'                   =>  $c->id,
                                'count'                     =>  $card->count,
                                'created_at'                =>  now(),
                                'updated_at'                =>  now(),
                            ];
                        }
                    }
                }
                if (!empty($deckCardsToInsert)) {
                    DeckCard::insert($deckCardsToInsert);
                }
            }
        }

    }

    /**
     * Import tournament pairing data from Limitless API.
     *
     * @param object $client The Guzzle HTTP client
     * @param object $tournament The tournament object
     * @return void
     */
    private function importTournamentPairings($client, $tournament) {
        //Import tournament pairing data
        $response = $client->request('GET', 'tournaments/' . $tournament->id . '/pairings', [
            'headers' =>  
            [
                'X-Access-Key'=> env("LIMITLESS_KEY")
            ],
        ]);
        $pairingsResponse = json_decode($response->getBody()->getContents());

        if (empty($pairingsResponse)) {
            return;
        }

        $pairingsToInsert = [];
        foreach($pairingsResponse as $pairing) {    
            $pairingsToInsert[] = [
                'tournament_limitless_id'   =>  $tournament->id,
                'phase'                     =>  $pairing->phase ?? null,
                'round'                     =>  $pairing->round,
                'player_1'                  =>  $pairing->player1,
                'table'                     =>  $pairing->table ?? null,
                'match'                     =>  $pairing->match ?? null,
                'winner'                    =>  $pairing->winner ?? null,
                'player_2'                  =>  $pairing->player2 ?? null,
                'created_at'                =>  now(),
                'updated_at'                =>  now(),
            ];
        }

        if (!empty($pairingsToInsert)) {
            TournamentPairing::insert($pairingsToInsert);
        }
    }

    /**
     * Import tournament phase data from Limitless API.
     *
     * @param object $client The Guzzle HTTP client
     * @param object $tournament The tournament object
     * @return void
     */
    private function importTournamentPhases($client, $tournament) {
        //Import tournament phase data
        $response = $client->request('GET', 'tournaments/' . $tournament->id . '/details', [
            'headers' =>  
            [
                'X-Access-Key'=> env("LIMITLESS_KEY")
            ],
        ]);
        $phaseResponse = json_decode($response->getBody()->getContents());

        if (empty($phaseResponse->phases)) {
            return;
        }

        $phasesToInsert = [];
        foreach($phaseResponse->phases as $phase){
            $phasesToInsert[] = [
                'tournament_limitless_id'   =>  $tournament->id,
                'phase'                     =>  $phase->phase,
                'type'                      =>  $phase->type,
                'rounds'                    =>  $phase->rounds,
                'mode'                      =>  $phase->mode,
                'created_at'                =>  now(),
                'updated_at'                =>  now(),
            ];
        }

        if (!empty($phasesToInsert)) {
            TournamentPhase::insert($phasesToInsert);
        }
    }
}
