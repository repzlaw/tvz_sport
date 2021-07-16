<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded =[];

    /**
     * Get the sport type of the team.
     */
    public function sportType()
    {
        return $this->belongsTo(SportType::class, 'sport_type_id');
    }
}
