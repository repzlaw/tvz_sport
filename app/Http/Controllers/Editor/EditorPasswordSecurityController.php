<?php

namespace App\Http\Controllers\Editor;

use App\Models\Editor;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\EditorPasswordSecurity;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\URL;

class EditorPasswordSecurityController extends Controller
{
    /**
     * Only auth for "editor" guard are allowed 
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('editor');
    }
    // //show 2fa form
    public function show2faForm()
    {
        // phpinfo();
        $id = Auth::guard('editor')->user()->id;
        // if (Auth::guest()) {
        //     return ;
        // }
        $user = Editor::where('id',$id)->with('passwordSecurity')->first();
        // return($user);

        $google2faUrl =''; 

        if ($user->passwordSecurity) {
            $google2fa = new Google2FA();
            $google2faUrl = $google2fa->getQRCodeUrl(
                'TVZ_Sports',
                 $user->email,
                $user->passwordSecurity->google2fa_secret
            );
            // dd($google2faUrl);
            $writer = new Writer(
                new ImageRenderer(
                    new RendererStyle(400),
                    new ImagickImageBackEnd()
                )
            );
            
            $google2faUrl = base64_encode($writer->writeString($google2faUrl));
            // $google2fa_url = custom_generate_qrcode_url($google2fa_url);
        }
        $data = array(
            'user'=>$user,
            'google2faUrl'=> $google2faUrl
        );
        
        return view('editor.google2fa')->with('data',$data);
    }

    //generate2faSecret
    public function generate2faSecret(Request $request)
    {
        $user = Auth::guard('editor')->user();
        $google2fa = new Google2FA();

        EditorPasswordSecurity::create([
            'editor_id'=>$user->id,
            'google2fa_enable'=>0,
            'google2fa_secret'=>$google2fa->generateSecretKey()
        ]);

        return back()->with('message', 'code generated successfully');
    }

    public function enable2fa(Request $request){
        // dd($request->all());
        $user = Auth::guard('editor')->user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('verify_code');
        $valid = $google2fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);
        if($valid){
            $user->passwordSecurity->google2fa_enable = 1;
            $user->passwordSecurity->save();
            return back()->with('success',"2FA is Enabled Successfully.");
        }else{
            return back()->with('error',"Invalid Verification Code, Please try again.");
        }
    }

    public function disable2fa(Request $request){
        // dd($request->all());
        if (!(Hash::check($request->get('current_password'), Auth::guard('editor')->user()->password))) {
            // The passwords matches
            return back()->with("error","Your  password does not matches with your account password. Please try again.");
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
        ]);
        $user = Auth::guard('editor')->user();
        $user->passwordSecurity->google2fa_enable = 0;
        $user->passwordSecurity->save();
        return back()->with('success',"2FA is now Disabled.");
    }

    
}
