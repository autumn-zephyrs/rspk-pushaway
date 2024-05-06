<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function deckCards(): HasMany
    {
        return $this->hasMany(DeckCard::class);
    }

    public function tournamentStanding(): BelongsTo
    {
        return $this->belongsTo(TournamentStanding::class);
    }

    public function deckType(): BelongsTo
    {
        return $this->belongsTo(DeckType::class, 'identifier', 'identifier');
    }

}
