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
                            <h5>editors</h5> 
                        </div>
                        <div class=" float-right">
                            <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create editor</a></p>
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="col-12 mb-2">
                            <form action="{{ route('admin.editor.search')}}" method="get">
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
                        @if (count($editors))
                        <p>page {{ $editors->currentPage() }} of {{ $editors->lastPage() }} , displaying {{ count($editors) }} of {{ $editors->total() }} record(s) </p>

                            <table id="editor_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                    <th width="3%">editor ID</th>
                                    <th width="7%">username</th>
                                    <th width="7%">fullname</th>
                                    <th width="10%">email</th>
                                    <th width="10%">role</th>
                                    <th width="6%">status</th>
                                    <th width="5%">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($editors as $key =>$editor)
                                        <tr>
                                            <td class="text-center">
                                                <!-- <a href="{{route('admin.editor.profile',['id'=>$editor->id])}}" title="view profile"> -->
                                                    {{$editor->id}}
                                                <!-- </a>     -->
                                            </td>
                                            <td>{{$editor->username}}</td>
                                            <td>{{$editor->name}}</td>
                                            <td>{{$editor->email}}</td>
                                            <td>{{$editor->role->role}}</td>
                                            <td>
                                                @if ($editor->status === 'active')
                                                    <div class="ml-1 badge badge-pill badge-success"> {{$editor->status}}</div></td>
                                                    
                                                @else
                                                    <div class="ml-1 badge badge-danger badge-info"> {{$editor->status}}</div></td>
                                                    
                                                @endif
                                            <td class="text-center m-auto">
                                                <i class='fa fa-edit text-success mr-3' style='cursor: pointer;' onclick='editeditor({{$editor}})'></i> 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $editors->links() }}
                            
                        @else
                            <div class="alert alert-info text-center">
                                <b>No editors found</b>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- create editor modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create editor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.editor.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> username</span>
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
                        <span class="input-group-text">role</span>
                    </div>
                    <select class="form-control custom-select" name="editor_type" required>
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->role}}</option> 
                        @endforeach
                    </select>
                </div>
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

  <!-- edit editor modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit editor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.editor.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> username</span>
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
                        <span class="input-group-text">role</span>
                    </div>
                    <select class="form-control custom-select" name="editor_type" required>
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->role}}</option> 
                        @endforeach
                    </select>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Password</span>
                    </div>
                    <input  type="password" name="password" id="password" class="form-control" placeholder="password" value="{{ old('password') }}" >
                </div>

                <input  type="hidden" name="editor_id" id="editor_id" class="form-control">

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
    if ($(this).val() == "id") {
        $('#query').attr('type', 'number'); 
    }else if($(this).val() == "username"){
        $('#query').attr('type', 'text'); 
    }else if($(this).val() == "email"){
        $('#query').attr('type', 'email'); 
    }
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

//modal to edit editor
function editeditor(editor){
    $('#username').val(editor.username);
    $('#name').val(editor.name);
    $('#editor_type').val(editor.editor_type);
    $('#email').val(editor.email);
    $('#editor_id').val(editor.id);
    $('#password').val(editor.password);
    $('#edit-modal').modal();
}

</script>
    
@endsection