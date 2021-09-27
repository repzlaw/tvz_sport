<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /**
     * Get comments for the news.
     */
    public function comments()
    {
        return $this->hasMany(NewsComment::class,'competition_news_id');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
