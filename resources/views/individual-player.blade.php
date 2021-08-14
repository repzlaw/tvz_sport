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

                                <div class="btn-actions-pane-right float-right">

                                    <p><a href="#" class="btn btn-warning btn-sm mr-3"  id="edit-button">Edit Player</a></p>
                                    <!-- @if(Auth::user()->user_type === 'editor') -->
                                    <!-- @endif -->
                                </div>

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
                <button type="submit" class="btn btn-primary" id = "modal-save">Save changes</button>
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
                    <select class="form-control custom-select" name="team_id" id="sport-type" required >
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
                <input  type="hidden" name="player_id" id="player-id" class="form-control" value="{{$player->id}}" required>

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
                            // console.log(error.status)
                        }
                    }
                });
        }
    </script>
@endsection
