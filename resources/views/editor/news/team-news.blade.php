@extends('layouts.editor')

@section('content')
<div class="container mt-4">
    <div class="row card">
        <div class="col-md-12 col-md-offset-1">
            <p>page {{ $posts->currentPage() }} of {{ $posts->lastPage() }} , displaying {{ count($posts) }} of {{ $posts->total() }} record(s) </p>
            <div class="card-hover-shadow-2x mb-3 mt-3 card">

                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                        <h5>{{$team->team_name}}'s News</h5> 
                    </div>
                </div> 

                <div class="card-body">
                    <section class="row posts"  >
                        @if (count($posts)>0)
                            @foreach ($posts as $post)
                            
                                <article class="post" data-postid="{{ $post->id }}">
                                    <a href="{{route('news.get.single',['news_slug'=>$post->news->url_slug.'-'.$post->news->id])}}"> 
                                        <h5 style="font-weight: bold;">{{$post->news->headline}} </h5>
                                    </a>
                                    <span  data-competitionId="{{ $post->sport_type_id }}">
                                    <div>
                                        {!! html_entity_decode($post->news->content) !!}
                                    </div>
                                        <input type="hidden" name="page_title" id="post_page_title" value="{{$post->page_title}}">
                                        <input type="hidden" name="meta_description" id="post_meta_description" value="{{$post->meta_description}}">
                                        
                                </article>
                            @endforeach
                            {{ $posts->links() }}
                        @else
                            <div class="alert alert-info text-center">
                                <b>No posts found</b>
                            </div>

                        @endif
                    </section>
                </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

