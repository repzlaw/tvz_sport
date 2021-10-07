@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-8 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                          <h5>{{$thread->title}} </h5> 
                        </div>
                        <div class=" float-right">
                      </div>
                    </div> 
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        <div class="thread" data-postid="{{ $thread->id }}">
                          <div class=" mb-2" > 
                            <a href="/profile/{{$thread->user->username}}" style="text-decoration:none;">
                              @if ($thread->user->picture)
                                <img
                                src="/storage/images/profile/{{$thread->user->picture->file_path}}"
                                alt="{{$thread->user->display_name ? $thread->user->display_name : $thread->user->username}}"
                                style="height: 30px; width:30px;  border-radius: 15px;"/>
                              @else
                                <img
                                src="/storage/images/profile/no_image.png"
                                alt="{{$thread->user->display_name ? $thread->user->display_name : $thread->user->username}}"
                                style="height: 30px; width:30px;  border-radius: 15px;"/>
                              @endif
                              <b class="ml-1 " style="color:black">{{$thread->user->display_name ? $thread->user->display_name : $thread->user->username}}</b>
                            </a>
                             | <b class="ml-1 " style="color:black"> {{$thread->created_at}}</b>
                          </div> 
                          {{$thread->body}} 
                              <div class="interaction mt-2">
                                {{-- @auth()
                                    <a href="javascript:void(0)" onclick="upvoteThread({{$thread->id}})" ><i class="far fa-thumbs-up" id="upvote_comment_icon${rep.id}"></i></a>
                                  <a href="javascript:void(0)" style="text-decoration: none;" class="ml-1 mt-2" id="num_recommend_thread">{{$thread->numRecommends}} </a>
                                  <a href="javascript:void(0)" onclick="downvoteThread({{$thread->id}})" ><i class="far fa-thumbs-down ml-2 mr-2" id="upvote_comment_icon${rep.id}"></i></a>

                                  @if (Auth::id()=== $thread->user->id)
                                  |  <a href="javascript:void(0)" onclick="editThreadModal({{$thread}})" class="edit">Edit</a>  
                                  @endif
                                  |  <a href="javascript:void(0)" onclick="editThreadModal({{$thread}})" class="edit">Report</a> 
                                @else
                                  <a href="/login" class="text-danger">Login to upvote thread</a>
                                @endauth --}}
                            </div>
                        </div>
                      </li> 
                    </ul>
                </div>
            </div>

            <div class="col-12 col-md-8 m-auto">
              <div class="card-hover-shadow-2x mb-3 mt-3 card">
                  <div class="card-header-tab card-header">
                      <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                        <h5> posts</h5> 
                      </div>
                      {{-- <div class=" float-right">
                        @auth()
                          <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create post</a></p>
                        @else
                          <a href="/login" class="text-danger">Login to create threads</a>
                        @endauth
                      </div> --}}
                  </div> 
                  <ul class="list-group list-group-flush">
                      @forelse ($posts as $key =>$post)
                        <li class="list-group-item">
                          <div class="thread" data-postid="{{ $post->id }}">
                            <div class="mb-3">
                              <strong > #{{$key +1}}  </strong>
                              @if ($post->status == 'published')
                                  <h6 class="ml-2 text badge badge-pill badge-success badge-success">{{$post->status}}</h6>
                              @else
                                  <h6 class="ml-2 text badge badge-pill badge-warning badge-warning">{{$post->status}}</h6>
                              @endif
                              <span class="float-right mr-2" > 
                                <a href="/profile/{{$post->user->username}}" style="text-decoration:none;">
                                @if ($post->user->picture)
                                  <img
                                  src="/storage/images/profile/{{$post->user->picture->file_path}}"
                                  alt="{{$post->user->display_name ? $post->user->display_name : $post->user->username}}"
                                  style="height: 30px; width:30px;  border-radius: 15px;"/>
                                @else
                                  <img
                                  src="/storage/images/profile/no_image.png"
                                  alt="{{ $post->user->username}}"
                                  style="height: 30px; width:30px;  border-radius: 15px;"/>
                                @endif
                                  <b class="ml-1 " style="color:black">{{$post->user->display_name ? $post->user->display_name : $post->user->username}}</b>
                                </a>
                                 | <b class="ml-1 " style="color:black"> {{$post->created_at}}</b>
                              </span> 

                            </div>
                                {{$post->body}}
                            <div class="mt-2">
                              <a href="javascript:void(0)" onclick="changeStatus({{$post}})">Change Status</a>
                              {{-- <div class="interaction">
                                <a href="javascript:void(0)" onclick="upvotePost({{$post->id}})" ><i class="far fa-thumbs-up"></i></a>
                                <a href="javascript:void(0)" style="text-decoration: none;" class="ml-1 mt-2" id="num_post{{$post->id}}">{{$post->numRecommends}} </a>
                                @if (Auth::id()=== $post->user->id)
                                  | <a href="javascript:void(0)" onclick="editModal({{$post}})" class="edit">Edit</a>  
                                @endif
                                 |  <a href="javascript:void(0)" onclick="editPostModal({{$thread}})" class="edit">Report</a> 

                              </div> --}}
                            </div>
                          </div>
                        </li>
                      @empty
                        <div class="alert alert-info text-center">
                          <b>Be the first to comment</b>
                        </div>
                      @endforelse  
                      {{ $posts->links() }}
                  </ul>
              </div>
          </div>
        </div>
    </div>
    </div>
</div>

<!-- post status modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-status">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change post status</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <form action="{{ route('admin.forum.post.status')}}" method="post" class="form-group" enctype="multipart/form-data">
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
                <input  type="hidden" name="post_id" id="post_id" class="form-control"  required>
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
    $('#post_id').val(p.id);
    $('#edit-status').modal();
  }


</script>
    
@endsection