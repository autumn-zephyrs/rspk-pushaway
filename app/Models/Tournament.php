<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
