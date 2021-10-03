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
                          <h5>{{$category->name}} Threads</h5> 
                        </div>
                        <div class=" float-right">
                          @auth()
                            @if (Auth::user()->member_type_id !== 1)
                              <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create Thread</a></p>
                            @endif
                          @else
                            <a href="/login" class="text-danger">Login to create threads</a>
                          @endauth
                      </div>
                    </div> 
                    <ul class="list-group list-group-flush">
                        @forelse ($threads as $thread)
                          <li class="list-group-item">
                            <a href="{{route('forum.thread.get.single',['thread_slug'=>$thread->url_slug.'-'.$thread->id])}}" 
                              style="text-decoration: none;">
                                  {{$thread->title}} 
                                  <span class="float-right"> {{$thread->created_at}}</span>
                                  {{-- <i class="fa fa-angle-right text-info fa-lg float-right" id="edit-button" >~ {{$category->created_at}}</i> --}}
                            </a>
                          </li>
                        @empty
                          <div class="alert alert-info text-center">
                            <b>No Thread found</b>
                          </div>
                        @endforelse  
                    </ul>
                    {{ $threads->links() }}
                    
                </div>

            </div>

        </div>

    </div>
    </div>
</div>

<!-- create thread modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create Thread</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <form action="{{ route('forum.thread.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  @honeypot
            <div class="form-group">
              
              <div class="input-group mb-4" >
                  <div class="input-group-prepend">
                      <span class="input-group-text">Thread Title</span>
                  </div>
                  <input  type="text" name="title" id="title" class="form-control" placeholder="Thread Title ..." value="{{ old('title') }}">
              </div>
              <textarea name="body" id="team_summary" rows="5" class="form-control"  placeholder="Topic ..." value="{{ old('body') }}" required></textarea>
              <input type="hidden" name="forum_category_id" id="forum_category_id" value="{{ $category->id }}" required>
              <input type="hidden" name="recaptcha" id="recaptcha">
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
<script src="https://www.google.com/recaptcha/api.js?render={{ $captcha_site_key_v3 }}"></script>
<script>
         grecaptcha.ready(function() {
             grecaptcha.execute("{{ $captcha_site_key_v3 }}", {action: 'forum'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
</script>
<script>
//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal();
});

</script>
    
@endsection