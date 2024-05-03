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

}
