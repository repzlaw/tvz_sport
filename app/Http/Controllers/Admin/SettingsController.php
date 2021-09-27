<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\SecurityQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller
{
    //settings view
    public function index(Request $request)
    {
        $settings = Configuration::all();
        $securityQuestions = SecurityQuestion::all();

        return view('admin.settings')->with(['captcha_enable'=>$settings[0]->value, 'captcha_site_key'=>$settings[1]->value,
                                            'captcha_secret_key'=>$settings[2]->value,'captcha_login'=>$settings[3]->value,
                                            'captcha_register'=>$settings[4]->value,'securityQuestions'=>$securityQuestions]);
    }

    //save setting
    public function save(Request $request)
    {
        // dd($request->all());
        $setting = '';
        if ($request->has('captcha_enable')) {
            $set = Configuration::where('key','captcha_enable')->first();
            $setting = $set->update([
                'value'=> $request->captcha_enable,
            ]);
        } else if ($request->has('captcha_site_key')) {
            $set = Configuration::where('key','captcha_site_key')->first();
            $setting = $set->update([
                'value'=> $request->captcha_site_key,
            ]);
        } else if ($request->has('captcha_secret_key')) {
            $set = Configuration::where('key','captcha_secret_key')->first();
            $setting = $set->update([
                'value'=> $request->captcha_secret_key,
            ]);
        } else if ($request->has('captcha_login') && $request->has('captcha_register')) {
            $set = Configuration::where('key','captcha_login')->first();
            $setting = $set->update([
                'value'=> $request->captcha_login,
            ]);

            $set = Configuration::where('key','captcha_register')->first();
            $setting = $set->update([
                'value'=> $request->captcha_register,
            ]);
        }
        if ($setting) {
            return back()->with('message','settings saved successfully');
        }
    }

    //save security question
    public function security(Request $request)
    {
        $request->validate([
            'security_question_id'=>'required',
            'security_answer'=>'required',
        ]);

        $admin = Admin::findOrFail(Auth::guard('admin')->user()->id);
        $admin->update([
            'security_question_id'=>$request->security_question_id,
            'security_answer'=> Crypt::encryptString($request->security_answer)
        ]);

        return back()->with(['message'=>'settings saved successfully']);
    }
}
