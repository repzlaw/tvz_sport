<?php

namespace App\Models;

use App\Models\TeamFollower;
use App\Models\PlayerFollower;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

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
        'uuid',
        'last_login_at',
        'last_login_ip',
        'display_name',
        'role_id',
        'security_question_id',
        'security_answer',
        'member_type_id',
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

    public function isFollowingUser($userId, $followed_user_id)
    {
        $following = Friend::where(['user_id'=>$this->id, 'followed_user_id'=>$followed_user_id])
                            ->pluck('user_id')->toArray();

        $followed = Friend::where(['followed_user_id'=>$this->id, 'user_id'=>$followed_user_id])
                            ->pluck('followed_user_id')->toArray();

        if (in_array($userId, $following) || in_array($userId, $followed)){
            return true;
        }
        return false;
    }

    public function userRequestPending($userId, $followed_user_id)
    {
        $following = Friend::where(['user_id'=>$this->id, 'followed_user_id'=>$followed_user_id, 'status'=>'pending'])
                            ->pluck('user_id')->toArray();

        $followed = Friend::where(['followed_user_id'=>$this->id, 'user_id'=>$followed_user_id, 'status'=>'pending'])
                            ->pluck('followed_user_id')->toArray();
                            
        if (in_array($userId, $following) || in_array($userId, $followed)){
            return true;
        }
        return false;
    }

    /**
     * Get the image associated with the user.
     */
    public function picture()
    {
        return $this->hasOne(UserProfilePic::class);
    }

    /**
     * Get the people following user.
     */
    public function friends()
    {
        return $this->hasMany(Friend::class,'followed_user_id');
    }

    //generate token
    public function generateEmailToken(){
        $this->timestamps = false;
        $this->two_factor_secret =  mt_rand(100000,999999);
        $this->two_factor_expiry = now()->addMinutes(10);
        $this->save();
    }
    
    //reset email token
    public function resetPasswordToken(){
        $this->timestamps = false;
        $this->two_factor_secret = null;
        $this->two_factor_expiry = null;
        $this->save();
    }

    //over ride get key function
    public function getKey()
    {
        return $this->uuid;
    }
    
}
