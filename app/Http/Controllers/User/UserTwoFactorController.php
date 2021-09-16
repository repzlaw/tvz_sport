<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\PasswordVerify;
use Illuminate\Support\Facades\Cache;
use App\Mail\PasswordUpdateVerification;
use App\Http\Requests\PasswordVerifyRequest;

class UserTwoFactorController extends Controller
{
    public function passwordTwoFaIndex(){
        return view('userProfile.password_2fa_verify');
    }
    public function verifyPassword(PasswordVerifyRequest $request){
        $user = Auth::user();

        if ($user->two_factor_secret){
            if ($user->two_factor_secret !== $request['code']){
                session()->flash('message','Incorrect two factor code');
                return back();
            }
            $key = 'password-'.$user->username;
            if (Cache::has($key) && $user->two_factor_expiry > Carbon::now()->toDateTimeString()) {
                $user->password = Cache::get($key);
                $user->save();
                $user->resetPasswordToken();
                Cache::forget($key);
                session()->flash('success','Password updated successfully.');
                return redirect()->route('profile.index');
            }else {
                session()->flash('message','Two factor code has expired');
                return back();
            }
        }
    }

    public function resendPasswordToken(){
        $user = Auth::user();
        $user->generateEmailToken();
        Mail::to($user->email)->send(new PasswordUpdateVerification($user));
        session()->flash('message','The two factor code has been re-sent');
        return back();
    }
}
