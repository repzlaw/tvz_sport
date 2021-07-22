<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamNews extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the team the news was written for.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the news associated with teams.
     */
    public function news()
    {
        return $this->belongsTo(CompetitionNews::class, 'competition_news_id');
    }

}
