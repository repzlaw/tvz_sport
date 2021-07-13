@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
                <div class="row">
                    <div class="col-7">
                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                Today's News
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                    @foreach ($latestnews as $news )
                                    <p> 
                                    <a href="{{route('news.get.single',['id'=>$news->id, 'news_slug'=>$news->url_slug])}}"> 
                                        <h6>{{$news->headline}} 
                                        <small> - by {{$news->user->username}} </small>
                                        </h6>
                                    </a>
                                    </p>
                                    @endforeach
                                    
                                </div>
                                
                            </div>
                        </div>

                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                Previous News
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                <!-- {{$previousnews}} -->
                                    @foreach ($previousnews as $news )
                                        <p> 
                                        <a href="{{route('news.get.single',['id'=>$news->id, 'news_slug'=>$news->url_slug])}}"> 
                                            <h6>{{$news->headline}} 
                                            <small> - by {{$news->user->username}} </small>
                                            </h6>
                                        </a>
                                        </p>
                                    @endforeach
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-5 mt-5">
                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                Today's events
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                <!-- {{$upcomingevents}} -->
                                    @foreach ($upcomingevents as $event )
                                        <a href="#"> 
                                            <div>
                                            <small>
                                             {{$event->match_time}} 
                                            </small>
                                           <h4>
                                           {{$event->homeTeam->team_name}} vs {{$event->awayTeam->team_name}} 
                                           </h4> 
                                           <h5>
                                                {{$event->home_team_score}}  {{$event->away_team_score}}
                                           </h5>  
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>

                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                Previous events
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                    @foreach ($previousevents as $event )
                                        <a href="#"> 
                                            <div>
                                            <small>
                                             {{$event->match_time}} 
                                            </small>
                                           <h4>
                                           {{$event->homeTeam->team_name}} vs {{$event->awayTeam->team_name}} 
                                           </h4> 
                                           <h5>
                                                {{$event->home_team_score}}  {{$event->away_team_score}}
                                           </h5>  
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <!-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
