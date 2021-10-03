@extends('layouts.app')

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
                                alt="{{ Auth::user()->username}}"
                                style="height: 30px; width:30px;  border-radius: 15px;"/>
                              @endif
                              <b class="ml-1 " style="color:black">{{$thread->user->display_name ? $thread->user->display_name : $thread->user->username}}</b>
                            </a>
                             | <b class="ml-1 " style="color:black"> {{$thread->created_at}}</b>
                          </div> 
                          {{$thread->body}} 
                              <div class="interaction mt-2">
                              {{-- |  --}}
                              {{-- <a href="{{route('news.get.single',['news_slug'=>$post->url_slug.'-'.$post->id])}}">View </a> | --}}
                              {{-- <div class="row"> --}}
                                @auth()
                                  {{-- <p class="ml-4 mt-2" onclick="upvoteComment(${rep.uuid},'${com.uuid}')"> --}}
                                    <a href="javascript:void(0)" onclick="upvoteThread({{$thread->id}})" ><i class="far fa-thumbs-up" id="upvote_comment_icon${rep.id}"></i></a>
                                  {{-- </p> --}}
                                  <a href="javascript:void(0)" style="text-decoration: none;" class="ml-1 mt-2" id="num_recommend_thread">{{$thread->numRecommends}} </a>
                                  <a href="javascript:void(0)" onclick="downvoteThread({{$thread->id}})" ><i class="far fa-thumbs-down ml-2 mr-2" id="upvote_comment_icon${rep.id}"></i></a>

                                  @if (Auth::id()=== $thread->user->id)
                                  |  <a href="javascript:void(0)" onclick="editThreadModal({{$thread}})" class="edit">Edit</a>  
                                  @endif
                                  |  <a href="javascript:void(0)" onclick="editThreadModal({{$thread}})" class="edit">Report</a> 
                                @else
                                  <a href="/login" class="text-danger">Login to upvote thread</a>
                                @endauth
                              {{-- </div> --}}
                              {{-- @if (Auth::id()=== $post->posted_by)
                                  | <a href="{{route('user.news.delete',['id'=>$post->id])}}">Delete</a>
                              @endif --}}
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
                      <div class=" float-right">
                        @auth()
                          <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create post</a></p>
                        @else
                          <a href="/login" class="text-danger">Login to create threads</a>
                        @endauth
                    </div>
                  </div> 
                  <ul class="list-group list-group-flush">
                      @forelse ($posts as $key =>$post)
                        <li class="list-group-item">
                          <div class="thread" data-postid="{{ $post->id }}">
                            <div class="mb-3 ">
                              <strong > #{{$key +1}}</strong>
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
                              <div class="interaction">
                                <a href="javascript:void(0)" onclick="upvotePost({{$post->id}})" ><i class="far fa-thumbs-up"></i></a>
                                <a href="javascript:void(0)" style="text-decoration: none;" class="ml-1 mt-2" id="num_post{{$post->id}}">{{$post->numRecommends}} </a>
                                @if (Auth::id()=== $post->user->id)
                                  | <a href="javascript:void(0)" onclick="editModal({{$post}})" class="edit">Edit</a>  
                                @endif
                                 |  <a href="javascript:void(0)" onclick="editPostModal({{$thread}})" class="edit">Report</a> 

                              </div>
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

<!-- create post modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create post</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <form action="{{ route('forum.post.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                  {{ csrf_field() }}
            <div class="form-group">
              @honeypot
              <textarea name="body" id="team_summary" rows="5" class="form-control"  placeholder="write post here ..." value="{{ old('body') }}" required></textarea>
              <input type="hidden" name="forum_thread_id" id="forum_thread_id" value="{{ $thread->id }}" required>
              <input type="hidden" name="recaptcha" id="recaptcha" class="recaptchaResponse">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id = "modal-save">Save changes</button>
            </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit post modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit post</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <form action="{{ route('forum.post.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  @honeypot

            <div class="form-group">
              <textarea name="body" id="body" rows="5" class="form-control"  placeholder="write post here ..." value="{{ old('body') }}" required></textarea>
              <input type="hidden" name="post_id" id="post_id" value="" required>
              <input type="hidden" name="recaptcha" id="recaptcha" class="recaptchaResponse">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id = "modal-save">Save changes</button>
            </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit thread modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-thread-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit thread</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <form action="{{ route('forum.thread.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  @honeypot
            <div class="form-group">
              <div class="input-group mb-4" >
                <div class="input-group-prepend">
                    <span class="input-group-text">Thread Title</span>
                </div>
                <input  type="text" name="title" id="thread_title" class="form-control" placeholder="Thread Title ..." value="{{ old('title') }}">
              </div>
              <textarea name="body" id="thread_body" rows="5" class="form-control"  placeholder="write thread here ..." value="{{ old('body') }}" required></textarea>
              <input type="hidden" name="thread_id" id="thread_id" value="" required>
              <input type="hidden" name="recaptcha" id="recaptcha" class="recaptchaResponse">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id = "modal-save">Save changes</button>
            </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js?render={{ $captcha_site_key_v3 }}"></script>
<script>
         grecaptcha.ready(function() {
             grecaptcha.execute("{{ $captcha_site_key_v3 }}", {action: 'forumpost'}).then(function(token) {
                if (token) {
                  document
                  .querySelectorAll(".recaptchaResponse")
                  .forEach(elem => (elem.value = token));
                }
             });
         });
</script>
<script>
//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal();
});

function editModal(post) {
  $('#body').val(post.body);
  $('#post_id').val(post.id);
  $('#edit-modal').modal();
}

function editThreadModal(thread) {
  $('#thread_body').val(thread.body);
  $('#thread_title').val(thread.title);
  $('#thread_id').val(thread.id);
  $('#edit-thread-modal').modal();
}

//upvote or remove upvote
function upvoteThread(id){
  $.ajax({
      method:'POST',
      url: '{{ route('forum.thread.upvote')}}',
      data:{"_token": "{{ csrf_token() }}", thread_id:id}
  })
  .done(function(res){
      $("#num_recommend_thread").text(res.numRecommends);
  })
}

//downvote or remove downupvote
function downvoteThread(id){
  $.ajax({
      method:'POST',
      url: '{{ route('forum.thread.downvote')}}',
      data:{"_token": "{{ csrf_token() }}", thread_id:id}
  })
  .done(function(res){
      $("#num_recommend_thread").text(res.numRecommends);
  })
}


//upvote or remove post
function upvotePost(id){
  $.ajax({
      method:'POST',
      url: '{{ route('forum.post.upvote')}}',
      data:{"_token": "{{ csrf_token() }}", post_id:id}
  })
  .done(function(res){
      $("#num_post"+id).text(res.numRecommends);
  })
}

</script>
    
@endsection