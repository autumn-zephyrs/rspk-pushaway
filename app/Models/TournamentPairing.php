<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TournamentPairing extends Model
{
    
    protected $connection = 'mysql';
    protected $table = 'tournament_pairings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tournament_limitless_id', 'round', 'phase', 'table', 'player_1', 'player_2', 'winner', 'match'];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_limitless_id', 'limitless_id');
    }

    public function playerOneDeck(): BelongsTo
    {
        return $this->belongsTo(Deck::class, 'tournament_limitless_id', 'tournament_limitless_id')->where('player_username', $this->player_1);
    }

    public function playerTwoDeck(): BelongsTo
    {
        return $this->belongsTo(Deck::class, 'tournament_limitless_id', 'tournament_limitless_id')->where('player_username', $this->player_2);
    }
}