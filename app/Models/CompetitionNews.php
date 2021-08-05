<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionNews extends Model
{
    use HasFactory;

    protected $guarded =[];

    /**
     * Get the user that posted the news.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Get the competition the news was written for.
     */
    public function competition()
    {
        return $this->belongsTo(Competitions::class);
    }

    /**
     * Get the player the news was written for.
     */
    public function playernews()
    {
        return $this->hasMany(PlayerNewsRelationship::class,'competition_news_id');
    }

     /**
     * Get the team the news was written for.
     */
    public function teamnews()
    {
        return $this->hasMany(TeamNewsRelationship::class,'competition_news_id');
    }
}
