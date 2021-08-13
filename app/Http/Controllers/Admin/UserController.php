<?php

namespace App\Http\Controllers\Admin;

use datatables;
use App\Models\User;
use App\Mail\BanUser;
use App\Models\Admin;
use App\Mail\UnbanUser;
use App\Models\BanPolicy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SuspensionHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Only auth for "admin" guard are allowed 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    //users page
    public function index()
    {
        $users = User::paginate(50);

        return view('admin/users')->with(['users'=> $users]);

    }

    //search users
    public function searchUser()
    {
        $searchData = $_GET['query'];
        $searchColumn = $_GET['search_column'];
        $users= '';

        if (!is_null($searchData)) {
            if ($searchColumn==='id') {
                $users = User::where('id', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='username') {
                $users = User::where('username', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='email') {
                $users = User::where('email', 'like', "%$searchData%")->paginate(50);
            }
        }
        
        if ($users) {
            return view('admin/users')->with(['users'=> $users]);
        }else{
            return redirect('admin/users/')->with(['message'=>'invalid search column']);
        }

    }

    //create users
    public function createuser(StoreUserRequest $request)
    {
        $uuid= ((string) Str::uuid());

        $user = User::create([
            'username'=> $request->username,
            'uuid'=> $uuid,
            'name'=> $request->name,
            'email'=> $request->email,
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
        ]);

        $user = User::findOrFail($request->user_id);

        $update = $user->update([
            'username'=> $request->username,
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($update) {
            $message = 'User Updated Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);
        // return redirect('/admin/users')->with(['message' => $message]);

    }

    //ban user
    public function banUser(Request $request)
    {
        $request->validate([
            'policy_id' => 'required',
        ]);

        $user = User::findOrFail($request->user_id);
        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $reason = BanPolicy::findOrFail($request->policy_id);
        $ban_date =date("Y/m/d");
        $ban_time =date("H:i:s");

        $ban = $user->update([
            'status'=> 'banned',
            'policy_id'=> $request->policy_id,
            'ban_date'=> $ban_date,
            'ban_time'=> $ban_time,
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

        return redirect()->back()->with(['message' => $message]);  
    }

     //unban user
     public function unbanUser(Request $request)
     {
         $request->validate([
             'reason' => 'required',
         ]);

         $user = User::findOrFail($request->user_id);
         $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
         $policy_id = $user->policy_id;

         $unban = $user->update([
             'status'=> 'active',
             'policy_id'=> null,
             'unban_date'=> null,
             'unban_time'=> null,
             'unban_till'=> null,
         ]);
 
         if ($unban) {
             //log unsuspension 
             $log = SuspensionHistory::create([
                 'user_id'=>$request->user_id,
                 'action'=>'unsuspension',
                 'policy_id'=>$policy_id,
                 'unsuspend_reason'=>$request->reason,
             ]);
            
             //send mail to user
             $message ='Your account has been unsuspended. You can now login into your account';
             
             Mail::to($user->email, $user->username)->queue(new UnbanUser($message,$user,$admin));
             
             $message = 'User Unbanned Successfully!';
         }else{
            $message = 'Operation Unsuccessful!';
         }
 
         return redirect()->back()->with(['message' => $message]);  
     }

}
