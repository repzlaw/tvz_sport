<?php

namespace App\Http\Controllers\Admin;

use datatables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Models\BanPolicy;

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
                    $actionBtn = "<i class='fa fa-edit text-success mr-2' style='cursor: pointer;' onclick='editUser($row)'></i> 
                                    <a href='javascript:void(0)' class='delete btn btn-outline-info btn-sm' onclick='banUser($row)'>Ban/Unban</a>
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
            'status' => 'required',
        ]);
        // dd($request->all());

        $user = User::findOrFail($request->user_id);

        if ($request->status === 'banned') {
            $ban = $user->update([
                'status'=> $request->status,
                'policy_id'=> $request->policy_id,
                'ban_date'=> $request->ban_date,
                'ban_till'=> $request->ban_till,
            ]);
            if ($ban) {
                $message = 'User Banned Successfully!';
            }
        } elseif ($request->status === 'active') {
            $unban = $user->update([
                'status'=> $request->status,
                'policy_id'=> null,
                'ban_date'=> null,
                'ban_till'=> null,
            ]);
            if ($unban) {
                $message = 'User Activated Successfully!';
            }
        }

        
        
        
        return redirect('/admin/users')->with(['message' => $message]);  

    }




}
