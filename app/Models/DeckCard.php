<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeckCard extends Model
{

    use SoftDeletes;
    
    protected $connection = 'mysql';
    protected $table = 'deck_cards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tournament_standing_id', 'card_id', 'count'];

    public function tournamentStanding(): BelongsTo
    {
        return $this->belongsTo(TournamentStanding::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

}
