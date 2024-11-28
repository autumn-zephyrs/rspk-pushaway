<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TournamentStanding extends Model
{

    use SoftDeletes;
    
    protected $connection = 'mysql';
    protected $table = 'tournament_standings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tournament_limitless_id', 'player_username', 'player_name', 'country', 'placement', 'deck', 'drop'];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_limitless_id', 'limitless_id');
    }

    public function tournamentPairings(): HasMany
    {
        return $this->hasMany(TournamentPairing::class, 'player_username', 'player_username');
    }

    public function deck(): HasOne
    {
        return $this->hasOne(Deck::class);
    }

    public function getPairingsAttribute() {
        $player_1 = TournamentPairing::where('tournament_limitless_id',  $this->tournament_limitless_id)->where('player_1', $this->player_username)->get();
        $player_2 = TournamentPairing::where('tournament_limitless_id',  $this->tournament_limitless_id)->where('player_2', $this->player_username)->get();
        $result = $player_1->merge($player_2);

        return $result;
    }

    public function getWinrateAttribute() {
        $wins = 0;
        $losses = 0;
        $ties = 0;
        foreach ($this->pairings as $pairing) {
            if ($pairing->winner === $this->player_username || $pairing->winner == -1) {
                $wins++;
            } else {
                $losses++;
            }
        }
        return [$wins, $losses, $ties];
    }

    public function getWinRatioAttribute() {
        $wins = 0;
        $losses = 0;
        $ties = 0;
        foreach ($this->pairings as $pairing) {
            if ($pairing->winner === $this->player_username || $pairing->winner == -1) {
                $wins++;
            } else {
                $losses++;
            }
        }
        return ($wins+1 / $losses+1);
    }

}
