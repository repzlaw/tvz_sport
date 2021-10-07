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
                        {{-- <div class=" float-right">
                          @auth()
                            @if (Auth::user()->member_type_id !== 1)
                              <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create Thread</a></p>
                            @endif
                          @else
                            <a href="/login" class="text-danger">Login to create threads</a>
                          @endauth
                      </div> --}}
                    </div> 
                    <ul class="list-group list-group-flush">
                        @forelse ($threads as $thread)
                          <li class="list-group-item">
                            <a href="{{route('admin.forum.thread.get.single',['thread_slug'=>$thread->url_slug.'-'.$thread->id])}}" 
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

@endsection

@section('scripts')
<script>

</script>
    
@endsection