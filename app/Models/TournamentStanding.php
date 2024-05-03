<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
