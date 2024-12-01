<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $connection = 'mysql';
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'country'];

    public function deck(): HasMany
    {
        return $this->hasMany(Deck::class, 'player_username', 'username');
    }

    public function tournamentStandings(): HasMany
    {
        return $this->hasMany(TournamentStanding::class, 'player_username', 'username');
    }

    public function bestFinishes(): HasMany
    {
        return $this->hasMany(TournamentStanding::class, 'player_username', 'username')->orderBy('placement','asc');
    }


}
