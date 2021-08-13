@extends('layouts.app')

@section('title', $news->page_title)
@section('meta_description', $news->meta_description)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-body">
                            <!-- <div class="row first"> -->
                                <div class="col-12 mb-4">
                                    <h3 style="font-weight: bold;">{{$news->headline}}</h3>
                                    <small>by {{$news->user->username}} </small>
                                    <small class="ml-3">{{date('d/m/Y', strtotime($news->updated_at))}}</small>
                                    <small class="ml-3">{{date('H:i', strtotime($news->updated_at))}}</small>
                                </div>
                                <!-- matches -->
                                <div class="row ml-3">
                                    <p>{!! html_entity_decode($news->content) !!}</p>
                                </div>
                            <!-- </div> -->
                            
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>
</div>
@endsection
