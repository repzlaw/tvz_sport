<?php

namespace App\Http\Controllers\Admin;

use App\Models\SportType;
use Illuminate\Support\Str;
use App\Models\Competitions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompetitionRequest;

class CompetitionController extends Controller
{
    //get all competitions
    public function index()
    {
        $competitions= Competitions::orderBy('created_at', 'desc')->get();
        
        $sport_types = SportType::all();

        
        return view('admin/competitions')->with(['competitions'=> $competitions, 'sports'=> $sport_types]);
    }

    //create competition
    public function createCompetition(StoreCompetitionRequest $request)
    {
        $pagetitle = $request->page_title ? $request->page_title : $request->competition_name;
        $metadescription = $request->meta_description ? $request->meta_description : $request->competition_name;
        $slug = Str::slug($request->competition_name, "-");

        
        $competition = Competitions::create([
            'competition_name'=>$request->competition_name,
            'sport_type_id'=>$request->sport_type_id,
            'url_slug'=> $slug,
            'page_title'=> $pagetitle,
            'meta_description'=> $metadescription,
        ]);

        if ($competition) {
            $message = 'Competition Created Successfully!';
        }

        return redirect('/admin/competitions')->with(['message' => $message]);    
        
        // dd($request->all());
        
    }

    //edit competition
    public function editCompetition(StoreCompetitionRequest $request)
    {
        $pagetitle = $request->page_title ? $request->page_title : $request->competition_name;
        $metadescription = $request->meta_description ? $request->meta_description : $request->competition_name;
        $slug = Str::slug($request->competition_name, "-");
        // dd($request->all());

        $competition = Competitions::findOrFail($request->competition_id);
        
        $competition = $competition->update([
            'competition_name'=>$request->competition_name,
            'sport_type_id'=>$request->sport_type_id,
            'url_slug'=> $slug,
            'page_title'=> $pagetitle,
            'meta_description'=> $metadescription,
        ]);

        if ($competition) {
            $message = 'Competition Updated Successfully!';
        }

        return redirect('/admin/competitions')->with(['message' => $message]);    
    }

    //delete competition
    // public function deleteCompetition($id)
    // {
    //     $competition = Competitions::findOrFail($id);

    //     $delete = $competition->delete();

    //     if ($delete) {
    //         return redirect('/admin/competitions')->with('message','Competition Deleted Successfully!');
    //     } else {
    //         return redirect('/admin/competitions')->with('error','You cannot delete this competition');
    //     }
        
    // }
    
}
