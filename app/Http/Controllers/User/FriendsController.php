<?php

namespace App\Http\Controllers\User;

use App\Models\Friend;
use App\Mail\inviteFriend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FriendsController extends Controller
{
    //get friends list
    public function friendList()
    {
        $user = Auth::user();

        $friends = Friend::where(['followed_user_id'=> $user->id, 'status'=>'active'])
                            ->with('user:id,username,display_name','user.picture')->get();
                            // return $friends;

        return view('userProfile.friends-list')->with(['friends'=>$friends]);
    }

    //get pending requests
    public function pendingRequest()
    {
        $user = Auth::user();

        $friends = Friend::where(['followed_user_id'=> $user->id, 'status'=>'pending'])
                            ->with('user:id,username,display_name','user.picture')->get();
                            // return $friends;

        return view('userProfile.pending-requests')->with(['friends'=>$friends]);
    }

    //accept pending request
    public function acceptRequest(Request $request, $friend_slug)
    {
        $explode = explode('-',$friend_slug);
        $id = end($explode);
        $user = Auth::user();
        // dd($id);

        $accept = Friend::where(['user_id'=> $id, 'followed_user_id'=> $user->id])->firstOrFail();

        $accept->update(['status'=>'active']);

        if ($accept) {
            $message = 'Friend request accepted!';
        }else{
            $message = 'Friend request not accepted!';
        }

        return redirect()->back()->with(['message'=>$message]);

    }

    //decline friend request
    public function declineRequest(Request $request, $friend_slug)
    {
        $explode = explode('-',$friend_slug);
        $id = end($explode);
        $user = Auth::user();

        $accept = Friend::where(['user_id'=> $id, 'followed_user_id'=> $user->id])->firstOrFail();

        if ($accept) {
            $accept = Friend::where(['user_id'=> $id, 'followed_user_id'=> $user->id])->delete();
            $message = 'Friend request declined!';
        }else{
            $message = 'Friend request decline failed!';
        }

        return redirect()->back()->with(['message'=>$message]);
    }

    //invite friend
    public function inviteFriend(Request $request)
    {
        $request->validate(['email'=>'required']);

        $id = $request->user_id;
        $email = $request->email;
        $username = $request->username;
        $display_name = $request->display_name;
        $user_email = $request->user_email;
        
        if (is_null($display_name)) {
            $display_name = $username; 
        }
        // dd($request->user_email);
        
        Mail::to($email)->queue(new inviteFriend($display_name, $user_email));

        $message = 'Invite Sent Successfully!';

        return redirect()->back()->with(['message' => $message]);
    }
}
