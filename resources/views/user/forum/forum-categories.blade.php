@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-8 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                          <h5>
                            <i class="fab fa-forumbee  mr-2"></i>
                            Forums
                          </h5> 
                        </div>
                    </div> 
                    <ul class="list-group list-group-flush">
                        @forelse ($categories as $category)
                          <li class="list-group-item">
                            <a href="{{route('forum.get.single',['forum_slug'=>$category->url_slug.'-'.$category->id])}}" 
                              style="text-decoration: none;">
                                  {{$category->name}} 
                                  <span class="float-right" > {{$category->created_at}}</span>
                                  {{-- <i class="fa fa-angle-right text-info fa-lg float-right" id="edit-button" >~ {{$category->created_at}}</i> --}}
                            </a>
                          </li>
                        @empty
                          <div class="alert alert-info text-center">
                            <b>No Forum found</b>
                          </div>
                        @endforelse  
                    </ul>
                    
                </div>

            </div>

        </div>

    </div>
    </div>
</div>

@endsection
