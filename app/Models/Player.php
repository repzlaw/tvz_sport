<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    
    protected $guarded =[];

    /**
     * Get the sport type of the player.
     */
    public function sportType()
    {
        return $this->belongsTo(SportType::class, 'sport_type_id');
    }

    /**
     * Get the team of the player.
     */
    public function Team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

}
