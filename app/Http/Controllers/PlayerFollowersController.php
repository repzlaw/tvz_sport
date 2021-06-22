<?php

namespace App\Http\Controllers;

use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Models\PlayerFollower;
use Illuminate\Support\Facades\Auth;

class PlayerFollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //follow or unfollow player
    public function followPlayer($id)
    {
        $follow = playerFollowSystem($id);

        return $follow;
    }
}
