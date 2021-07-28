<?php

namespace App\Http\Controllers\Admin;

use datatables;
use App\Models\User;
use App\Models\Admin;
use App\Models\BanPolicy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreUserRequest;
use App\Mail\BanUser;
use App\Models\SuspensionHistory;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $policies = BanPolicy::all();

        return view('admin/users')->with(['users'=> $users, 'policies'=>$policies]);

    }

    //get all users
    public function getUser(Request $request)
    {
        $users = User::all();
            return dataTables($users)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = "<i class='fa fa-edit text-success mr-3' style='cursor: pointer;' onclick='editUser($row)'></i> 
                                    <a href='javascript:void(0)' class='delete btn btn-outline-danger btn-sm' onclick='banUser($row)'>Ban</a>
                    ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
                // <a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>
    }

    //create users
    public function createuser(StoreUserRequest $request)
    {
        $user = User::create([
            'username'=> $request->username,
            'name'=> $request->name,
            'email'=> $request->email,
            'user_type'=> $request->user_type,
            'password'=> Hash::make($request->password),
        ]);

        if ($user) {
            $message = 'User Created Successfully!';
        }

        return redirect('/admin/users')->with(['message' => $message]);  

    }

    //edit users
    public function edituser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required',
            'user_type' => 'required',
        ]);

        $user = User::findOrFail($request->user_id);

        $update = $user->update([
            'username'=> $request->username,
            'name'=> $request->name,
            'email'=> $request->email,
            'user_type'=> $request->user_type,
            'password'=> $request->password ? $user->password : Hash::make($request->password),
        ]);

        if ($update) {
            $message = 'User Updated Successfully!';
        }

        return redirect('/admin/users')->with(['message' => $message]);  

    }

    //ban or unban user
    public function editStatus(Request $request)
    {
        $request->validate([
            'policy_id' => 'required',
            'ban_date' => 'required',
        ]);

        $user = User::findOrFail($request->user_id);
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $reason = BanPolicy::findOrFail($request->policy_id);


        $ban = $user->update([
            'status'=> 'banned',
            'policy_id'=> $request->policy_id,
            'ban_date'=> $request->ban_date,
            'ban_till'=> $request->ban_till,
        ]);

        if ($ban) {
            //log suspension 
            $log = SuspensionHistory::create([
                'user_id'=>$request->user_id,
                'policy_id'=>$request->policy_id,
                'action'=>'suspension',
            ]);
            
            
            
            //send mail to user
            $error ='';
            if ($request->ban_till !== null) {
                if ($request->ban_till && now()->lessThan($request->ban_till)) {
                    $banned_days = now()->diffInDays($request->ban_till);
        
                    if ($banned_days > 14) {
                        $error = "Your account has been suspended because you violated our ". $reason->reason. "  policy";
                    } else {
                        $error = "Your account has been suspended for ".$banned_days." ".Str::plural("day", $banned_days)
                            ." because you violated our ". $reason->reason. "  policy";
                    }
                }
                
            }else{
                $error = "Your account has been suspended indefinitely "." because you violated our  ". $reason->reason. " policy";
            }

            Mail::to($user->email, $user->username)->queue(new BanUser($error,$user,$admin));
            
            $message = 'User Banned Successfully!';
        }

        return redirect('/admin/users')->with(['message' => $message]);  
    }




}
