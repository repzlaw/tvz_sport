<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuspensionHistory;
use Illuminate\Http\Request;

class UserSuspensionHistoriesController extends Controller
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
    
    //user suspension history page
    public function index()
    {
        $histories = SuspensionHistory::with('policy')->paginate(50);

        return view('admin/suspension-histories')->with(['histories'=> $histories]);
    }

    //search history
    public function searchHistory()
    {
        $searchData = $_GET['query'];
        $histories =[];

        if (!is_null($searchData)) {
            $histories = SuspensionHistory::where('user_id', 'like', "%$searchData%")
                                        ->with('policy')
                                        ->paginate(50);
        }

        return view('admin/suspension-histories')->with(['histories'=> $histories]);

    }
}
