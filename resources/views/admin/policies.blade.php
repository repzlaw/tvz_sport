@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-8 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Policies</h5> 
                        </div>
                        <div class="float-right">
                            <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create Policies</a></p>
                        </div>
                    </div> 
                    <ul class="list-group list-group-flush">
                        @forelse ($policies as $policy)
                        <li class="list-group-item">
                                {{$policy->reason}}
                                <h6 class="ml-4 text badge badge-pill badge-success badge-success">{{$policy->type}}</h6>

                                <i class="fa fa-edit text-info fa-lg float-right" id="edit-button" onclick="edit({{$policy}})"></i>
                        </li>
                        @empty
                          <div class="alert alert-info text-center">
                            <b>No policies found</b>
                          </div>
                        @endforelse
                    </ul>
                    
                </div>

            </div>

        </div>

    </div>
    </div>
</div>

<!-- create team modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create policy</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.ban-policy.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                <div class="input-group mb-4" >
                  <div class="input-group-prepend">
                      <span class="input-group-text">Type</span>
                  </div>
                  <select class="form-control custom-select" name="type" required >
                      {{-- <option value="">-- Select Policies -- </option>  --}}
                      <option value="ban">Ban </option> 
                      <option value="comment">Comment </option> 
                      <option value="thread">Thread </option> 
                      <option value="post">Post </option> 
                                              
                  </select>
              </div>
                  <textarea name="reason" rows="5" class="form-control"  placeholder="Write policy here ..." value="{{ old('reason') }}" required></textarea>
                <!-- <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{ old('featured_image') }}" required> -->
                <!-- <br>
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

<!-- edit team modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit policy</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.ban-policy.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                <div class="input-group mb-4" >
                  <div class="input-group-prepend">
                      <span class="input-group-text">Type</span>
                  </div>
                  <select class="form-control custom-select" name="type" id="ban_type" required >
                      {{-- <option value="">-- Select Policies -- </option>  --}}
                      <option value="ban">Ban </option> 
                      <option value="comment">Comment </option> 
                      <option value="thread">Thread </option> 
                      <option value="post">Post </option> 
                  </select>
              </div>
              <textarea name="reason" id="reason" rows="5" class="form-control"  placeholder="Write policy here ..." value="{{ old('reason') }}" required></textarea>

              <input  type="hidden" name="policy_id" id="policy_id" class="form-control">

                <!-- <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{ old('featured_image') }}" required> -->
                <!-- <br>
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
@endsection

@section('scripts')
<script>
//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal();
});

//modal to edit policy
function edit(policy){
    // console.log(policy);
    $('#reason').val(policy.reason);
    $('#policy_id').val(policy.id);
    $('#ban_type').val(policy.type);
    $('#edit-modal').modal();
}

</script>
    
@endsection