<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SecurityQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller
{
    //settings view
    public function index()
    {
        $securityQuestions = SecurityQuestion::all();

        return view('user.settings')->with(['securityQuestions'=>$securityQuestions]);
    }

    //save setting
    // public function save(Request $request)
    // {
    //     // dd($request->all());
    //     $setting = '';
    //     if ($request->has('captcha_enable')) {
    //         $set = Configuration::where('key','captcha_enable')->first();
    //         $setting = $set->update([
    //             'value'=> $request->captcha_enable,
    //         ]);
    //     } else if ($request->has('captcha_site_key')) {
    //         $set = Configuration::where('key','captcha_site_key')->first();
    //         $setting = $set->update([
    //             'value'=> $request->captcha_site_key,
    //         ]);
    //     } else if ($request->has('captcha_secret_key')) {
    //         $set = Configuration::where('key','captcha_secret_key')->first();
    //         $setting = $set->update([
    //             'value'=> $request->captcha_secret_key,
    //         ]);
    //     } else if ($request->has('captcha_login') && $request->has('captcha_register')) {
    //         $set = Configuration::where('key','captcha_login')->first();
    //         $setting = $set->update([
    //             'value'=> $request->captcha_login,
    //         ]);

    //         $set = Configuration::where('key','captcha_register')->first();
    //         $setting = $set->update([
    //             'value'=> $request->captcha_register,
    //         ]);
    //     }
    //     if ($setting) {
    //         return back()->with('message','settings saved successfully');
    //     }
    // }

    //save security question
    public function security(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'security_question_id'=>'required',
            'security_answer'=>'required',
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->update([
            'security_question_id'=>$request->security_question_id,
            'security_answer'=> Crypt::encryptString($request->security_answer)
        ]);

        return back()->with(['message'=>'settings saved successfully']);
    }
}
