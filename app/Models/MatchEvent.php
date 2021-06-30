<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchEvent extends Model
{
    use HasFactory;

    protected $table = 'matches';


    /**
     * Get the user that posted the event.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Get the home team.
     */
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Get the away team.
     */
    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
