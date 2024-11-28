<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeckType extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['identifier', 'name', 'icon_primary', 'icon_secondary'];

    public function decks(): HasMany
    {
        return $this->hasMany(Deck::class, 'identifier', 'identifier');
    }


    public function getWinrateAttribute(): float
    {
        $wins = 0;
        $losses = 0;
        $ties = 0;
        foreach($this->decks as $deck) {
            $wins += $deck->winrate[0];
            $losses += $deck->winrate[1];
            $ties += $deck->winrate[2];
        }

        // $percentage = $wins / ($wins + $losses + $ties);
        
        return number_format(50 , 2, '.', '');
    }
}
