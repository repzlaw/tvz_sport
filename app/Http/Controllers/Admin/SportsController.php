<?php

namespace App\Http\Controllers\Admin;

use App\Models\SportType;
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
        $sport = SportType::create([
            'sport_type'=>$request->sport_type
        ]);

        if ($sport) {
            $message = 'Sport Created Successfully!';
        }

        return redirect('/admin/sports')->with(['message' => $message]);    
        
        // dd($request->all());
        
    }
}
