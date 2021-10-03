<?php

namespace App\Http\Controllers\Admin;

use App\Models\ForumThread;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\ForumCategory;
use App\Http\Controllers\Controller;

class AdminForumController extends Controller
{
    //all categories
    public function index()
    {
        $categories= ForumCategory::orderBy('created_at', 'desc')->paginate(30);
        
        return view('admin/forum/forum-categories')->with(['categories'=> $categories]);
    }

    //get single forum
    public function getSingleCategory($slug)
    {
        $explode = explode('-',$slug);
        $id = end($explode);
        $captcha_site_key_v3= Configuration::where('key','captcha_site_key_v3')->first();

        $cat = ForumCategory::where('id', $id)->firstOrFail();
        $threads = ForumThread::where('forum_category_id',$id)->latest()->paginate(30);
        return view('admin/forum/individual-category')->with(['category' => $cat, 'threads'=> $threads,
                                                             'captcha_site_key_v3'=>$captcha_site_key_v3->value]);

    }
}
