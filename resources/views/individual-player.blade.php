@extends('layouts.app')

@section('title', $player->page_title)
@section('meta_description', $player->meta_description)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-8 m-auto">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                Player Information
                            </div>
                                @auth
                                <div class="btn-actions-pane-right float-right">
                                    @if(Auth::user()->isFollowingPlayer(Auth::user()->id, $player->id))
                                        <p><a href="#" class="btn btn-primary btn-sm" onclick="follow({{$player->id}})" id="follow">Unfollow</a></p>
                                    @else
                                        <p><a href="#" class="btn btn-primary btn-sm" onclick="follow({{$player->id}})" id="follow">Follow</a></p>
                                    @endif
                                </div>

                            @endauth
                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <!-- {{$player}} -->
                                <div class="col-sm-3">
                                    <img
                                        src="/storage/images/player_images/{{$player->featured_image}}"
                                        alt="Avatar 5"
                                        style="height: 150px; width:150px; border: 4px solid #eee; border-radius: 15px;"
                                    />
                                </div>

                                <div class="col-sm-8">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Player name :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->name}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Fullname :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->full_name}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Sport :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->sportType->sport_type}}</h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Team :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->Team->team_name}}</h6>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <h6 class="ml-1 font-weight-bold">Active since :</h6>
                                            </div>
                                            <h6 class="ml-2 text">{{$player->active_since}}</h6>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-12 mb-2">
                                            <div class="ml-1 badge badge-pill badge-success badge-success">{{$player->status}}</div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid bg-success text-white mt-3 px-3 py-1">
                            <p style="margin-bottom:0.2rem !important;" class="font-weight-bold">
                                <i class="fa fa-info-circle mr-2"></i> OTHER INFORMATION
                            </p>
                            </div>
                            <div class="row">
                            <div class="col-sm-12 mt-3">
                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Status :</h6>
                                        </div>
                                        <h6 class="ml-2 text badge badge-pill badge-success badge-success">{{$player->status}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Date Of Birth :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$player->birth_date}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Country :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$player->country}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Total Earnings :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$player->total_earnings}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <h6 class="ml-2 font-weight-bold">Role :</h6>
                                        </div>
                                        <h6 class="ml-2 text">{{$player->role}}</h6>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <h6 class="ml-2 font-weight-bold">Followers :</h6>
                                    </div>
                                    <h6 class="ml-2 text">{{$player->followers}}</h6>
                                </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <h6 class="ml-2 font-weight-bold">Signature Hero :</h6>
                                        </div>
                                        <h6
                                        class="ml-2 text"
                                        v-if="institution.lgas != null"
                                        >{{$player->signature_hero}}</h6>
                                    </div>
                                </div>

                            </div>
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
                    url: '{{ url('players/follow')}}'+'/'+userId,
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
