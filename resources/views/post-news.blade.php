@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row card">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="card-header"><h2 style="margin-left: 10%;">My News</h2></div>

                {{-- <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    {{-- <section class="row new-post">
                        <div class="col-md-6 col-md-offset-6">

                        </div> --}}
                    <br><br>
                    <form action="{{ route('news.editor.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                        {{ csrf_field() }}
                                <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Sport Type</span>
                                    </div>
                                    <select class="form-control custom-select" name="sport_type" required>
                                        <option value="">-- All Category -- </option> 
                                        @foreach ($sports as $sport)
                                        <option value="{{$sport->id}}">{{$sport->sport_type}} </option>                           
                                        @endforeach                          
                                    </select>
                                </div>
                                <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Page Title</span>
                                    </div>
                                    <input style="width: 80%; margin: auto;" type="text" name="page_title" class="form-control" placeholder="Page Title ...">
                                </div>
                                <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Meta description</span>
                                    </div>
                                    <input style="width: 80%; margin: auto;" type="text" name="meta_description"  class="form-control" placeholder="Meta description ...">
                                </div>
                            <input style="width: 80%; margin: auto;" type="text" name="news_title"  class="form-control" placeholder="News Title ..." required>
                            <br>
                            <textarea style="width: 80%; margin: auto;" name="news_body" id="new-post"  rows="5" class="form-control" placeholder="Write News Body here ..." required></textarea>
                            <br>
                            <button style="margin-left: 10%;" type="submit" class="btn btn-primary" >Create Post</button>
                            {{-- <input type="hidden" value="{{session::token()}}" name="_token"> --}}
                        </form>
                        
                        <hr>
                    {{-- </section> --}}
                    <section class="row posts" style="margin-left: 6%;" >
                        <div class="col-md-8 ">
                        <header><h4>My Posts</h4></header>
                       
                        
                        @if (count($posts)>0)
                            @foreach ($posts as $post)
                            
                                <article class="post" data-postid="{{ $post->id }}">

                                        <h5>{{$post->headline}} </h5>
                                        <span  data-competitionId="{{ $post->sport_type_id }}">
                                    <p>{{$post->content}}</p>
                                    <input type="hidden" name="sport_type_id" value="{{$post->sport_type_id}}">
                                    <br>
                                    <div class="interaction">
                                        | 
                                        <a href="#" class="edit">Edit</a> |
                                        <a href="{{route('news.editor.delete',['id'=>$post->id])}}">Delete</a>

                                    </div>
                                    <input type="hidden" name="page_title" id="post_page_title" value="{{$post->page_title}}">
                                    <input type="hidden" name="meta_description" id="post_meta_description" value="{{$post->meta_description}}">
                                    
                                </article>
                            @endforeach
                        @endif
                    </div>
                    
                    </section>
                        
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit News</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form >
              <div class="form-group">
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sport Type</span>
                    </div>
                    <select class="form-control custom-select" name="sport_type" id="sport-type" required>
                        <option value="">-- All Category -- </option> 
                        @foreach ($sports as $sport)
                        <option value="{{$sport->id}}">{{$sport->sport_type}} </option>                           
                        @endforeach                          
                    </select>
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Page Title</span>
                    </div>
                    <input  type="text" name="page_title" id="page-title" class="form-control" placeholder="Page Title ...">
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Meta description</span>
                    </div>
                    <input  type="text" name="meta_description" id="meta-description" class="form-control" placeholder="Meta description ...">
                </div>
                <input type="text" name="news_title" id="post-title" class="form-control" placeholder="News Title ..." required>
                <br>
                  <textarea name="post-body" id="post-body" rows="5" class="form-control"  placeholder="Write News Body here ..." required></textarea>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id = "modal-save">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

    <script>
        var token = '{{ Session::token() }}';
    </script>




@endsection

@section('scripts')
<script>

//get current data in modal
$('.post').find('.interaction').find('.edit').on('click',function(event){
    event.preventDefault();

    postTitleElement = event.target.parentNode.parentNode.parentNode.childNodes[1];
    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    competitionId = event.target.parentNode.parentNode.dataset['competitionid'];



    var postTitle = postTitleElement.textContent;
    var postBody = postBodyElement.textContent;
    var pageTitle = $('#post_page_title').val();
    var metaDescription = $('#post_meta_description').val();

    console.log(pageTitle);

    $('#sport-type').val(competitionId);
    $('#post-title').val(postTitle);
    $('#post-body').val(postBody);
    $('#page-title').val(pageTitle);
    $('#meta-description').val(metaDescription);
    $('#edit-modal').modal();
});

//save edited news
$('#modal-save').on('click', function(){
    $.ajax({
        method: 'POST',
        url: '{{ route('news.editor.edit')}}',
        data:{news_body: $('#post-body').val(), postId: postId, _token: token,
             news_title:$('#post-title').val(), sport_type:$('#sport-type').val(),
             page_title:$('#page-title').val(), meta_description:$('#meta-description').val(),
             }

    })
    .done(function(msg){
        // console.log(msg);
        $(postTitleElement).text(msg.post.headline);
        $(postBodyElement).text(msg.post.content);
        $('#edit-modal').modal('hide');
    })
    .fail(function(xhr, status, error) {
        alert(error)
    });;
});


</script>
@endsection
