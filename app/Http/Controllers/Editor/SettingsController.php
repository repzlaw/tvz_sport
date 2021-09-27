<?php

namespace App\Http\Controllers\Editor;

use App\Models\Editor;
use Illuminate\Http\Request;
use App\Models\SecurityQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller
{
    //return settings page
    public function index()
    {
        $securityQuestions = SecurityQuestion::all();

        return view('editor.settings')->with(['securityQuestions'=>$securityQuestions]);

    }

    //save security question
    public function save(Request $request)
    {
        $request->validate([
            'security_question_id'=>'required',
            'security_answer'=>'required',
        ]);

        $editor = Editor::findOrFail(Auth::guard('editor')->user()->id);
        $editor->update([
            'security_question_id'=>$request->security_question_id,
            'security_answer'=> Crypt::encryptString($request->security_answer)
        ]);

        return back()->with(['message'=>'settings saved successfully']);
    }
}
