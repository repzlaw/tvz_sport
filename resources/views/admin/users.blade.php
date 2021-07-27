@extends('layouts.master')
@section('links')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">


@endsection
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
                        <table id="user_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                <th width="3%">#</th>
                                <th width="7%">username</th>
                                <th width="7%">Fullname</th>
                                <th width="10%">email</th>
                                <th width="10%">user_type</th>
                                <th width="6%">status</th>
                                <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- @foreach ($users as $key =>$user )
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->fname}} {{$user->lname}}</td>
                                        <td>{{$user->user_type}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->status}}</td>
                                        <td class="text-center m-auto">
                                            <span > <i class="fa fa-edit" style="cursor: pointer;"></i> </span>
                                        </td>
                                    </tr>
                                    
                                @endforeach -->
                            </tbody>
                        </table>

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
                
                <!-- <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Page Title</span>
                    </div>
                    <input  type="text" name="page_title" id="page-title" class="form-control" placeholder="Page Title ..." value="{{ old('page_title') }}">
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Meta description</span>
                    </div>
                    <input  type="text" name="meta_description" id="meta-description" class="form-control" placeholder="Meta description ..." value="{{ old('meta_description') }}">
                </div> -->
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

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">User Type</span>
                    </div>
                    <select class="form-control custom-select" name="user_type" required>
                        <option value="">-- select type -- </option> 
                        <option value="user">User </option>                           
                        <option value="editor">Editor </option>                           
                    </select>
                </div>
                <!-- <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <select class="form-control custom-select" name="status"  required>
                        <option value="">-- select status -- </option> 
                        <option value="user">Active </option>                           
                        <option value="banned">Banned </option>                           
                    </select>
                </div> -->

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Password</span>
                    </div>
                    <input  type="password" name="password" class="form-control" placeholder="password" value="{{ old('password') }}" required>
                </div>
                <!-- <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{ old('featured_image') }}" required> -->
                <!-- <br>
                  <textarea name="summary" id="team_summary" rows="5" class="form-control"  placeholder="Team Summary ..." value="{{ old('team_summary') }}" required></textarea>
              </div> -->
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
                
                <!-- <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Page Title</span>
                    </div>
                    <input  type="text" name="page_title" id="page-title" class="form-control" placeholder="Page Title ..." value="{{ old('page_title') }}">
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Meta description</span>
                    </div>
                    <input  type="text" name="meta_description" id="meta-description" class="form-control" placeholder="Meta description ..." value="{{ old('meta_description') }}">
                </div> -->
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
                <!-- <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <select class="form-control custom-select" name="status"  required>
                        <option value="">-- select status -- </option> 
                        <option value="user">Active </option>                           
                        <option value="banned">Banned </option>                           
                    </select>
                </div> -->

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
          <h4 class="modal-title" id="ban_header">Ban/Unban User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.user.status')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <select class="form-control custom-select" name="status" id="status" required>
                        <option value="">-- select status -- </option> 
                        <option value="active">Active </option>                           
                        <option value="banned">Banned </option>                           
                    </select>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Reason</span>
                    </div>
                    <select class="form-control custom-select" name="policy_id">
                        <option value="">-- select reason -- </option> 
                        @foreach($policies as $policy)
                            <option value="{{$policy->id}}">{{$policy->reason}} </option>                           
                        @endforeach                         
                    </select>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Ban Date</span>
                    </div>
                    <input  type="date" name="ban_date" id="ban_date" class="form-control" placeholder="Fullname" value="{{ old('ban_date') }}">
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Banned till</span>
                    </div>
                    <input  type="date" name="ban_till" id="ban_till"  class="form-control" placeholder="email" value="{{ old('ban_till') }}">
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
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" defer></script>
<script>

$(document).ready(function(){
    $('#user_table').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":"{{ route('admin.user.get')}}",
        "columns":[
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'username', name: 'username'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'user_type', name: 'user_type'},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: true, searchable: true},
        ]
    });
    // console.log(345);
});

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

//modal to ban user
function banUser(user){
    $('#ban_header').text("Ban/Unban " + " "+ user.username);
    $('#ban_user_id').val(user.id);
    $('#status').val(user.status);
    $('#ban-modal').modal();

}



</script>
    
@endsection