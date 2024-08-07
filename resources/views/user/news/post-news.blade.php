@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row card">
        <div class="col-md-12 col-md-offset-1">
            <p>page {{ $posts->currentPage() }} of {{ $posts->lastPage() }} , displaying {{ count($posts) }} of {{ $posts->total() }} record(s) </p>
            <div class="card-hover-shadow-2x mb-3 mt-3 card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                        <h5>My News</h5> 
                    </div>
                    <div class="float-right">
                        <p><a href="{{route('user.news.create-view')}}" class="btn btn-primary btn-sm"  id="create-button">Create news </a></p>
                    </div>
                </div> 
                <div class="card-body">
                    <section class="row posts">
                        @if (count($posts)>0)
                            @foreach ($posts as $post)
                                <article class="post" data-postid="{{ $post->id }}">
                                    <a href="{{route('news.get.single',['news_slug'=>$post->url_slug.'-'.$post->id])}}"> 
                                        <h5 style="font-weight: bold;">{{$post->headline}} </h5>
                                        @if ($post->status == 'published')
                                            <h6 class="ml-2 text badge badge-pill badge-success badge-success">{{$post->status}}</h6>
                                        @else
                                            <h6 class="ml-2 text badge badge-pill badge-info badge-info">{{$post->status}}</h6>
                                        @endif
                                    </a>
                                    <span data-competitionId="{{ $post->sport_type_id }}">
                                    <div>
                                        {!! $post->content !!}
                                    </div>
                                    @foreach ($post->teamnews as $teamnews)
                                        <span class="badge badge-secondary mr-1 mb-2">
                                            {{$teamnews->team->team_name}}
                                            <a href="{{route('user.news.team.delete',['id'=>$teamnews->id])}}">
                                                <i class="text-danger fa fa-trash fa-1x" style="cursor:pointer;"></i>
                                            </a>
                                        </span>
                                    @endforeach
                                    @foreach ($post->playernews as $playernews)
                                        <span  class="badge badge-secondary mr-1 mb-2">
                                            {{$playernews->player->name}}
                                            <a href="{{route('user.news.player.delete',['id'=>$playernews->id])}}">
                                                <i class="text-danger fa fa-trash fa-1x" style="cursor:pointer;"></i>
                                            </a>
                                        </span>
                                    @endforeach
                                        <br>
                                        <div class="interaction">
                                            | 
                                            <a href="{{route('news.get.single',['news_slug'=>$post->url_slug.'-'.$post->id])}}">View </a> |
                                            <a href="{{route('user.news.edit-view',['news_id'=>$post->id])}}" class="edit">Edit</a> 
                                            @if (Auth::id()=== $post->posted_by)
                                                | <a href="{{route('user.news.delete',['id'=>$post->id])}}">Delete</a>
                                            @endif
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

