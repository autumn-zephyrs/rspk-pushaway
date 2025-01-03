<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Deck extends Model
{

    use SoftDeletes;
    
    protected $connection = 'mysql';
    protected $table = 'decks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tournament_standing_id', 'tournament_limitless_id', 'identifier', 'player_username', 'placement', 'date'];

    public function deckCards(): HasMany
    {
        return $this->hasMany(DeckCard::class);
    }

    public function tournamentStanding(): BelongsTo
    {
        return $this->belongsTo(TournamentStanding::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_username', 'username');
    }

    public function tournament(): BelongsTo
    {
        return $this->BelongsTo(Tournament::class, 'tournament_limitless_id', 'limitless_id');
    }

    public function playerOnePairings(): HasMany 
    {
        return $this->HasMany(TournamentPairing::class, 'tournament_limitless_id', 'tournament_limitless_id')->where('player_1', $this->player_username);
    }

    public function playerTwoPairings(): HasMany 
    {
        return $this->HasMany(TournamentPairing::class, 'tournament_limitless_id', 'tournament_limitless_id')->where('player_2', $this->player_username);
    }

    public function getPairingsAttribute()
    {
        return $this->playerOnePairings->merge($this->playerTwoPairings);
    }

    public function deckType(): BelongsTo
    {
        return $this->belongsTo(DeckType::class, 'identifier', 'identifier');
    }

    public function getCardlistAttribute() {
        $s = '';
        foreach ($this->deckCards as $deckCard) {
            $dc = json_decode($deckCard);
            $_s = $s;
            $s = $_s . $dc->count . ' ' . $dc->card->name . ' ' . $dc->card->set_code . ' ' . $dc->card->number . '\n';
        }
        return $s;
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

        $percentage = $wins === 0 ? 0 : $wins / ($wins + $losses + $ties);

        return (object) [
            'wins' => $wins, 
            'losses' => $losses, 
            'ties' => $ties, 
            'percentage' => round($percentage* 100, 2) . '%'
        ];
    }
}
