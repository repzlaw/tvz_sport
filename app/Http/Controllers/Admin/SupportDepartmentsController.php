<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportDepartment;
use Illuminate\Http\Request;

class SupportDepartmentsController extends Controller
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
    
    //get SupportDeparment page
    public function index()
    {
        $departments= SupportDepartment::orderBy('created_at', 'desc')->get();
        
        return view('admin/support-departments')->with(['departments'=> $departments]);
    }

    //create SupportDeparment
    public function createSupportDepartment(Request $request)
    {
        $request->validate([
            'dept_name' => 'required',
        ]);
// dd($request->all());
        $SupportDeparment = SupportDepartment::create([
            'dept_name' => $request->input('dept_name'),
        ]);

        if ($SupportDeparment) {
            $message = 'Support Department Created Successfully!';
        }

        return redirect('/admin/support-departments')->with(['message' => $message]);
    }

    //edit SupportDeparment
    public function editSupportDepartment(Request $request)
    {
        $request->validate([
            'dept_name' => 'required',
            'department_id' => 'required',
        ]);

        $SupportDeparment = SupportDepartment::findOrFail($request->department_id);

        $SupportDeparment = $SupportDeparment->update([
            'dept_name' => $request->input('dept_name'),
        ]);

        if ($SupportDeparment) {
            $message = 'Support Department Updated Successfully!';
        }

        return redirect('/admin/support-departments')->with(['message' => $message]);
    }
}
