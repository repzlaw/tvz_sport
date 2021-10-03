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
                            <h5>Forum Categories</h5> 
                        </div>
                        <div class="float-right">
                            <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create Forum Categories</a></p>
                        </div>
                    </div> 
                    <ul class="list-group list-group-flush">
                        @forelse ($categories as $category)
                          <li class="list-group-item">
                                  {{$category->name}}
                                  <i class="fa fa-edit text-info fa-lg float-right" id="edit-button" onclick="edit({{$category}})"></i>
                          </li>
                        @empty
                          <div class="alert alert-info text-center">
                            <b>No categories found</b>
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
          <h4 class="modal-title">Create category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.forum-category.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="input-group mb-4" >
                <div class="input-group-prepend">
                    <span class="input-group-text">Page Title</span>
                </div>
                <input  type="text" name="page_title" class="form-control" placeholder="Page Title ...">
              </div>
              <div class="input-group mb-4" >
                  <div class="input-group-prepend">
                      <span class="input-group-text">Meta description</span>
                  </div>
                  <input  type="text" name="meta_description"  class="form-control" placeholder="Meta description ...">
              </div>
              <div class="form-group">
                <textarea name="name" rows="5" class="form-control"  placeholder="Write category here ..." value="{{ old('name') }}" required></textarea>
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

<!-- edit team modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.forum-category.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="input-group mb-4" >
                <div class="input-group-prepend">
                    <span class="input-group-text">Page Title</span>
                </div>
                <input  type="text" name="page_title" id="page_title" class="form-control" placeholder="Page Title ...">
              </div>
              <div class="input-group mb-4" >
                  <div class="input-group-prepend">
                      <span class="input-group-text">Meta description</span>
                  </div>
                  <input  type="text" name="meta_description" id="meta_description" class="form-control" placeholder="Meta description ...">
              </div>
              <div class="form-group">
                  <textarea name="name" id="name" rows="5" class="form-control"  placeholder="Write category here ..." value="{{ old('name') }}" required></textarea>
                <input  type="hidden" name="category_id" id="category_id" class="form-control">
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
@endsection

@section('scripts')
<script>
//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal();
});

//modal to edit category
function edit(category){
    // console.log(category);
    $('#name').val(category.name);
    $('#meta_description').val(category.meta_description);
    $('#page_title').val(category.page_title);
    $('#category_id').val(category.id);
    $('#edit-modal').modal();
}

</script>
    
@endsection