@extends('layouts.master')

@section('title', $user->username)
@section('meta_description', $user->username)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                User Information
                            </div>
                                <div class="btn-actions-pane-right float-right">
                                    @if($user->status === 'active')
                                        <a href='javascript:void(0)' class='delete btn btn-outline-danger btn-sm' onclick='banUser({{$user}})'>Ban</a>
                                    @else
                                        <a href='javascript:void(0)' class='delete btn btn-outline-success btn-sm' onclick='unbanUser({{$user}})'>Unban</a>
                                    @endif
                                </div>

                                <div class="btn-actions-pane-right float-right">
                                    <a href="{{route('admin.user.log',['id'=>$user->id])}}" class="btn btn-outline-info btn-sm mr-3" id="edit-button"> logs</a>
                                </div>
                                <div class="btn-actions-pane-right float-right">
                                    <a href="#" class="btn btn-outline-warning btn-sm mr-3" id="edit-button" onclick='editUser({{$user}})'> Edit User</a>
                                </div>

                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <!-- <div class="col-sm-3">
                                    <img
                                        src="/storage/images/user_images/{{$user->featured_image}}"
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
                                </div> -->

                                <div class="col-sm-8">
                                    <div class="col-sm-12">
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

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Fullname :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$user->name}}</h6>
                                            </div>
                                        </div>

                                        
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
                                            <h6 class="ml-1 font-weight-bold">User type :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$user->user_type}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <h6 class="ml-1 font-weight-bold">Status :</h6>
                                    </div>
                                    <h6 class="ml-2 text">
                                        @if ($user->status === 'active')
                                            <div class="ml-1 badge badge-pill badge-success badge-success">{{$user->status}}</div>
                                        @else
                                            <div class="ml-1 badge badge-pill badge-danger badge-danger">{{$user->status}}</div>
                                        @endif
                                    </h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <h6 class="ml-2 font-weight-bold">Last Login Date and Time :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$user->last_login_at}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Last Login IP :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$user->last_login_ip}}</h6>
                                    </div>
                                </div>

                            </div>
                            </div>
                        </div>
                        
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

  <!-- edit user modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.user.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
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

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">User Type</span>
                    </div>
                    <select class="form-control custom-select" name="user_type" id="user_type" required>
                        <option value="">-- select type -- </option> 
                        <option value="user">User </option>                           
                        <option value="editor">Editor </option>                           
                    </select>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Password</span>
                    </div>
                    <input  type="password" name="password" id="password" class="form-control" placeholder="password" value="{{ old('password') }}" >
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

  <!-- ban user modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id= "ban-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="ban_header">Ban User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.user.ban-user',['id'=>$user->id])}}" method="get" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Reason</span>
                    </div>
                    <select class="form-control custom-select" name="policy_id" required>
                        <option value="">-- select reason -- </option> 
                        @foreach($policies as $policy)
                            <option value="{{$policy->id}}">{{$policy->reason}} </option>                           
                        @endforeach                         
                    </select>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Banned till</span>
                    </div>
                    <input  type="date" name="ban_till" id="ban_till"  class="form-control" placeholder="email" min value="{{ old('ban_till') }}">
                </div> 
                
                <input  type="hidden" name="user_id" id="ban_user_id" class="form-control">

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-ban-save">Save changes</button>
              </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  </div>
  <!-- /.modal -->

  <!-- unban user modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id= "unban-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="unban_header">unban User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.user.unban-user',['id'=>$user->id])}}" method="get" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                <textarea name="reason" id="reason" rows="5" class="form-control"  placeholder="Reason for unsuspension ..." value="{{ old('reason') }}" required></textarea>
                <input  type="hidden" name="user_id" id="unban_user_id" class="form-control">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-unban-save">Save changes</button>
              </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  </div>
  <!-- /.modal -->
@endsection

@section('scripts')
<script>
//set today to minimum date allowed for ban till
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
var yyyy = today.getFullYear();
if(dd<10){
  dd='0'+dd
} 
if(mm<10){
  mm='0'+mm
} 

today = yyyy+'-'+mm+'-'+dd;
document.getElementById("ban_till").setAttribute("min", today);

//modal to edit user
function editUser(user){
    $('#username').val(user.username);
    $('#name').val(user.name);
    $('#user_type').val(user.user_type);
    $('#email').val(user.email);
    $('#user_id').val(user.id);
    $('#password').val(user.password);
    $('#edit-modal').modal();
}

//modal to ban user
function banUser(user){
    $('#ban_header').text("Ban " + " "+ user.username);
    $('#ban_user_id').val(user.id);
    // $('#status').val(user.status);
    $('#ban-modal').modal();
}

//modal to unban user
function unbanUser(user){
    $('#unban_header').text("Unban " + " "+ user.username);
    $('#unban_user_id').val(user.id);
    // $('#status').val(user.status);
    $('#unban-modal').modal();
}
</script>
@endsection
