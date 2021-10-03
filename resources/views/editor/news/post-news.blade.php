@extends('layouts.editor')

@section('content')
<div class="container mt-4">
    <div class="row card">
        <div class="col-md-12 col-md-offset-1">
            <p>page {{ $posts->currentPage() }} of {{ $posts->lastPage() }} , displaying {{ count($posts) }} of {{ $posts->total() }} record(s) </p>
            <div class="card-hover-shadow-2x mb-3 mt-3 card">

                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                        <h5> News</h5> 
                    </div>
                    {{-- <div class="float-right">
                        <p><a href="{{route('editor.news.create-view')}}" class="btn btn-primary btn-sm"  id="create-button">Create news </a></p>
                    </div> --}}
                </div> 

                <div class="card-body">
                    <div class="col-12 mb-3">
                        <form action="{{ route('editor.news.search')}}" method="get">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="input-group mb-4" >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Filter by</span>
                                        </div>
                                        <select class="form-control custom-select" name="query" id="search_column">
                                            <option value="">-- select -- </option> 
                                            <option value="published">Published </option>                           
                                            <option value="underreview">Under review </option>                           
                                            <option value="draft">Draft </option>                           
                                            <option value="trash">Trash </option>                           
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <section class="row posts"  >
                        @if (count($posts)>0)
                            @foreach ($posts as $post)
                            
                                <article class="post" data-postid="{{ $post->id }}">
                                    <a href="{{route('news.get.single',['news_slug'=>$post->url_slug.'-'.$post->id])}}"> 
                                        <h5 style="font-weight: bold;">{{$post->headline}} </h5>
                                        @if ($post->status == 'published')
                                            <h6 class="ml-2 text badge badge-pill badge-success badge-success">{{$post->status}}</h6>
                                        @else
                                            <h6 class="ml-2 text badge badge-pill badge-warning badge-warning">{{$post->status}}</h6>
                                        @endif
                                    </a>
                                    <span  data-competitionId="{{ $post->sport_type_id }}">
                                    <div>
                                        {!! $post->content !!}
                                    </div>
                                    <!-- <input type="hidden" name="sport_type_id" value="{{$post->sport_type_id}}"> -->
                                    @foreach ($post->teamnews as $teamnews)
                                        <span class="badge badge-secondary mr-1 mb-2">
                                            {{$teamnews->team->team_name}}
                                            {{-- <a href="{{route('editor.news.team.delete',['id'=>$teamnews->id])}}">
                                                <i class="text-danger fa fa-trash fa-1x" style="cursor:pointer;"></i>
                                            </a> --}}
                                        </span>
                                    @endforeach
                                    @foreach ($post->playernews as $playernews)
                                        <span  class="badge badge-secondary mr-1 mb-2">
                                            {{$playernews->player->name}}
                                            {{-- <a href="{{route('editor.news.player.delete',['id'=>$playernews->id])}}">
                                                <i class="text-danger fa fa-trash fa-1x" style="cursor:pointer;"></i>
                                            </a> --}}
                                        </span>
                                    @endforeach
                                        <br>
                                        <div class="interaction">
                                            | 
                                            <a href="{{route('news.get.single',['news_slug'=>$post->url_slug.'-'.$post->id])}}">View </a> |
                                            {{-- <a href="{{route('editor.news.edit-view',['news_id'=>$post->id])}}" class="edit">Edit</a> | --}}
                                            <a href="javascript:void(0)" onclick="changeStatus({{$post}})">Change Status</a>
                                            {{-- <a href="{{route('editor.news.delete',['id'=>$post->id])}}">Delete</a> --}}
                                        </div>
                                        <input type="hidden" name="page_title" id="post_page_title" value="{{$post->page_title}}">
                                        <input type="hidden" name="meta_description" id="post_meta_description" value="{{$post->meta_description}}">
                                        
                                </article>
                            @endforeach
                            {{ $posts->links() }}
                        @else
                            <div class="alert alert-info text-center">
                                <b>No post found</b>
                            </div>

                        @endif
                    </section>
                </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>

<!-- news status modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-status">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change news status</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('editor.news.status')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <div class="col-12 col-md-12">
                    <div class="input-group mb-4" >
                        <div class="input-group-prepend">
                            <span class="input-group-text">Status</span>
                        </div>
                        <select class="form-control custom-select" name="status" id="status" required>
                            <option value="published">Published </option>                           
                            <option value="underreview">Under review </option>                           
                            <option value="draft">Draft </option>                           
                            <option value="trash">Trash </option>                           
                        </select>
                    </div>
                </div>
                  <input  type="hidden" name="news_id" id="news-id" class="form-control"  required>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

@endsection

@section('scripts')
<script>
    function changeStatus(p) {
        $('#status').val(p.status);
        $('#news-id').val(p.id);
        $('#edit-status').modal();
    }
</script>
@endsection