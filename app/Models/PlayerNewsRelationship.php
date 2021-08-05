<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerNewsRelationship extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the player the news was written for.
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get the news associated with players.
     */
    public function news()
    {
        return $this->belongsTo(CompetitionNews::class, 'competition_news_id');
    }
}
