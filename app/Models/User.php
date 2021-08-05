<?php

namespace App\Models;

use App\Models\TeamFollower;
use App\Models\PlayerFollower;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'policy_id',
        'ban_date',
        'ban_time',
        'ban_till',
        'status',
        'last_login_at',
        'last_login_ip',
        
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'ban_date',
        'ban_till'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isFollowingCompetition($userId, $competition_id)
    {
        $following =  CompetitionFollower::where(['user_id'=>$this->id, 'competition_id'=>$competition_id])->pluck('user_id')->toArray();
        if (in_array($userId, $following)){
            return true;
        }
        return false;
    }

    public function isFollowingTeam($userId, $team_id)
    {
        $following =  TeamFollower::where(['user_id'=>$this->id, 'team_id'=>$team_id])->pluck('user_id')->toArray();
        if (in_array($userId, $following)){
            return true;
        }
        return false;
    }

    public function isFollowingPlayer($userId, $player_id)
    {
        $following =  PlayerFollower::where(['user_id'=>$this->id, 'player_id'=>$player_id])->pluck('user_id')->toArray();
        if (in_array($userId, $following)){
            return true;
        }
        return false;
    }

    
}
