<?php

namespace App\Http\Controllers\User;

use App\Models\Friend;
use App\Mail\inviteFriend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserEmailInvite;
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
        $invitenumber = UserEmailInvite::where('user_id',$id)->first();

        if ($invitenumber) {
            $tot = $invitenumber->invite_number;
            if ($tot >= 10) {
                session()->flash('error','You have exceeded your number of invites');
                return back();
            }

            Mail::to($email)->queue(new inviteFriend($display_name, $user_email));
            $invitenumber->update([
                'user_id'=> $id,
                'invite_number'=> $tot+1
            ]);
        } else {
            Mail::to($email)->queue(new inviteFriend($display_name, $user_email));
            $invitenumber = UserEmailInvite::create([
                'user_id'=> $id,
                'invite_number'=>1
            ]);
        }

        $message = 'Invite Sent Successfully!';

        return redirect()->back()->with(['message' => $message]);
    }
}
