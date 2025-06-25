<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Decklist extends Model
{

    use SoftDeletes;
    
    protected $connection = 'mysql';
    protected $table = 'decklists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tournament_standing_id', 'name', 'count', 'set', 'number'];

}
