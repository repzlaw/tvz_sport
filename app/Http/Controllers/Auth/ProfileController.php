<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditUserRequest;
use App\Models\UserProfilePic;

class ProfileController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::user()->id)->with(['picture'])->first();
            // return $user;
    
            return view('userProfile.user-profile')->with(['user'=>$user]);
        }
        return abort(404,"Page not found");
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
            'featured_image' => 'required|image|mimes:jpeg,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('featured_image')) {
            //process image
            $fileNameToStore = process_image($request->file('featured_image'));

            //store image
            $path = $request->file('featured_image')->storeAs('public/images/user_images', $fileNameToStore);

            //get old user image if exist
            $user = UserProfilePic::where('user_id',$request->user_id)->first();
            if ($user) {
                $user_image = $user->file_path;
                if ($user_image) {
                    unlink(storage_path("app/public/images/user_images/".$user_image));
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

}
