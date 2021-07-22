@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row card">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="card-header"><h2 style="margin-left: 10%;">My News</h2></div>

                {{-- <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    {{-- <section class="row new-post">
                        <div class="col-md-6 col-md-offset-6">

                        </div> --}}
                    <br><br>
                    <form action="{{ route('news.editor.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                        {{ csrf_field() }}
                                <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Sport Type</span>
                                    </div>
                                    <select class="form-control custom-select" name="sport_type" required>
                                        <option value="">-- All Category -- </option> 
                                        @foreach ($sports as $sport)
                                        <option value="{{$sport->id}}">{{$sport->sport_type}} </option>                           
                                        @endforeach                          
                                    </select>
                                </div>
                                <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Page Title</span>
                                    </div>
                                    <input style="width: 80%; margin: auto;" type="text" name="page_title" class="form-control" placeholder="Page Title ...">
                                </div>
                                <div class="input-group mb-4" style="width: 80%; margin: auto;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Meta description</span>
                                    </div>
                                    <input style="width: 80%; margin: auto;" type="text" name="meta_description"  class="form-control" placeholder="Meta description ...">
                                </div>
                            <input style="width: 80%; margin: auto;" type="text" name="news_title"  class="form-control" placeholder="News Title ..." required>
                            <br>
                            <textarea style="width: 80%; margin: auto;" name="news_body" id="new-post"  rows="5" class="form-control" placeholder="Write News Body here ..." required></textarea>
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

                            
                            
                            <button style="margin-left: 10%;" type="submit" class="btn btn-primary mt-3" >Create Post</button>
                            {{-- <input type="hidden" value="{{session::token()}}" name="_token"> --}}
                        </form>
                        
                        <hr>
                    {{-- </section> --}}
                    <section class="row posts" style="margin-left: 6%;" >
                        <div class="col-md-8 ">
                        <header><h4>My Posts</h4></header>
                       
                        
                        @if (count($posts)>0)
                            @foreach ($posts as $post)
                            
                                <article class="post" data-postid="{{ $post->id }}">

                                        <h5>{{$post->headline}} </h5>
                                        <span  data-competitionId="{{ $post->sport_type_id }}">
                                    <p>{{$post->content}}</p>
                                    <input type="hidden" name="sport_type_id" value="{{$post->sport_type_id}}">
                                @foreach ($post->teamnews as $teamnews)
                                <!-- {{$teamnews}} -->
                                    <span class="badge badge-secondary mr-1 mb-2">
                                        {{$teamnews->team->team_name}}
                                        <a href="{{route('news.editor.team.delete',['id'=>$teamnews->id])}}">
                                            <i class="text-danger fa fa-trash fa-1x" style="cursor:pointer;"></i>
                                        </a>
                                    </span>
                                @endforeach
                                @foreach ($post->playernews as $playernews)
                                    <span  class="badge badge-secondary mr-1 mb-2">
                                        {{$playernews->player->name}}
                                        <a href="{{route('news.editor.player.delete',['id'=>$playernews->id])}}">
                                            <i class="text-danger fa fa-trash fa-1x" style="cursor:pointer;"></i>
                                        </a>
                                    </span>
                                @endforeach
                                    <br>
                                    <div class="interaction">
                                        | 
                                        <a href="{{route('news.get.single',['news_slug'=>$post->url_slug.'-'.$post->id])}}">View </a> |
                                        <a href="#" class="edit">Edit</a> |
                                        <a href="{{route('news.editor.delete',['id'=>$post->id])}}">Delete</a>

                                    </div>
                                    <input type="hidden" name="page_title" id="post_page_title" value="{{$post->page_title}}">
                                    <input type="hidden" name="meta_description" id="post_meta_description" value="{{$post->meta_description}}">
                                    
                                </article>
                            @endforeach
                        @endif
                    </div>
                    
                    </section>
                        
                </div>
            </div>
        </div>
    </div>
</div>


<!-- edit news modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit News</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form >
              <div class="form-group">
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sport Type</span>
                    </div>
                    <select class="form-control custom-select" name="sport_type" id="sport-type" required>
                        <option value="">-- All Category -- </option> 
                        @foreach ($sports as $sport)
                        <option value="{{$sport->id}}">{{$sport->sport_type}} </option>                           
                        @endforeach                          
                    </select>
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Page Title</span>
                    </div>
                    <input  type="text" name="page_title" id="page-title" class="form-control" placeholder="Page Title ...">
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Meta description</span>
                    </div>
                    <input  type="text" name="meta_description" id="meta-description" class="form-control" placeholder="Meta description ...">
                </div>
                <input type="text" name="news_title" id="post-title" class="form-control" placeholder="News Title ..." required>
                <br>
                  <textarea name="post-body" id="post-body" rows="5" class="form-control"  placeholder="Write News Body here ..." required></textarea>
                  <br>
                  <div  class="col-12 col-md-12">
                    <div class="row">
                        <div  class="col-6 col-md-6">
                            <div id="modal_player-bagde" class="mb-2"></div>
                            <input placeholder="search Players" type="text" size="30" class="form-control" id="modal_search-input" onkeyup="showResultModal(this.value)">
                            <ul id="modal_livesearch" class="list-group"></ul>

                        </div>

                        <div  class="col-6 col-md-6">
                            <div id="modal_team-bagde" class="mb-2"></div>
                            <input placeholder="search Teams" type="text" size="30" class="form-control" id="modal_search-team" onkeyup="showTeamResultModal(this.value)">
                            <ul id="modal_liveteamsearch" class="list-group"></ul>

                        </div>
                    </div>

                </div>
                <input type="hidden" name="teams" id="modal_teams_id">
                <input type="hidden" name="players" id="modal_players_id">
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id = "modal-save">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

    <script>
        var token = '{{ Session::token() }}';
    </script>




@endsection

@section('scripts')
<script>

//get current data in modal
$('.post').find('.interaction').find('.edit').on('click',function(event){
    event.preventDefault();

    postTitleElement = event.target.parentNode.parentNode.parentNode.childNodes[1];
    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    competitionId = event.target.parentNode.parentNode.dataset['competitionid'];



    var postTitle = postTitleElement.textContent;
    var postBody = postBodyElement.textContent;
    var pageTitle = $('#post_page_title').val();
    var metaDescription = $('#post_meta_description').val();


    $('#sport-type').val(competitionId);
    $('#post-title').val(postTitle);
    $('#post-body').val(postBody);
    $('#page-title').val(pageTitle);
    $('#meta-description').val(metaDescription);
    $('#edit-modal').modal();
});

//save edited news
$('#modal-save').on('click', function(){
    $.ajax({
        method: 'POST',
        url: '{{ route('news.editor.edit')}}',
        data:{news_body: $('#post-body').val(), postId: postId, _token: token,
             news_title:$('#post-title').val(), sport_type:$('#sport-type').val(),
             page_title:$('#page-title').val(), meta_description:$('#meta-description').val(),
             teams:teamsIDmodal, players:playersIDModal,
             }
    })
    .done(function(msg){
        location.reload();

        // console.log(msg);
        $(postTitleElement).text(msg.post.headline);
        $(postBodyElement).text(msg.post.content);
        $('#edit-modal').modal('hide');
    })
    .fail(function(xhr, status, error) {
        alert(error)
    });;
});

//function for player live search
function showResult(str) {
    $.ajax({
        method: 'POST',
        url: '{{ route('news.editor.search.player')}}',
        data:{q: str, _token: token, from:'editor'}

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

//delete player from a post
function deletePlayer(params) {
    
}



//function for team live search
function showTeamResult(str) {
    $.ajax({
        method: 'POST',
        url: '{{ route('news.editor.search.team')}}',
        data:{q: str, _token: token, from:'editor'}

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

//delete team from a post
function deleteTeam(params) {
    
}

//modal functions
// 
// 
// modal functions


//function for player live search modal
function showResultModal(str) {
    $.ajax({
        method: 'POST',
        url: '{{ route('news.editor.search.player')}}',
        data:{q: str, _token: token, from:'modal'}

    })
    .done(function(msg){
        if (msg.length) {
            $('#modal_livesearch').html(msg);
        }
    })
    .fail(function(xhr, status, error) {
        // alert(error)
    });

}

var playersModal = [];
var playersIDModal = [];
//on select of a player
function selectPlayerModal(p){
    if (playersModal.length === 0) {
        playersModal.push(p);
        playersIDModal.push(p.id);
        
    }else{
        if (!playersIDModal.includes(p.id)) {
            playersModal.push(p);
            playersIDModal.push(p.id);
        }
    }
    var h = '';
    playersModal.forEach((play,i) => {
        h += `<span  class="badge badge-secondary mr-2">
                ${play.full_name}
                <i class="text-danger fa fa-trash fa-1x" onclick="removePlayerModal(${i})" style="cursor:pointer;"></i>
            </span>
            `;
            // <input type="hidden" name="players[]" value="${play.id}" />
        $('#modal_player-bagde').html(h);
        $('#modal_search-input').val('');
        $('#modal_livesearch').html('');
    });
    
    $('#modal_players_id').val(playersIDModal)
}

//remove a player from selection
function removePlayerModal (index) {
    playersModal.splice(index, 1);
    playersIDModal.splice(index, 1);
    var h = '';
    if (!playersModal.length) {
        $('#modal_player-bagde').html('');
    }else{
        playersModal.forEach((play,i) => {
            h += `<span  class="badge badge-secondary mr-2">
                    ${play.full_name}
                    <i class="text-danger fa fa-trash fa-1x" onclick="removePlayerModal(${i})" style="cursor:pointer;"></i>
                </span>`;
            $('#modal_player-bagde').html(h);
            $('#modal_search-input').val('');
            $('#modal_livesearch').html('');
        });
    }
    $('#modal_players_id').val(playersIDModal)

    
}



//function for team live search
function showTeamResultModal(str) {
    $.ajax({
        method: 'POST',
        url: '{{ route('news.editor.search.team')}}',
        data:{q: str, _token: token, from:'modal'}

    })
    .done(function(msg){
        if (msg.length) {
            $('#modal_liveteamsearch').html(msg);
        }
    })
    .fail(function(xhr, status, error) {
        // alert(error)
    });

}

var teamsModal = [];
var teamsIDmodal = [];
//on select of a team
function selectteamModal(p){
    if (teamsModal.length === 0) {
        teamsModal.push(p);
        teamsIDmodal.push(p.id);
        
    }else{
        if (!teamsIDmodal.includes(p.id)) {
            teamsModal.push(p);
            teamsIDmodal.push(p.id);
        }
    }
    var h = '';
    teamsModal.forEach((team,i) => {
        h += `<span  class="badge badge-primary mr-2">
                ${team.team_name}
                <i class="text-danger fa fa-trash fa-1x" onclick="removeteamModal(${i})" style="cursor:pointer;"></i>
            </span>`;
        $('#modal_team-bagde').html(h);
        $('#modal_search-team').val('');
        $('#modal_liveteamsearch').html('');
    });
    $('#modal_teams_id').val(teamsIDmodal)

}

//remove a team from selection Modal
function removeteamModal(index) {
    teamsModal.splice(index, 1);
    teamsIDmodal.splice(index, 1);
    var h = '';
    if (!teamsModal.length) {
        $('#modal_team-bagde').html('');
    }else{
        teamsModal.forEach((team,i) => {
            h += `<span  class="badge badge-primary mr-2">
                    ${team.team_name}
                    <i class="text-danger fa fa-trash fa-1x" onclick="removeteamModal(${i})" style="cursor:pointer;"></i>
                </span>`;
            $('#modal_team-bagde').html(h);
            $('#modal_search-team').val('');
            $('#modal_liveteamsearch').html('');
        });
    }
    $('#modal_teams_id').val(teamsIDmodal)
}


</script>
@endsection
