<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\BanPolicy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserLoginLog;

class ProfileController extends Controller
{
    //get a player
    public function profile($id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $policies = BanPolicy::all();

        return view('admin/userProfile')->with(['user'=>$user, 'policies'=>$policies]);

    }

    //get user login logs page
    public function loginLogs($id)
    {
        $user = User::where('id', $id)->first();

        $logs = UserLoginLog::where('user_id',$id)->orderBy('created_at','desc')->paginate(50);

        return view('admin/loginLogs/userLoginLogs')->with(['user'=>$user, 'logs'=>$logs]);

    }
}
