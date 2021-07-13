<?php

namespace App\Http\Controllers;

use App\Models\SportType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompetitionNews;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreNewsRequest;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('getSingleNews');
    }

    //return post news page
    public function index()
    {
        $user = Auth::user();
        if ($user->user_type === 'editor') {

            $editorsNews= CompetitionNews::where('posted_by', $user->id)->orderBy('updated_at','desc')->get();

            $sport_types = SportType::all();
            
            return view('post-news')->with(['posts' => $editorsNews, 'sports'=> $sport_types]);
        }
        return abort(404,"Page not found");
    }

    //create news function
    public function createNews(StoreNewsRequest $request)
    {
        $pagetitle = $request->page_title ? $request->page_title : $request->news_title;
        $metadescription = $request->meta_description ? $request->meta_description : $request->news_title;

        $slug = Str::slug($request->news_title, "-");

        $post = CompetitionNews::create([
                'sport_type_id'=> $request->sport_type,
                'url_slug'=> $slug,
                'headline'=> $request->news_title,
                'content'=> $request->news_body,
                'posted_by'=> Auth::user()->id,
                'page_title'=> $pagetitle,
                'meta_description'=> $metadescription,

        ]);
        if ( $post) {
            $message = 'Post Successfully Created!';
        }
        return redirect('/news/editor')->with(['message' => $message]);
    }

    //edit news
    public function editNews(Request $request)
    {
        $request->validate([
            'news_body' => 'required',
            'postId' => 'required',
            'news_title' => 'required',
            'sport_type' => 'required',
        ]);
        $post = CompetitionNews::findOrFail($request->postId);

        $pagetitle = $request->page_title ? $request->page_title : $request->news_title;
        $metadescription = $request->meta_description ? $request->meta_description : $request->news_title;

        $post->update([
            'sport_type_id'=> $request->sport_type,
            'headline'=> $request->news_title,
            'content'=> $request->news_body,
            'page_title'=> $pagetitle,
            'meta_description'=> $metadescription,
        ]);
        if ($post) {
            $message = 'Post Successfully Updated!';
        }

        return response()->json(['post' => $post, 'message'=>$message],200);
    }

    //delete news
    public function deleteNews($id)
    {
        $post = CompetitionNews::findOrFail($id);

         if (auth()->user()->id !== $post->posted_by) {
            
             return redirect('/news/editor')->with('error','You cannot delete this post');

         }

        $post->delete();
        return redirect('/news/editor')->with('message','Post Deleted');
    
    }

    //get individual news page
    public function getSingleNews($id, $news_slug)
    {
        $news = CompetitionNews::where(['id'=>$id, 'url_slug'=> $news_slug])->with('user')->firstOrFail();

        return view('individual-news')->with(['news'=>$news]);
    }

}
