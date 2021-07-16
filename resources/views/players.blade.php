@extends('layouts.app')

@section('links')
<!-- <link rel="stylesheet" href="//cdn.tutorialjinni.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="//cdn.tutorialjinni.com/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://mojoaxel.github.io/bootstrap-select-country/dist/css/bootstrap-select-country.min.css" /> -->
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-6 m-auto">
                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                    <h5>Players</h5> 
                <!-- <select class="selectpicker countrypicker" data-flag="true"></select> -->

                                </div>
                                @auth
                                <div class=" float-right">
                                    @if(Auth::user()->user_type === 'editor')
                                        <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Add Player</a></p>
                                    @endif
                                </div>
                                @endauth
                            </div> 
                            <ul class="list-group list-group-flush">
                                @foreach ($players as $player)
                                <li class="list-group-item">
                                    <a href="{{route('player.get.single',['player_slug'=>$player->url_slug.'-'.$player->id])}}" 
                                        style="text-decoration: none;">
                                            {{$player->full_name}}
                                        <i class="fa fa-angle-right fa-lg float-right"></i>
                                    </a>
                                </li>
                                @endforeach 
                            </ul>
                            
                        </div>

                    </div>

                </div>

            </div>
    </div>
</div>

<!-- create player modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create Player</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('player.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group row">
                
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Page Title</span>
                    </div>
                    <input  type="text" name="page_title" id="page-title" class="form-control" placeholder="Page Title ..." value="{{ old('page_title') }}">
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Meta description</span>
                    </div>
                    <input  type="text" name="meta_description" id="meta-description" class="form-control" placeholder="Meta description ..." value="{{ old('meta_description') }}">
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sport Type</span>
                    </div>
                    <select class="form-control custom-select" name="sport_type_id" id="sport-type" required >
                        <option value="">-- All Sports -- </option> 
                        @foreach ($sports as $sport)
                            <option value="{{$sport->id}}">{{$sport->sport_type}} </option>                           
                        @endforeach                          
                    </select>
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Team</span>
                    </div>
                    <select class="form-control custom-select" name="team_id" id="sport-type" required >
                        <option value="">-- All Teams -- </option> 
                        @foreach ($teams as $team)
                            <option value="{{$team->id}}">{{$team->team_name}}</option>                           
                        @endforeach                          
                    </select>
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Player Name</span>
                    </div>
                    <input  type="text" name="name" id="player-name" class="form-control" placeholder="Player Name" value="{{ old('name') }}" required>
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Player Full Name</span>
                    </div>
                    <input  type="text" name="full_name" id="full_name" class="form-control" placeholder="Player Full Name" value="{{ old('full_name') }}" required>
                </div>
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Country</span>
                    </div>
                    <input  type="text" name="country" id="country" class="form-control" placeholder="country" value="{{ old('country') }}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Player Image ..." value="{{ old('featured_image') }}" required>
                </div>
                
                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Birth Date</span>
                    </div>
                    <input  type="date" name="birth_date" id="birth_date" class="form-control" placeholder="active since" value="{{ old('birth_date') }}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Active Since</span>
                    </div>
                    <input  type="date" name="active_since" id="active_since" class="form-control" placeholder="active since" value="{{ old('active_since') }}" required>
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <input  type="text" name="status" id="full_name" class="form-control" placeholder="Status" value="{{ old('status') }}" required>
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Role</span>
                    </div>
                    <input  type="text" name="role" id="role" class="form-control" placeholder="Role" value="{{ old('role') }}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Signature Hero</span>
                    </div>
                    <input  type="text" name="signature_hero" id="signature_hero" class="form-control" placeholder="Signature Hero" value="{{ old('signature_hero') }}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Total Earnings</span>
                    </div>
                    <input  type="number" name="total_earnings" id="total_earnings" class="form-control" placeholder="total earnings" value="{{ old('total_earnings') }}" >
                </div>

                <div class="input-group col-12 col-md-6 mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Followers</span>
                    </div>
                    <input  type="number" name="followers" id="followers" class="form-control" placeholder="Status" value="{{ old('followers') }}" >
                </div>





                <div class="input-group col-12 mb-4" >
                  <textarea name="summary" id="player_summary" rows="5" class="form-control"  placeholder="Player Summary ..." value="{{ old('player_summary') }}" ></textarea>
                </div>
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
<script>
//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal();
});

</script>


<!-- //scripts for country select -->
<!-- <script src="//cdn.tutorialjinni.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//cdn.tutorialjinni.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://mojoaxel.github.io/bootstrap-select-country/dist/js/bootstrap-select-country.min.js"></script> -->

    
@endsection