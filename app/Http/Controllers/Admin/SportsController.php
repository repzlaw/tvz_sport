<?php

namespace App\Http\Controllers\Admin;

use App\Models\SportType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSportRequest;

class SportsController extends Controller
{
    //get all sports
    public function index()
    {
        $sports= SportType::orderBy('sport_type', 'asc')->get();
        
        return view('admin/sports')->with(['sports'=> $sports]);
    }

    //create sport
    public function createSport(StoreSportRequest $request)
    {
        $pagetitle = $request->page_title ? $request->page_title : $request->sport_type;
        $metadescription = $request->meta_description ? $request->meta_description : $request->sport_type;
        $slug = Str::slug($request->sport_type, "-");

        $sport = SportType::create([
            'sport_type'=>$request->sport_type,
            'page_title'=> $pagetitle,
            'meta_description'=> $metadescription,
            'url_slug'=> $slug,

        ]);

        if ($sport) {
            $message = 'Sport Created Successfully!';
        }

        return redirect('/admin/sports')->with(['message' => $message]);    
        
        
    }

    //edit sport
    public function editSport(StoreSportRequest $request)
    {
        $pagetitle = $request->page_title ? $request->page_title : $request->sport_type;
        $metadescription = $request->meta_description ? $request->meta_description : $request->sport_type;
        $slug = Str::slug($request->sport_type, "-");

        $sport = SportType::findOrFail($request->sport_id);

        $sport = $sport->update([
            'sport_type'=>$request->sport_type,
            'page_title'=> $pagetitle,
            'meta_description'=> $metadescription,
            'url_slug'=> $slug,

        ]);

        if ($sport) {
            $message = 'Sport Updated Successfully!';
        }

        return redirect('/admin/sports')->with(['message' => $message]);  

    }

    //delete sport
    // public function deleteSport($id)
    // {
    //     $sport = SportType::findOrFail($id);

    //     $delete = $sport->delete();

    //     if ($delete) {
    //         return redirect('/admin/sports')->with('message','Sport Deleted Successfully!');
    //     } else {
    //         return redirect('/admin/sports')->with('error','You cannot delete this sport');
    //     }
        
    // }
}
