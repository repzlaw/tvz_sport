@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-6 m-auto">
                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                    <h5>Sports</h5> 
                                </div>
                                <div class=" float-right">
                                        <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create Sport</a></p>
                                </div>
                            </div> 
                            <ul class="list-group list-group-flush">
                                @foreach ($sports as $sport)
                                <li class="list-group-item">
                                        {{$sport->sport_type}}
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
          <h4 class="modal-title">Create Sport</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.sport.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">
                
                <div class="input-group mb-4" >
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
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sport Name</span>
                    </div>
                    <input  type="text" name="sport_type" id="sport-name" class="form-control" placeholder="Sport Name" value="{{ old('sport_name') }}" required>
                </div>
                <!-- <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{ old('featured_image') }}" required> -->
                <!-- <br>
                  <textarea name="summary" id="team_summary" rows="5" class="form-control"  placeholder="Team Summary ..." value="{{ old('team_summary') }}" required></textarea>
              </div> -->
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id = "modal-save">Save changes</button>
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