@extends('layouts.app')

@section('title', $user->username)
@section('meta_description', $user->username)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            {{-- <div class="row"> --}}
                <div class="col-12 col-md-8">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                @if ($user->id === Auth::id())
                                    My Profile 
                                @else
                                    {{$user->display_name? $user->display_name : $user->username}}'s profile
                                @endif
                                
                            </div>
                            <div class="btn-actions-pane-right float-right">
                                    @if ($user->id === Auth::id())
                                        <a href="#" class="btn btn-outline-warning btn-sm mr-3" id="edit-button" onclick='editUser({{$user}})'> Edit Profile</a>
                                        <a href="/v1/comments/individual?cat=news" class="btn btn-outline-success btn-sm mr-3"> Activity</a>
                                    @else
                                        @if(Auth::user()->isFollowingUser(Auth::user()->id, $user->id))
                                            <p><a href="#" class="btn btn-outline-primary btn-sm" onclick="follow({{$user->id}})" id="follow">Unfriend ☹️</a></p>
                                        @else
                                            <p><a href="#" class="btn btn-outline-primary btn-sm" onclick="follow({{$user->id}})" id="follow">Make friend 😊</a></p>
                                        @endif
                                    @endif
                                </div>
                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    {{-- src="/storage/images/profile/{{$user->featured_image}}" --}}
                                    @if ($user->picture)
                                        <img
                                            src="/storage/images/profile/{{$user->picture->file_path}}"
                                            alt="{{$user->username}}"
                                            style="height: 150px; width:150px; border: 4px solid #eee; border-radius: 15px;"/>
                                        
                                    @else
                                        <img
                                            src="/storage/images/profile/no_image.png"
                                            alt="{{$user->username}}"
                                            style="height: 150px; width:150px; border: 4px solid #eee; border-radius: 15px;"/>
                                    @endif
                                    @auth
                                        @if ($user->id === Auth::id())
                                            <div class="btn-actions-pane-right mt-3">
                                                <p><a href="#" class="btn btn-outline-info btn-sm mr-3"  id="edit-image-button">Edit Image</a></p>
                                            </div>
                                        @endif
                                    @endauth
                                </div>

                                <div class="col-sm-8">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Display name :</h6>
                                            </div>
                                                <h6 class="ml-2 text">{{$user->display_name}}</h6>
                                            </div>
                                        </div>
                                        @if ($user->id === Auth::id())
                                            <div class="col-md-12 mb-2">
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <h6 class="ml-1 font-weight-bold">Username :</h6>
                                                </div>
                                                    <h6 class="ml-2 text">{{$user->username}}</h6>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-2">
                                                <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <h6 class="ml-1 font-weight-bold">Email :</h6>
                                                </div>
                                                <h6 class="ml-2 text">{{$user->email}}</h6>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Fullname :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$user->name}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Friends :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$user->friends_count}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            
                                            <h6 class="ml-2 text badge badge-pill badge-success badge-success">{{$user->status}}</h6>
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>

            {{-- </div> --}}

        </div>
    </div>
</div>

<!-- edit user image modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-image">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change Profile Picture</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('profile.edit.image')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{$user->featured_image}}" required>
                <br>
                  <input  type="hidden" name="user_id" class="form-control" value="{{$user->id}}" required>
                  <input  type="hidden" name="username" class="form-control" value="{{$user->username}}" required>
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
  <!-- edit user modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Profile</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('profile.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                  
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Display name</span>
                    </div>
                    <input  type="text" name="display_name" id="display_name" class="form-control" placeholder="display name" value="{{ old('display_name') }}" required>
                </div>
                
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Username</span>
                    </div>
                    <input  type="text" name="username" id="username" class="form-control" placeholder="username" value="{{ old('username') }}" required>
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Name</span>
                    </div>
                    <input  type="text" name="name" id="name" class="form-control" placeholder="Fullname" value="{{ old('name') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Email</span>
                    </div>
                    <input  type="email" name="email" id="email"  class="form-control" placeholder="email" value="{{ old('email') }}" required>
                </div>


                <input  type="hidden" name="user_id" id="user_id" class="form-control">

                <!-- <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{ old('featured_image') }}" required> -->
                <!-- <br>
                  <textarea name="summary" id="team_summary" rows="5" class="form-control"  placeholder="Team Summary ..." value="{{ old('team_summary') }}" required></textarea>
              </div> -->
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-edit-save">Save changes</button>
              </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>

@endsection

@section('scripts')
<script>
//modal to edit user
function editUser(user){
    $('#username').val(user.username);
    $('#name').val(user.name);
    $('#email').val(user.email);
    $('#user_id').val(user.id);
    $('#display_name').val(user.display_name);
    $('#edit-modal').modal();
}

//edit image
$('#edit-image-button').on('click',function(event){
    event.preventDefault();
    $('#edit-image').modal();
});

function follow(userId){
    var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: '{{ url('/user/profile/follow')}}'+'/'+userId,
            type: 'GET',
            success: function (response)
            {
                if(response==true){
                    $("#follow").text("Unfriend ☹️");
                }
                if(response==false){
                    $("#follow").text("Make Friend 😊");
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
@endsection
