@extends('layouts.app')

@section('title', $player->page_title)
@section('meta_description', $player->meta_description)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                Player Information
                            </div>
                            @auth
                                <div class="btn-actions-pane-right float-right">
                                    @if(Auth::user()->isFollowingPlayer(Auth::user()->id, $player->id))
                                        <p><a href="#" class="btn btn-primary btn-sm" onclick="follow({{$player->id}})" id="follow">Unfollow</a></p>
                                    @else
                                        <p><a href="#" class="btn btn-primary btn-sm" onclick="follow({{$player->id}})" id="follow">Follow</a></p>
                                    @endif
                                </div>

                                <!-- <div class="btn-actions-pane-right float-right">
                                    <p><a href="#" class="btn btn-warning btn-sm mr-3"  id="edit-button">Edit Player</a></p>
                                </div> -->

                            @endauth
                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <!-- {{$player}} -->
                                <div class="col-sm-3">
                                    <img
                                        src="/storage/images/player_images/{{$player->featured_image}}"
                                        alt="Avatar 5"
                                        style="height: 150px; width:150px; border: 4px solid #eee; border-radius: 15px;"
                                    />
                                    @auth
                                        
                                        <div class="btn-actions-pane-right mt-3">

                                            @if(Auth::user()->user_type === 'editor')
                                                <p><a href="#" class="btn btn-info btn-sm mr-3"  id="edit-image-button">Edit Image</a></p>
                                            @endif
                                        </div>

                                    @endauth
                                </div>

                                <div class="col-sm-8">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Player name :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->name}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Fullname :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->full_name}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Sport :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->sportType->sport_type}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Team :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->Team->team_name}}</h6>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Active since :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->active_since}}</h6>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-12 mb-2">
                                            <div class="ml-1 badge badge-pill badge-success badge-success">{{$player->status}}</div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid bg-success text-white mt-1 px-3 py-1">
                            <p style="margin-bottom:0.2rem !important;" class="font-weight-bold">
                                <i class="fa fa-info-circle mr-2"></i> OTHER INFORMATION
                            </p>
                            </div>
                            <div class="row">
                            <div class="col-sm-12 mt-3">
                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Status :</h6>
                                        </div>
                                        <h6 class="ml-2 text badge badge-pill badge-success badge-success">{{$player->status}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Date Of Birth :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$player->birth_date}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Country :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$player->country}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Total Earnings :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$player->total_earnings}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Role :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$player->role}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <h6 class="ml-2 font-weight-bold">Followers :</h6>
                                    </div>
                                    <h6 class="ml-2 text">{{$followers}}</h6>
                                </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <h6 class="ml-2 font-weight-bold">Signature Hero :</h6>
                                        </div>
                                        <h6
                                        class="ml-2 text"
                                        v-if="institution.lgas != null"
                                        >{{$player->signature_hero}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <h6 class="ml-2 font-weight-bold">Summary :</h6>
                                        </div>
                                        <h6
                                        class="ml-2 text"
                                        v-if="institution.lgas != null"
                                        >{{$player->summary}}</h6>
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
                                Player News
                            </div>
                            <div class="btn-actions-pane-right float-right">
                                <p><a href="{{route('player.get-news',['player_slug'=>Route::input('player_slug')])}}" class="btn btn-primary btn-sm mr-3">
                                     All {{$player->full_name}}'s News</a></p>
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
                       Player Comments
                    </div>
                </div> 

                <div class="card-body">
                    @guest()
                        <p>please <a href="/login">log in</a>  or <a href="/register">sign up</a>  to comment</p>

                    @else
                        <form action="{{ route('player.comment.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="interaction mt-3 mb-3 row">
                                <div class="col-9 col-sm-9" style="padding-right: 0;">
                                    <textarea placeholder="Add comment ..." name="comment" type="text" 
                                    class="form-control-lg form-control mb-3" style="border-radius: 30px !important;" required></textarea>
                                    <select name="language" required>
                                        <option value="English">English</option>
                                        <option value="Portuguese">Portuguese</option>
                                        <option value="Spanish">Spanish</option>
                                        <option value="Russian">Russian</option>
                                    </select>
                                </div>
                                <div class="col-3 col-sm-3 mt-3 float-right">
                                    <!-- <button class="btn btn-info b-circle" type="button" ><i class="fa fa-paperclip"></i></button> -->
                                    <button type="submit" class="btn btn-primary b-circle">
                                        <i class="fa fa-paper-plane"></i>
                                    </button>
                                </div> 
                            </div>
                            <input type="hidden" name="player_id" value="{{$player->id}}">
                        </form>
                        <hr>

                    @endguest
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

<!-- edit player image modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-image">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change Player Image</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('player.edit.image')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Player Image ..." value="{{$player->featured_image}}" required>
                <br>
                <input  type="hidden" name="player_id" id="player-id" class="form-control" value="{{$player->id}}" required>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Save changes</button>
              </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<!-- edit player modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Player</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        @auth
                <form action="{{ route('player.user.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
        @endauth
                    {{ csrf_field() }}
              <div class="form-group row">
                
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Page Title</span>
                    </div>
                    <input  type="text" name="page_title" id="page-title" class="form-control" placeholder="Page Title ..." value="{{$player->page_title}}">
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Meta description</span>
                    </div>
                    <input  type="text" name="meta_description" id="meta-description" class="form-control" placeholder="Meta description ..." value="{{$player->meta_description}}">
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sport Type</span>
                    </div>
                    <select class="form-control custom-select" name="sport_type_id" id="sport-type" required >
                        <option value="">-- All Sports -- </option> 
                        @foreach ($sports as $sport)
                            <option value="{{$sport->id}}">{{$sport->sport_type}} </option>                           
                        @endforeach                          
                    </select>
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Team</span>
                    </div>
                    <select class="form-control custom-select" name="team_id" required >
                        <option value="">-- All Teams -- </option> 
                        @foreach ($teams as $team)
                            <option value="{{$team->id}}">{{$team->team_name}}</option>                           
                        @endforeach                          
                    </select>
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Player Name</span>
                    </div>
                    <input  type="text" name="name" id="player-name" class="form-control" placeholder="Player Name" value="{{$player->name}}" required>
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Player Full Name</span>
                    </div>
                    <input  type="text" name="full_name" id="full_name" class="form-control" placeholder="Player Full Name" value="{{$player->full_name}}" required>
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Country</span>
                    </div>
                    <input  type="text" name="country" id="country" class="form-control" placeholder="country" value="{{$player->country}}" >
                </div>

                <!-- <div class="input-group col-12 col-md-6 mb-4" >
                    <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Player Image ..." value="{{ old('featured_image') }}" required>
                </div> -->
                
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Birth Date</span>
                    </div>
                    <input  type="date" name="birth_date" id="birth_date" class="form-control" placeholder="active since" value="{{$player->birth_date}}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Active Since</span>
                    </div>
                    <input  type="date" name="active_since" id="active_since" class="form-control" placeholder="active since" value="{{$player->active_since}}" required>
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <input  type="text" name="status" id="status" class="form-control" placeholder="Status" value="{{$player->status}}" required>
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Role</span>
                    </div>
                    <input  type="text" name="role" id="role" class="form-control" placeholder="Role" value="{{$player->role}}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Signature Hero</span>
                    </div>
                    <input  type="text" name="signature_hero" id="signature_hero" class="form-control" placeholder="Signature Hero" value="{{$player->signature_hero}}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Total Earnings</span>
                    </div>
                    <input  type="number" name="total_earnings" id="total_earnings" class="form-control" placeholder="total earnings" value="{{$player->total_earnings}}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Followers</span>
                    </div>
                    <input  type="number" name="followers" id="followers" class="form-control" placeholder="Status" value="{{$player->followers}}" >
                </div>

                <div class="input-group col-12 mb-4" >
                  <textarea name="summary" id="player_summary" rows="5" class="form-control"  placeholder="Player Summary ..." value="{{$player->summary}}" >{{$player->summary}}</textarea>
                </div>
                <input  type="hidden" name="player_id" class="form-control" value="{{$player->id}}" required>

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
                    url: '{{ url('players/follow')}}'+'/'+userId,
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
    // let last_page = 0;

    //get comments ajax 
    function getComments() {
        // let page_no = page +1;
        status = false;
        $.ajax({
            method: 'GET',
            url: '{{ route('comment.get')}}',
            data:{pages:page, c: {{$player->id}}, lang: language, cat:'players', orderby:orderby}
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
                    
                    comments += 
                        `<div id="comment_div${com.id}">
                            <div class="ml-2 col-12 col-md-8" 
                                            style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                            opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                            border-top-left-radius: 0.25rem; flex: 1;"
                            >
                                <img
                                    src="${com_src}"
                                    alt="${com.username}"
                                    style="height: 30px; width:30px;  border-radius: 15px;"/>
                                <b class="ml-1 mr-5">${com.display_name ? com.display_name : com.username}</b>
                                <br>
                                <small class="comment_date" title="${com.created_at}">${com.created_at}</small>
                                <div class="mt-2"
                                    >
                                    ${com.content}
                                </div>
                            </div>
                            <div class="col-12 mt-1">
                                <div class="row" id="reply_row${com.id}">
                                    @auth()
                                        <p class="ml-4 mt-2" onclick="upvoteComment(${com.id})"><a href="javascript:void(0)" ><i class="far fa-thumbs-up" id="upvote_comment_icon${com.id}"></i></a></p>
                                        <a href="javascript:void(0)" class="ml-2 mt-2" id="num_recommend${com.id}">${com.numRecommends}</a>
                                        <p class="ml-4 mt-2" onclick="replyForm(${com.id})"><a href="javascript:void(0)" id="show_reply${com.id}">reply</a> </p>
                                    @else
                                        <div href="javascript:void(0)" class="ml-3 mt-2">${com.numRecommends} upvote</div>
                                    @endauth
                                </div>
                            </div>
                        </div>
        
                        <div id="reply_input${com.id}" class="ml-5" style="display:none">
                            <div class="ml-2 col-12 col-md-8"
                                            style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                            opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                            border-top-left-radius: 0.25rem; flex: 1;">
                                <form action="{{ route('player.comment.reply.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="interaction mt-3 mb-3 row">
                                        <div class="col-9 col-sm-9" style="padding-right: 0;">
                                            @guest()
                                                <p>please <a href="/login">log in</a>  or <a href="/register">sign up</a>  to reply</p>
                                            @endguest
                                            <textarea placeholder="Reply comment ..." name="comment"
                                                    type="text" class="form-control-lg form-control  mb-3" style="border-radius: 30px !important;" 
                                                    required></textarea>

                                                    <select name="language" required>
                                                        <option value="English">English</option>
                                                        <option value="Portuguese">Portuguese</option>
                                                        <option value="Spanish">Spanish</option>
                                                        <option value="Russian">Russian</option>
                                                    </select>
                                        </div>
                                        <div class="col-3 col-sm-3 mt-3 float-right">
                                            <button type="submit" class="btn btn-primary b-circle">
                                                <i class="fa fa-paper-plane"></i>
                                            </button>
                                        </div> 
                                    </div>
                                    <input type="hidden" name="comment_id" value="${com.id}">
                                    <input type="hidden" name="player_id" value="${com.player_id}">
                                </form>
                            </div>
                            <br>
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
                    if (auth_user_id) {
                        // checkUpvote(com.id)
                        if (auth_user_id === com.user_id) {
                            // let delete_comment = `<p class="ml-4 mt-2" onclick="deleteComment(${com.id},${com.user_id})"><a href="javascript:void(0)" id="delete_comment${com.id}">delete</a> </p>`;
                            // $("#reply_row"+com.id).append(delete_comment);
                        }else{
                            let report_comment = `<p class="ml-4 mt-2" onclick="reportComment(${com.id},${com.user_id})"><a href="javascript:void(0)" id="report_comment${com.id}">report</a> </p>`;
                            $("#reply_row"+com.id).append(report_comment);
                        }
                    }
                    if (com.reply.length) {
                        let view = `<p class="ml-4 mt-2" onclick="viewReplies(${com.id})"><a href="javascript:void(0)" id="view_reply${com.id}">view replies</a> </p>`;
                        $("#reply_row"+com.id).append(view);
                        let news_reply = '';   
                        com.reply.forEach(rep => {
                            //get image to display
                            let rep_path = rep.profile_pic;
                            let rep_src = rep_path ? "/storage/images/profile/"+rep.profile_pic 
                                            : "/storage/images/profile/no_image.png";

                            news_reply += 
                                `<div id="reply_div${rep.id}">
                                    <div class="ml-2 col-12 col-md-8"
                                                    style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                    opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                    border-top-left-radius: 0.25rem; flex: 1;"
                                    >
                                        <img
                                            src="${rep_src}"
                                            alt="${rep.username}"
                                            style="height: 30px; width:30px;  border-radius: 15px;"/>
                                        <b class="ml-1 mr-5">${rep.display_name ? rep.display_name : rep.username}</b>
                                        <br>
                                        <small class="comment_date" title="${rep.created_at}">${rep.created_at}</small>
                                        <div class="mt-2"
                                            >
                                            ${rep.content}
                                        </div>
                                    </div>
                                    <div class="col-12 mt-1">
                                        <div class="row" id="rep_row${rep.id}">
                                            @auth()
                                                <p class="ml-4 mt-2" onclick="upvoteComment(${rep.id})"><a href="javascript:void(0)" ><i class="far fa-thumbs-up" id="upvote_comment_icon${rep.id}"></i></a></p>
                                                <a href="javascript:void(0)" class="ml-2 mt-2" id="num_recommend${rep.id}">${rep.numRecommends}</a>
                                                ${auth_user_id === rep.user_id ? 
                                                    `<span/>`
                                                    // `<p class="ml-4 mt-2" onclick="deleteReply(${rep.id},${rep.user_id})"><a href="javascript:void(0)" id="delete_reply${rep.id}">delete</a> </p>` 
                                                    :  `<p class="ml-4 mt-2" onclick="reportComment(${rep.id},${rep.user_id})"><a href="javascript:void(0)" id="report_reply${rep.id}">report</a> </p>`
                                                }
                                            @else
                                                <div href="javascript:void(0)" class="ml-3 mt-2">${rep.numRecommends} upvote</div>
                                            @endauth
                                        </div>
                                    </div>

                                </div>
                                `;
                            
                        });
                        $("#reply_section"+com.id).html(news_reply);
                        if (auth_user_id) {
                            com.reply.forEach(rep => {
                                // checkUpvote(rep.id)
                            });
                        }

                    }
                });
                page++;

            } else {
                let comments =
                    `<div class="alert alert-info text-center">
                        <b>Be the first to comment.</b>
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

    //delete comment
    // function deleteComment(com_id,user_id){
    //     $.ajax({
    //         method:'GET',
    //         url: '{{ route('comment.delete')}}',
    //         data:{user_id:user_id, comment_id:com_id, mod:'player'}
    //     })
    //     .done(function(res){
    //         if (res.status) {
    //             $('#comment_div'+res.comment_id).remove();
    //         }
    //     })
    // }

    //delete reply
    // function deleteReply(com_id,user_id){
    //     $.ajax({
    //         method:'GET',
    //         url: '{{ route('comment.reply.delete')}}',
    //         data:{user_id:user_id, comment_id:com_id, mod:'player'}
    //     })
    //     .done(function(res){
    //         if (res.status) {
    //             $('#reply_div'+res.comment_id).remove();
    //         }
    //     })
    // }

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

    // report comment
    function reportComment(){

    }

    //check if comment is upvoted
    function checkUpvote(com_id){
        $.ajax({
            method:'GET',
            url: '{{ route('comment.check.upvote')}}',
            data:{comment_id:com_id, model:'player'}
        })
        .done(function(res){
            if (res) {
                $("#upvote_comment_icon"+com_id).attr('class', 'fas fa-thumbs-up');
            
            }
        })
    }

    //upvote or remove vote
    function upvoteComment(com_id){
        $.ajax({
            method:'GET',
            url: '{{ route('comment.upvote')}}',
            data:{comment_id:com_id, model:'player'}
        })
        .done(function(res){
            $("#num_recommend"+com_id).text(res.numRecommends);
            res.status ?
                $("#upvote_comment_icon"+com_id).attr('class', 'fas fa-thumbs-up')
            :
                $("#upvote_comment_icon"+com_id).attr('class', 'far fa-thumbs-up')
        })
    }
</script>
@endsection
