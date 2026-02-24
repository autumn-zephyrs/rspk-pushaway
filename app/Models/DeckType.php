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

    public function tournamentStandings(): HasMany
    {
        return $this->hasMany(TournamentStanding::class, 'identifier', 'identifier');
    }
    
    public function parent(): HasOne
    {
        return $this->hasOne(DeckType::class, 'name', 'parent');
    }

    public function getWinsAttribute()
    {
        return $this->hasMany(TournamentStanding::class, 'identifier', 'identifier')->sum('wins');
    }

    public function getLossesAttribute()
    {
        return $this->hasMany(TournamentStanding::class, 'identifier', 'identifier')->sum('losses');
    }

    public function getTiesAtribute()
    {
        return $this->hasMany(TournamentStanding::class, 'identifier', 'identifier')->sum('ties');
    }

    public function getYearlyWinsAttribute()
    {
        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 year'));
        return $this->hasMany(TournamentStanding::class, 'identifier', 'identifier')->where('date', '>', $date)->sum('wins');
    }

    public function getYearlyLossesAttribute()
    {
        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 year'));
        return $this->hasMany(TournamentStanding::class, 'identifier', 'identifier')->where('date', '>', $date)->sum('losses');
    }

    public function getYearlyTiesAtribute()
    {
        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 year'));
        return $this->hasMany(TournamentStanding::class, 'identifier', 'identifier')->where('date', '>', $date)->sum('ties');
    }

    public function getWinrateAttribute()
    {
        return round(($this->wins === 0 ? 0 : $this->wins / ($this->wins + $this->losses + $this->ties)) * 100, 2) . '%';
    }

    public function getYearlyWinrateAttribute()
    {
        return round(($this->yearlyWins === 0 ? 0 : $this->yearlyWins / ($this->yearlyWins + $this->yearlyLosses + $this->yearlyTies)) * 100, 2) . '%';
    }

    public function getBestFinishAttribute() {
        return $this->TournamentStandings->where('placement', '>', '-1')->first();
    }

    public function getYearlyBestFinishAttribute() {
        $date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 year'));
        return $this->tournamentStandings->where('placement', '>', '-1')->where('date', '>', $date)->sortByDesc(function($deck){
            return $deck->winrate->percentage;
        })->first();
    }
}
