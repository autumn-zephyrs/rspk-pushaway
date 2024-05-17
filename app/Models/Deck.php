<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function getCardlistAttribute() {
        $s = '';
        foreach ($this->deckCards as $deckCard) {
            $dc = json_decode($deckCard);
            $_s = $s;
            $s = $_s . $dc->count . ' ' . $dc->card->name . ' ' . $dc->card->set_code . ' ' . $dc->card->number . '\n';
        }
        return $s;
    }

}
