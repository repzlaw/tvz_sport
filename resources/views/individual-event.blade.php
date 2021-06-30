@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                {{$event->competition_name}}
                            </div>
                            @guest
                                <!-- <div class="btn-actions-pane-right text-right">
                                        <p><a href="/event/followers/{{$event->id}}" class="btn btn-primary btn-sm"  id="follow">Follow</a></p>
                                </div> -->
                            @else
                                <div class="btn-actions-pane-right text-right">
                                    @if(Auth::user()->isFollowingCompetition(Auth::user()->id, $event->id))
                                        <p><a href="#" class="btn btn-primary btn-sm" onclick="follow({{$event->id}})" id="follow">Unfollow</a></p>
                                    @else
                                        <p><a href="#" class="btn btn-primary btn-sm" onclick="follow({{$event->id}})" id="follow">Follow</a></p>
                                    @endif
                                </div>

                            @endguest
                        </div> 
                        <div class="card-body">
                            <div class="row first">
                                <div class="col-4">
                                <p>Date: 16/06/21 - 22/06/21
                                

                                </p>
                                </div>
                                <div class="col-sm-4">
                                    <p><strong>Location:  <a href="#" > Europe</a></strong></p>
                                </div>
                                <div class="col-sm-4">
                                    <p><strong> Number of Teams:10 </strong></p>
                                </div>
                                <!-- teams -->
                                <div class="row ml-3">
                                    <div class="col-sm-12 mt-2">
                                        <p><Strong>Teams</Strong></p>
                                    </div>
                                    <div class="col-3">
                                        <p> Team 1</p>
                                    </div>
                                    <div class="col-3">
                                        <p>Team 2</p>
                                    </div>
                                    <div class="col-3">
                                        <p>Team 3</p>
                                    </div>
                                    <div class="col-3"> 
                                        <p>Team 4</p>
                                    </div>
                                </div>
                                <!-- matches -->
                                <!-- <div class="row ml-3"> -->
                                    <div class="col-12">
                                        <p><Strong>Matches</Strong></p>
                                    </div>
                                    <div class="col-12">
                                        <p><Strong>16th July 2021</Strong></p>
                                    </div>
                                    <div class="col-sm-12">
                                        <p>
                                            <a href="/poland-vs-belguim-1" >Poland vs Belguim, 16th jun 2021</a>
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p>Team 1 vs Team 5, 16th jun 2021</p>
                                    </div>
                                <!-- </div> -->
                            </div>
                            
                        </div>
                    </div>

                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            Event Synoposis
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="row ml-5">
                                <div class="col-sm-12  my-5">
                                    <p class=" ml-5"><Strong>HTML Editable Box for Editor/Admin</Strong></p>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            Event News
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="mb-5">
                                <h6>France in Finals</h6>
                            </div>

                            <div class="mb-5">
                                <h6>Germany crashes out</h6>
                            </div>
                            
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function follow(userId){
            var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: '{{ url('event/follow')}}'+'/'+userId,
                    type: 'GET',
                    success: function (response)
                    {
                        if(response==true){
                            $("#follow").text("Unfollow")
                        }
                        if(response==false){
                            $("#follow").text("Follow")
                        }
                    },
                    error: function (error){
                        console.log(error)
                    }
                });
        }
    </script>
@endsection
