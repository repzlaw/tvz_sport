<?php

namespace App\Http\Controllers\Admin;

use App\Models\Editor;
use App\Models\EditorRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreEditorRequest;

class EditorController extends Controller
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
    
    //editors page
    public function index()
    {
        $roles = EditorRole::all();

        $editors = Editor::with('role')->paginate(50);

        return view('admin/editors')->with(['editors'=> $editors, 'roles'=>$roles]);

    }

    //create editors
    public function createEditor(StoreEditorRequest $request)
    {
        $uuid= ((string) Str::uuid());
        $editor = Editor::create([
            'username'=> $request->username,
            'name'=> $request->name,
            'uuid'=> $uuid,
            'editor_role_id'=> $request->editor_type,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        if ($editor) {
            $message = 'Editor Created Successfully!';
        }

        return redirect('/admin/editors')->with(['message' => $message]);  
    }

    //edit editors
    public function editEditor(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required',
            'editor_type' => 'required',
        ]);

        $editor = Editor::findOrFail($request->editor_id);

        $update = $editor->update([
            'username'=> $request->username,
            'name'=> $request->name,
            'email'=> $request->email,
            'editor_role_id'=> $request->editor_type,
            'password'=> $request->password ? Hash::make($request->password) : $editor->password,
        ]);

        if ($update) {
            $message = 'Editor Updated Successfully!';
        }

        return redirect()->back()->with(['message' => $message]);

    }

    //search editors
    public function searchEditor()
    {
        $searchData = $_GET['query'];
        $searchColumn = $_GET['search_column'];
        $editors= '';

        if (!is_null($searchData)) {
            if ($searchColumn==='id') {
                $editors = Editor::where('id', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='username') {
                $editors = Editor::where('username', 'like', "%$searchData%")->paginate(50);
            }elseif ($searchColumn==='email') {
                $editors = Editor::where('email', 'like', "%$searchData%")->paginate(50);
            }
        }
        
        if ($editors) {
            $roles = EditorRole::all();

            return view('admin/editors')->with(['editors'=> $editors, 'roles'=>$roles]);
        }else{
            return redirect('admin/editors/')->with(['message'=>'invalid search column']);
        }

    }
}
