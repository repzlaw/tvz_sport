<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ForumCategory;
use Mews\Purifier\Facades\Purifier;
use App\Http\Controllers\Controller;

class ForumCategoriesController extends Controller
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
    
    //get category page
    public function index()
    {
        $categories= ForumCategory::orderBy('created_at', 'desc')->get();
        
        return view('admin/forum-category')->with(['categories'=> $categories]);
    }

    //create category
    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $name = Purifier::clean($request->name);
        $page_title = Purifier::clean($request->page_title);
        $meta_description = Purifier::clean($request->meta_description);

        if (!$name) {
            session()->flash('error','Invalid forum category');
            return back();
        }

        $pagetitle = $page_title ? $page_title : $name;
        $metadescription = $meta_description ? $meta_description : $name;
        $slug = Str::slug($request->name, "-");

        $category = ForumCategory::create([
            'name' => $name,
            'page_title' => $pagetitle,
            'meta_description' => $metadescription,
            'url_slug' => $slug,
        ]);

        if ($category) {
            $message = 'category Created Successfully!';
        }

        return back()->with(['message' => $message]);
    }

    //edit category
    public function editCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);

        $name = Purifier::clean($request->name);
        $page_title = Purifier::clean($request->page_title);
        $meta_description = Purifier::clean($request->meta_description);

        if (!$name) {
            session()->flash('error','Invalid forum category');
            return back();
        }

        $pagetitle = $page_title ? $page_title : $name;
        $metadescription = $meta_description ? $meta_description : $name;
        $slug = Str::slug($request->name, "-");

        $category = ForumCategory::findOrFail($request->category_id);

        $category = $category->update([
            'name' => $name,
            'page_title' => $pagetitle,
            'meta_description' => $metadescription,
            'url_slug' => $slug,
        ]);

        if ($category) {
            $message = 'category updated successfully!';
        }

        return back()->with(['message' => $message]);
    }
}
