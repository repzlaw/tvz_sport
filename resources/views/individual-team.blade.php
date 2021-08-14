@extends('layouts.app')

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
                                @auth
                                    <div class="btn-actions-pane-right float-right">
                                        @if(Auth::user()->isFollowingTeam(Auth::user()->id, $team->id))
                                            <p><a href="#" class="btn btn-primary btn-sm" onclick="follow({{$team->id}})" id="follow">Unfollow</a></p>
                                        @else
                                            <p><a href="#" class="btn btn-primary btn-sm" onclick="follow({{$team->id}})" id="follow">Follow</a></p>
                                        @endif
                                    </div>
                                    <div class="btn-actions-pane-right float-right">

                                        <p><a href="#" class="btn btn-warning btn-sm mr-3"  id="edit-button">Edit Team</a></p>
                                        <!-- @if(Auth::user()->user_type === 'editor') -->
                                        <!-- @endif -->

                                        <!-- @if(Auth::user()->user_type === 'user')
                                            <p><a href="#" class="btn btn-warning btn-sm mr-3"  id="edit-button-user">Edit Team</a></p>
                                        @endif -->
                                    </div>

                                @endauth
                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img
                                        src="/storage/images/team_images/{{$team->featured_image}}"
                                        alt="team"
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

                                        

                                       <!--  <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Email :</h6>
                                            </div>
                                            <h6 class="ml-2 text">feef</h6>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-md-12 mb-2">
                                            <div class="ml-1 badge badge-pill badge-success badge-success">Active</div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="container-fluid bg-success text-white mt-3 px-3 py-1">
                            <p style="margin-bottom:0.2rem !important;" class="font-weight-bold">
                                <i class="fa fa-info-circle mr-2"></i> OTHER INFORMATION
                            </p>
                            </div>
                            <div class="row">
                            <div class="col-sm-12 mt-3">
                                <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <h6 class="ml-2 font-weight-bold">Date Of Incorporation :</h6>
                                    </div>
                                    <h6 class="ml-2 text">fe</h6>
                                </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <h6 class="ml-2 font-weight-bold">Address :</h6>
                                    </div>
                                    <h6 class="ml-2 text">few</h6>
                                </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <h6 class="ml-2 font-weight-bold">Country :</h6>
                                    </div>
                                    <h6 class="ml-2 text">wefrer</h6>
                                </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <h6 class="ml-2 font-weight-bold">State :</h6>
                                    </div>
                                    <h6
                                    class="ml-2 text"
                                    v-if="institution.lgas != null"
                                    >wefr</h6>
                                </div>
                                </div>

                            </div>
                            </div> -->
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
                                <p><a href="{{route('team.get-news',['team_slug'=>Route::input('team_slug')])}}" class="btn btn-primary btn-sm mr-3">
                                     All {{$team->team_name}}'s News</a></p>
                            </div>
                        </div> 

                        <div class="card-body">
                            <!-- <div class="row"> -->
                            @if (count($posts)>0)
                            <!-- {{$posts}} -->
                                @foreach ($posts as $post)
                                    <div class="mb-3">
                                        <a href="{{route('news.get.single',['news_slug'=>$post->news->url_slug.'-'.$post->news->id])}}"> 
                                            <h6>{{$post->news->headline}} </h6>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                            <!-- </div> -->
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
            <form action="{{ route('team.edit.image')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{$team->featured_image}}" required>
                <br>
                  <input  type="hidden" name="team_id" id="team-id" class="form-control" value="{{$team->id}}" required>

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


<!-- edit team modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Team</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        @auth
            <form action="{{ route('team.user.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
        @endauth
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
                  <input  type="hidden" name="team_id" id="team-id" class="form-control" value="{{$team->id}}" required>

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
                            // console.log(error.status)
                        }
                        // console.log(error)
                    }
                });
        }
    </script>
@endsection
