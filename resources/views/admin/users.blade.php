@extends('layouts.master')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Users</h5> 
                        </div>
                        <div class=" float-right">
                            <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create User</a></p>
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="col-12 mb-2">
                            <form action="{{ route('admin.user.search')}}" method="get">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Search by</span>
                                            </div>
                                            <select class="form-control custom-select" name="search_column" id="search_column" required>
                                                <option value="">-- select column -- </option> 
                                                <option value="id">id </option>                           
                                                <option value="username">username </option>                           
                                                <option value="email">email </option>                           
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4" id="search_div">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="query" name="query" placeholder="Search..." aria-label="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (count($users))
                            <table id="user_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                    <th width="3%">user ID</th>
                                    <th width="7%">username</th>
                                    <th width="7%">fullname</th>
                                    <th width="10%">email</th>
                                    <th width="6%">status</th>
                                    <th width="5%">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key =>$user )
                                        <tr>
                                            <td class="text-center">
                                                <a href="{{route('admin.user.profile',['id'=>$user->id])}}" title="view profile">
                                                    {{$user->id}}
                                                </a>    
                                            </td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                @if ($user->status === 'active')
                                                    <div class="ml-1 badge badge-pill badge-success"> {{$user->status}}</div></td>
                                                    
                                                @else
                                                    <div class="ml-1 badge badge-danger badge-info"> {{$user->status}}</div></td>
                                                    
                                                @endif
                                            <td class="text-center m-auto">
                                                <i class='fa fa-edit text-success mr-3' style='cursor: pointer;' onclick='editUser({{$user}})'></i> 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                            
                        @else
                            <div class="alert alert-info text-center">
                                <b>No users found</b>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- create user modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.user.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Username</span>
                    </div>
                    <input  type="text" name="username" class="form-control" placeholder="username" value="{{ old('username') }}" required>
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Name</span>
                    </div>
                    <input  type="text" name="name"class="form-control" placeholder="Fullname" value="{{ old('name') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Email</span>
                    </div>
                    <input  type="email" name="email" class="form-control" placeholder="email" value="{{ old('email') }}" required>
                </div>

                <!-- <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">User Type</span>
                    </div>
                    <select class="form-control custom-select" name="user_type" required>
                        <option value="">-- select type -- </option> 
                        <option value="user">User </option>                           
                        <option value="editor">Editor </option>                           
                    </select>
                </div> -->
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Password</span>
                    </div>
                    <input  type="password" name="password" class="form-control" placeholder="password" value="{{ old('password') }}" required>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-save">Save changes</button>
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

@endsection

@section('scripts')
<script>
//hide/show search based on select dropdown
$("#search_column").change(function() {
  if ($(this).val() !== "") {
    $('#search_div').show();
    $('#query').attr('required', '');
    $('#query').attr('data-error', 'This field is required.');
  } else {
    $('#search_div').hide();
    $('#query').removeAttr('required');
    $('#query').removeAttr('data-error');
  }
});
$("#search_column").trigger("change");

//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal();
});

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

</script>
    
@endsection