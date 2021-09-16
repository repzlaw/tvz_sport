<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Models\UserProfilePic;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\EditUserRequest;
use App\Mail\PasswordUpdateVerification;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::user()->id)
                        ->with(['picture'])
                        ->firstOrFail();

            $friend_count = friendCount($user->id);
            $user->friends_count = $friend_count;
    
            return view('userProfile.user-profile')->with(['user'=>$user]);
        }
    }

    //edit users
    public function updateProfile(EditUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        $update = $user->update([
            'username'=> $request->username,
            'name'=> $request->name,
            'email'=> $request->email,
            'display_name'=> $request->display_name,
        ]);

        if ($update) {
            $message = 'Profile Updated Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);

    }

    //edit user image
    public function updateImage(Request $request)
    {
        // dd($request->all()); 
        $request->validate([
            'featured_image' => 'required|image|mimes:jpeg,jpg,gif,png,svg|max:2048',
        ]);
        if ($request->hasFile('featured_image')) {
            //process image
            $fileNameToStore = process_image($request->file('featured_image'));

            //store image
            $path = $request->file('featured_image')->storeAs('public/images/profile', $fileNameToStore);

            //get old user image if exist
            $user = UserProfilePic::where('user_id',$request->user_id)->first();
            if ($user) {
                $user_image = $user->file_path;
                if ($user_image) {
                    unlink(storage_path("app/public/images/profile/".$user_image));
                }
            }

            $update = UserProfilePic::firstOrNew([
                'user_id'=>$request->user_id,
                'alt_name'=>$request->username,
            ]);
            $update->file_path = $fileNameToStore;
            $update->save();

            if ($update) {
                $message = 'User Image Updated!';
            }
    
            return redirect()->back()->with(['message'=>$message]);
        }
    }

    //fun to get other users profile
    public function userProfile($slug)
    {
        $explode = explode('-',$slug);
        $id = end($explode);
        $user = User::where('id', $id)
                    ->with(['picture'])
                    ->firstOrFail();

        $friend_count = friendCount($user->id);
        $user->friends_count = $friend_count;

        return view('userProfile.user-profile')->with(['user'=>$user]);
    }

    //follow or unfollow user
    public function followUser($id)
    {
        $follow = userFollowSystem($id);

        return $follow;
    }

    //changePassword
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $key = 'password-'.$user->username;
        if(Hash::check($request->old_password, $user->password) && $request->confirm_password === $request->new_password)
        {
            $hashedPassword = Hash::make($request->new_password);
            
            $cached_password = Cache::put($key, $hashedPassword, $seconds = 15*60);
            
            $user->generateEmailToken();
            Mail::to($user->email)->send(new PasswordUpdateVerification($user));
            return redirect()->route('profile.verify.change-password');
        }
        session()->flash('error','Passwords do not match');
        return back();
        // dd($hashedPassword);
    }
}
