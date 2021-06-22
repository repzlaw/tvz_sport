<?php

namespace App\Http\Controllers;

use Carbon\Traits\Date;
use App\Models\TeamFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamFollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //follow or unfollow player
    public function followTeam($id)
    {
        $follow = teamFollowSystem($id);

        return $follow;
    }
}
