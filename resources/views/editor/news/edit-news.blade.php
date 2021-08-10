@extends('layouts.editor')

@section('content')
<div class="container">
    <div class="row card">
        <div class="col-md-10 col-md-offset-1">
            <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Edit News</h5> 
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('editor.news.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                    <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Sport Type</span>
                                        </div>
                                        <select class="form-control custom-select" name="sport_type" required>
                                            <option value="">-- All Category -- </option> 
                                            @foreach ($sports as $sport)
                                            <option value="{{$sport->id}}" {{ $sport->id == $news->sport_type_id ? 'selected' : ''}}
                                                >{{$sport->sport_type}} </option>                           
                                            @endforeach                          
                                        </select>
                                    </div>
                                    <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Page Title</span>
                                        </div>
                                        <input style="width: 80%; margin: auto;" type="text" value="{{$news->page_title}}" name="page_title" class="form-control" placeholder="Page Title ...">
                                    </div>
                                    <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Meta description</span>
                                        </div>
                                        <input style="width: 80%; margin: auto;" type="text" value="{{$news->meta_description}}" name="meta_description"  class="form-control" placeholder="Meta description ...">
                                    </div>
                                <input style="width: 80%; margin: auto;" type="text" value="{{$news->headline}}" name="news_title"  class="form-control" placeholder="News Title ..." required>
                                <br>
                                <textarea style="width: 80%; margin: auto;" name="news_body" id="new-post"  rows="5" class="form-control" placeholder="Write News Body here ..." required>{{$news->content}}</textarea>
                                <br>
                                <div style="width: 80%; margin: auto;" class="col-12 col-md-12">
                                    <div class="row">
                                        <div  class="col-6 col-md-6">
                                            <div id="player-bagde" class="mb-2"></div>
                                            <input placeholder="search Players" type="text" size="30" class="form-control" id="search-input" onkeyup="showResult(this.value)">
                                            <ul id="livesearch" class="list-group"></ul>

                                        </div>

                                        <div  class="col-6 col-md-6">
                                            <div id="team-bagde" class="mb-2"></div>
                                            <input placeholder="search Teams" type="text" size="30" class="form-control" id="search-team" onkeyup="showTeamResult(this.value)">
                                            <ul id="liveteamsearch" class="list-group"></ul>

                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="teams" id="teams_id">
                                <input type="hidden" name="players" id="players_id">
                                <input type="hidden" value="{{$news->id}}" name="postId" id="post_id">

                                <button style="margin-left: 10%;" type="submit" class="btn btn-success mt-4 float-right" >Save News</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

//function for player live search
function showResult(str) {
    $.ajax({
        method: 'POST',
        url: '{{ route('editor.news.search.player')}}',
        data:{q: str,"_token": "{{ csrf_token() }}", from:'editor'}

    })
    .done(function(msg){
        if (msg.length) {
            $('#livesearch').html(msg);
        }
    })
    .fail(function(xhr, status, error) {
        // alert(error)
    });

}

var players = [];
var playersID = [];
//on select of a player
function selectPlayer(p){
    if (players.length === 0) {
        players.push(p);
        playersID.push(p.id);
        
    }else{
        if (!playersID.includes(p.id)) {
            players.push(p);
            playersID.push(p.id);
        }
    }
    var h = '';
    players.forEach((play,i) => {
        h += `<span  class="badge badge-secondary mr-2">
                ${play.full_name}
                <i class="text-danger fa fa-trash fa-1x" onclick="removePlayer(${i})" style="cursor:pointer;"></i>
            </span>
            `;
            // <input type="hidden" name="players[]" value="${play.id}" />
        $('#player-bagde').html(h);
        $('#search-input').val('');
        $('#livesearch').html('');
    });
    
    $('#players_id').val(playersID)
}

//remove a player from selection
function removePlayer (index) {
    players.splice(index, 1);
    playersID.splice(index, 1);
    var h = '';
    if (!players.length) {
        $('#player-bagde').html('');
    }else{
        players.forEach((play,i) => {
            h += `<span  class="badge badge-secondary mr-2">
                    ${play.full_name}
                    <i class="text-danger fa fa-trash fa-1x" onclick="removePlayer(${i})" style="cursor:pointer;"></i>
                </span>`;
            $('#player-bagde').html(h);
            $('#search-input').val('');
            $('#livesearch').html('');
        });
    }
    $('#players_id').val(playersID)  
}


//function for team live search
function showTeamResult(str) {
    $.ajax({
        method: 'POST',
        url: '{{ route('editor.news.search.team')}}',
        data:{q: str, "_token": "{{ csrf_token() }}", from:'editor'}

    })
    .done(function(msg){
        if (msg.length) {
            $('#liveteamsearch').html(msg);
        }
    })
    .fail(function(xhr, status, error) {
        // alert(error)
    });

}

var teams = [];
var teamsID = [];
//on select of a team
function selectteam(p){
    if (teams.length === 0) {
        teams.push(p);
        teamsID.push(p.id);
        
    }else{
        if (!teamsID.includes(p.id)) {
            teams.push(p);
            teamsID.push(p.id);
        }
    }
    var h = '';
    teams.forEach((team,i) => {
        h += `<span  class="badge badge-primary mr-2">
                ${team.team_name}
                <i class="text-danger fa fa-trash fa-1x" onclick="removeteam(${i})" style="cursor:pointer;"></i>
            </span>`;
        $('#team-bagde').html(h);
        $('#search-team').val('');
        $('#liveteamsearch').html('');
    });
    $('#teams_id').val(teamsID)

}

//remove a team from selection
function removeteam (index) {
    teams.splice(index, 1);
    teamsID.splice(index, 1);
    var h = '';
    if (!teams.length) {
        $('#team-bagde').html('');
    }else{
        teams.forEach((team,i) => {
            h += `<span  class="badge badge-primary mr-2">
                    ${team.team_name}
                    <i class="text-danger fa fa-trash fa-1x" onclick="removeteam(${i})" style="cursor:pointer;"></i>
                </span>`;
            $('#team-bagde').html(h);
            $('#search-team').val('');
            $('#liveteamsearch').html('');
        });
    }
    $('#teams_id').val(teamsID)
    
}
</script>
@endsection
