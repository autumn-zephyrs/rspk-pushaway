<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    protected $fillable = ['tournament_standing_id', 'featured_id', 'identifier', 'player_username', 'player_name'];

}
