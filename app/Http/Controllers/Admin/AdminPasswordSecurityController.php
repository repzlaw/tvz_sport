<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminPasswordSecurity;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class AdminPasswordSecurityController extends Controller
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
    // //show 2fa form
    public function show2faForm()
    {
        $id = Auth::guard('admin')->user()->id;
        $user = Admin::where('id',$id)->with('passwordSecurity')->first();

        $google2faUrl =''; 

        if ($user->passwordSecurity) {
            $google2fa = new Google2FA();
            $google2faUrl = $google2fa->getQRCodeUrl(
                'TVZ_Sports',
                 $user->email,
                $user->passwordSecurity->google2fa_secret
            );
            $writer = new Writer(
                new ImageRenderer(
                    new RendererStyle(400),
                    new ImagickImageBackEnd()
                )
            );
            
            $google2faUrl = base64_encode($writer->writeString($google2faUrl));
        }
        $data = array(
            'user'=>$user,
            'google2faUrl'=> $google2faUrl
        );
        
        return view('admin.google2fa')->with('data',$data);
    }

    //generate2faSecret
    public function generate2faSecret(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $google2fa = new Google2FA();

        AdminPasswordSecurity::create([
            'admin_id'=>$user->id,
            'google2fa_enable'=>0,
            'google2fa_secret'=>$google2fa->generateSecretKey()
        ]);

        return back()->with('message', 'code generated successfully');
    }

    public function enable2fa(Request $request){
        $user = Auth::guard('admin')->user();
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
        if (!(Hash::check($request->get('current_password'), Auth::guard('admin')->user()->password))) {
            // The passwords matches
            return back()->with("error","Your  password does not matches with your account password. Please try again.");
        }
        $validatedData = $request->validate([
            'current_password' => 'required',
        ]);
        $user = Auth::guard('admin')->user();
        $user->passwordSecurity->google2fa_enable = 0;
        $user->passwordSecurity->save();
        return back()->with('success',"2FA is now Disabled.");
    }

}
