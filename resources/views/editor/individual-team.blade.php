@extends('layouts.editor')

@section('title', $team->page_title)
@section('meta_description', $team->meta_description)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                Team Information
                            </div>
                            @if (Auth::guard('editor')->user()->editor_role_id === 1)
                                <div class="btn-actions-pane-right float-right">
                                    <p><a href="#" class="btn btn-warning btn-sm mr-3"  id="edit-button">Edit Team</a></p>
                                </div>
                            @endif
                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img
                                        src="/storage/images/team_images/{{$team->featured_image}}"
                                        alt="team"
                                        style="height: 150px; width:150px; border: 4px solid #eee; border-radius: 15px;"
                                    />
                                        
                                    <div class="btn-actions-pane-right mt-3">
                                        <p><a href="#" class="btn btn-info btn-sm mr-3"  id="edit-image-button">Edit Image</a></p>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <h6 class="ml-1 font-weight-bold">Team Name :</h6>
                                                </div>
                                                <h6 class="ml-2 text">{{$team->team_name}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Sport :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$team->sportType->sport_type}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Followers :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$followers}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Summary :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$team->summary}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>

                <div class="col-12 col-md-6">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                Team News
                            </div>
                            <div class="btn-actions-pane-right float-right">
                                <p><a href="{{route('editor.team.get-news',['team_slug'=>Route::input('team_slug')])}}" class="btn btn-primary btn-sm mr-3">
                                     All {{$team->team_name}}'s News</a></p>
                            </div>
                        </div> 

                        <div class="card-body">
                            @if (count($posts)>0)
                                @foreach ($posts as $post)
                                    <div class="mb-3">
                                        <a href="{{route('news.get.single',['news_slug'=>$post->news->url_slug.'-'.$post->news->id])}}"> 
                                            <h6>{{$post->news->headline}} </h6>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                    </div>
                </div>

            </div>

        </div>

        <!-- comment section -->
        <div class="col-10" id="footer">
            <div class="card-hover-shadow-2x mb-3 mt-3 card" id="comment_text" style="display:none;">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                       Team Comments
                    </div>
                </div> 

                <div class="card-body">
                    <div class="row ml-3">
                        <div class="input-group mb-4 mr-5" style="width: 250px; ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Select language</span>
                            </div>
                            <select class="form-control custom-select" name="language" onchange="getLanguage(this.value)"required>
                                <option value="en-us">English</option>
                                <option value="pt">Portuguese</option>
                                <option value="es">Spanish</option>
                                <option value="ru">Russian</option>                         
                            </select>
                        </div>
                        <div class="input-group mb-4" style="width: 250px; ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Order by</span>
                            </div>
                            <select class="form-control custom-select" name="orderby" onchange="getOrder(this.value)"required>
                                <option value="newest">Newest</option>
                                <option value="oldest">Oldest</option>
                                <option value="upvote">Upvotes</option>
                            </select>
                        </div>
                    </div>
                    <div class="comments">
                        <div id="comments_section">

                        </div>

                    </div>
                </div>
            </div>
                
        </div>
    </div>
</div>


<!-- edit team image modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-image">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change Team Image</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('editor.team.edit.image')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{$team->featured_image}}" required>
                <br>
                  <input  type="hidden" name="team_id" id="team-id" class="form-control" value="{{$team->id}}" required>

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


<!-- edit team modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Team</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('editor.team.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Page Title</span>
                    </div>
                    <input  type="text" name="page_title" id="page-title" class="form-control" placeholder="Page Title ..." value="{{$team->page_title}}">
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Meta description</span>
                    </div>
                    <input  type="text" name="meta_description" id="meta-description" class="form-control" placeholder="Meta description ..." value="{{$team->meta_description}}">
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sport Type</span>
                    </div>
                    <select class="form-control custom-select" name="sport_type_id" id="sport-type" required>
                        <option value="">-- All Category -- </option> 
                        @foreach ($sports as $sport)
                            <option value="{{$sport->id}}">{{$sport->sport_type}}</option>                           
                        @endforeach                          
                    </select>
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Team Name</span>
                    </div>
                    <input  type="text" name="team_name" id="team-name" class="form-control" placeholder="Team Name" value="{{$team->team_name}}" required>
                </div>
                <!-- <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{$team->featured_image}}" required>
                <br> -->
                  <textarea name="summary" id="team_summary" rows="5" class="form-control"  placeholder="Team Summary ..."  required>{{$team->summary}}</textarea>
                  <input  type="hidden" name="team_id" class="form-control" value="{{$team->id}}" required>

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
    <script>
        //edit modal
        $('#edit-button').on('click',function(event){
            event.preventDefault();
            $('#edit-modal').modal();
        });

        //edit image
        $('#edit-image-button').on('click',function(event){
            event.preventDefault();
            $('#edit-image').modal();
        });

        function follow(userId){
            var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: '{{ url('teams/follow')}}'+'/'+userId,
                    type: 'GET',
                    success: function (response)
                    {
                        if(response==true){
                            $("#follow").text("Unfollow")
                        }
                        if(response==false){
                            $("#follow").text("Follow")
                        }
                    },
                    error: function (error){
                        if (error.status === 403) {
                            window.location.href = "{{url('/email/verify')}}";
                        }
                    }
                });
        }
    </script>

<script>
    let language = 'en-us';
    let orderby = 'asc';

    function getOrder(order){
        orderby = order
        getComments();
    }

    function getLanguage(lang){
        language = lang
        getComments();
    }
    let status = true;
    let page = 1;

    //get comments ajax 
    function getComments() {
        status = false;
        $.ajax({
            method: 'GET',
            url: '{{ route('comment.get')}}',
            data:{pages:page, c: {{$team->id}}, lang: language, cat:'teams', orderby:orderby}

        })
        .done(function(msg){
            if (msg.comments.data.length) {
                let AuthUser = {{ auth()->check() ? 'true' : 'false' }}
                let auth_user_id = 0; 

                if (AuthUser === true) {
                    let user_details = {!! auth()->user() !!}
                    auth_user_id = user_details.id
                } 
                else{
                    auth_user_id = 0;
                }
                $("#comment_text").show();

                let comments = ``;
                msg.comments.data.forEach(com => {
                    //get image to display
                    let com_path = com.profile_pic;
                    let com_src = com_path ? "/storage/images/profile/"+com.profile_pic 
                                    : "/storage/images/profile/no_image.png";
                    let slug = com.username;
                    
                    comments += 
                        `<div id="comment_div${com.id}">
                            <div class="ml-2 col-12 col-md-8" 
                                            style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                            opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                            border-top-left-radius: 0.25rem; flex: 1;">
                                <a href="/user/profile/${slug}" style="text-decoration:none;">
                                    <img
                                        src="${com_src}"
                                        alt="${com.username}"
                                        style="height: 30px; width:30px;  border-radius: 15px;"/>
                                    <b class="ml-1 mr-5" style="color:black">${com.display_name ? com.display_name : com.username}</b>
                                </a>
                                <br>
                                <small class="comment_date" title="${com.created_at}">${com.created_at}</small>
                                <div class="mt-2"
                                    >
                                    ${com.content}
                                </div>
                            </div>
                            <div class="col-12 mt-1 ml-2">
                                <div class="row" id="reply_row${com.id}">
                                    <div href="javascript:void(0)" class="ml-2 mt-2" id="num_recommend${com.id}">${com.numRecommends} upvote</div>
                                </div>
                            </div>
                        </div>
                        <div id="reply_section${com.id}" class="ml-5" style="display:none">

                        </div>
                        <hr>
                        `;
                });
                $('#comments_section').html(comments);
                if (msg.comments.next_page_url !== null) {
                    $('#comments_section').append(`<div class="container m-auto" id="view_more" onclick="getComments('${msg.summary.lang_iso}')"><a href="javascript:void(0)">view more<a/></div>`);
                }
                msg.comments.data.forEach(com => {
                    if (com.reply.length) {
                        let view = `<p class="ml-4 mt-2" onclick="viewReplies(${com.id})"><a href="javascript:void(0)" id="view_reply${com.id}">view replies</a> </p>`;
                        $("#reply_row"+com.id).append(view);
                        let news_reply = '';   
                        com.reply.forEach(rep => {
                            //get image to display
                            let rep_path = rep.profile_pic;
                            let rep_src = rep_path ? "/storage/images/profile/"+rep.profile_pic 
                                            : "/storage/images/profile/no_image.png";
                            let repslug = rep.username;

                            news_reply += 
                                `<div id="reply_div${rep.id}">
                                    <div class="ml-2 col-12 col-md-8"
                                                    style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                    opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                    border-top-left-radius: 0.25rem; flex: 1;">
                                        <a href="/user/profile/${repslug}" style="text-decoration:none;">
                                            <img
                                            src="${rep_src}"
                                            alt="${rep.username}"
                                            style="height: 30px; width:30px;  border-radius: 15px;"/>
                                            <b class="ml-1 mr-5" style="color:black">${rep.display_name ? rep.display_name : rep.username}</b>
                                        </a>
                                        <br>
                                        <small class="comment_date" title="${rep.created_at}">${rep.created_at}</small>
                                        <div class="mt-2"
                                            >
                                            ${rep.content}
                                        </div>
                                    </div>
                                    <div class="col-12 mt-1 ml-2">
                                        <div class="row" id="rep_row${rep.id}">
                                            <div href="javascript:void(0)" class="ml-2 mt-2" id="num_recommend${rep.id}">${rep.numRecommends} upvote</div>
                                        </div>
                                    </div>

                                </div>
                                `;
                            
                        });
                        $("#reply_section"+com.id).html(news_reply);
                    }
                });
    
                page++;

            } else {
                let comments =
                    `<div class="alert alert-info text-center">
                        <b>No comments.</b>
                    </div>
                    `;
                $('#comments_section').html(comments);
            }
            
        })
        .fail(function(xhr, status, error) {
            // alert(error)
        });

    }

    //toggle replies
    function viewReplies(id){
        $("#reply_section"+id).toggle(1000);
        var text = $('#view_reply'+id).text();
        $('#view_reply'+id).text(
            text == "view replies" ? "hide replies" : "view replies");
    }

    //toggle reply form
    function replyForm(id){
        $("#reply_input"+id).toggle(1000);
        var text = $('#show_reply'+id).text();
        $('#show_reply'+id).text(
            text == "reply" ? "X" : "reply");
    }

    //load comments only on scroll
    $(document).scroll(function() {
        var value = $("#footer").offset().top,
            position = $(document).scrollTop() + $(window).height();
        if (status && position >= value ) {
            getComments('en-us');
        }
    });

    // Check if body height is less than or equal to window height :)
    $(document).ready(function() {
        if (status && $("body").height() <= $(window).height()) {
            getComments('en-us');
        }
    });

</script>
@endsection
