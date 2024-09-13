<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{

    use SoftDeletes;
    
    protected $connection = 'mysql';
    protected $table = 'tournaments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['limitless_id', 'name', 'format', 'name', 'players', 'date'];

    public function tournamentStandings(): HasMany
    {
        return $this->hasMany(TournamentStanding::class, 'tournament_limitless_id', 'limitless_id')
        ->where('placement', '!=', -1)
        ->orderBy('placement', 'asc');
    }

    public function tournamentPairings(): HasMany
    {
        return $this->hasMany(TournamentPairing::class, 'tournament_limitless_id', 'limitless_id');
    }

    public function topStandings() {
        return $this->hasMany(TournamentStanding::class, 'tournament_limitless_id', 'limitless_id')
        ->take(8)
        ->orderBy('placement', 'asc');;
    }

}
