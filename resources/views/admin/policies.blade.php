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
                        @foreach ($policies as $policy)
                        <li class="list-group-item">
                                {{$policy->reason}}
                                <!-- <i class="fa fa-angle-right fa-lg float-right"></i> -->
                        </li>
                        @endforeach 
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
                
                  <textarea name="reason" id="reason" rows="5" class="form-control"  placeholder="Write policy here ..." value="{{ old('reason') }}" required></textarea>
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
  <!-- /.modal -->
@endsection

@section('scripts')
<script>
//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal();
});

</script>
    
@endsection