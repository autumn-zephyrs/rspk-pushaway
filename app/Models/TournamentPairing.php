<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

}