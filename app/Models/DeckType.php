<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DeckType extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['identifier', 'name', 'parent', 'icon_primary', 'icon_secondary'];

    public function decks(): HasMany
    {
        return $this->hasMany(TournamentStanding::class, 'identifier', 'identifier');
    }
    
    public function parent(): HasOne
    {
        return $this->hasOne(DeckType::class, 'name', 'parent');
    }
    
    public function getWinrateAttribute()
    {
        $wins = 0;
        $losses = 0;
        $ties = 0;

        foreach($this->decks as $deck) {
            $wins += $deck->winrate->wins;
            $losses += $deck->winrate->losses;
            $ties += $deck->winrate->ties;
        }        

        $percentage = $wins === 0 ? 0 : $wins / ($wins + $losses + $ties);

        return (object) [
            'wins' => $wins, 
            'losses' => $losses, 
            'ties' => $ties, 
            'percentage' => round($percentage* 100, 2) . '%'
        ];
    }

    public function getYearlyWinrateAttribute()
    {
        $wins = 0;
        $losses = 0;
        $ties = 0;
        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 year'));

        foreach($this->decks as $deck) {
            if ($deck->tournament->date > $date) {
                $wins += $deck->winrate->wins;
                $losses += $deck->winrate->losses;
                $ties += $deck->winrate->ties;
            }
        }        

        $percentage = $wins === 0 ? 0 : $wins / ($wins + $losses + $ties);

        return (object) [
            'wins' => $wins, 
            'losses' => $losses, 
            'ties' => $ties, 
            'percentage' => round($percentage* 100, 2) . '%'
        ];
    }

    public function getBestFinishAttribute() {
        return $this->decks->where('identifier', '=', $this->identifier)->where('tournamentStanding.placement', '>', '-1')->sortByDesc(function($deck){
            return $deck->winrate->percentage;
        })->first();
    }

    public function getYearlyBestFinishAttribute() {
        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 year'));
        return $this->decks->where('identifier', '=', $this->identifier)->where('tournamentStanding.placement', '>', '-1')->where('tournament.date', '>', $date)->sortByDesc(function($deck){
            return $deck->winrate->percentage;
        })->first();
    }
}
