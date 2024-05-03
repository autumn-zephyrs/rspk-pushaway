<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function deck(): HasOne
    {
        return $this->hasOne(Deck::class);
    }

}
