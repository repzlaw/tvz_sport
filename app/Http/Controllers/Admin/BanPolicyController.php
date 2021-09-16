<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BanPolicy;
use Illuminate\Http\Request;

class BanPolicyController extends Controller
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

    //edit policy
    public function editPolicy(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'policy_id' => 'required',
        ]);

        $policy = BanPolicy::findOrFail($request->policy_id);

        $policy = $policy->update([
            'reason' => $request->input('reason'),
        ]);

        if ($policy) {
            $message = 'Policy Updated Successfully!';
        }

        return redirect('/admin/ban-policy')->with(['message' => $message]);
    }

}
