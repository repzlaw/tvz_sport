<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BanPolicy;
use Illuminate\Http\Request;

class BanPolicyController extends Controller
{
    //get policy page
    public function index()
    {
        $policies= BanPolicy::orderBy('created_at', 'desc')->get();
        
        return view('admin/policies')->with(['policies'=> $policies]);
    }

    //create policy
    public function createpolicy(Request $request)
    {
        $request->validate([
            'reason' => 'required',
        ]);

        $policy = BanPolicy::create([
            'reason' => $request->input('reason'),
        ]);

        if ($policy) {
            $message = 'Policy Created Successfully!';
        }

        return redirect('/admin/ban-policy')->with(['message' => $message]);
    }

}
