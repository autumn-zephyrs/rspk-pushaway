<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentPairing extends Model
{

    use SoftDeletes;
    
    protected $connection = 'mysql';
    protected $table = 'tournament_pairings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tournament_limitless_id', 'round', 'phase', 'player_1', 'player_2', 'winner'];

}