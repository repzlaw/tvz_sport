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
                                <div class="col-12 mb-4">
                                    <h3 style="font-weight: bold;">{{$news->headline}}</h3>
                                    <small>by {{$news->user->username}} </small>
                                    <small class="ml-3">{{date('d/m/Y', strtotime($news->updated_at))}}</small>
                                    <small class="ml-3">{{date('H:i', strtotime($news->updated_at))}}</small>
                                </div>
                                <div class="row ml-3">
                                    <p>{!! html_entity_decode($news->content) !!}</p>
                                </div> 

                                <div class="row ml-3">
                                    related:
                                    @foreach ($news->teamnews as $teamnews)
                                        <a href="{{route('team.get-news',['team_slug'=>$teamnews->team->url_slug.'-'.$teamnews->team->id])}}">
                                            <span class="badge badge-secondary ml-2 mt-1">
                                                {{$teamnews->team->team_name}}
                                            </span>
                                        </a>
                                    @endforeach
                                    @foreach ($news->playernews as $playernews)
                                        <a href="{{route('player.get-news',['player_slug'=>$playernews->player->url_slug.'-'.$playernews->player->id])}}">
                                            <span  class="badge badge-secondary ml-2 mt-1">
                                                {{$playernews->player->name}}
                                            </span>
                                        </a>
                                    @endforeach
                                </div> 
                                <hr>
                                @guest()
                                    <p>please <a href="/login">log in</a>  or <a href="/register">sign up</a>  to comment</p>

                                @else
                                    <form action="{{ route('news.comment.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="interaction mt-3 mb-3 row">
                                            <div class="col-9 col-sm-9" style="padding-right: 0;">
                                                <textarea placeholder="Add comment ..." name="comment" type="text" 
                                                class="form-control-lg form-control mb-3" style="border-radius: 30px !important;" required></textarea>
                                                <select name="language">
                                                    <option value="English">English</option>
                                                    <option value="Portuguese">Portuguese</option>
                                                    <option value="Spanish">Spanish</option>
                                                    <option value="Russian">Russian</option>
                                                </select>
                                            </div>
                                            <div class="col-3 col-sm-3 mt-3 float-right">
                                                <!-- <button class="btn btn-info b-circle" type="button" ><i class="fa fa-paperclip"></i></button> -->
                                                <button type="submit" class="btn btn-primary b-circle">
                                                    <i class="fa fa-paper-plane"></i>
                                                </button>
                                            </div> 
                                        </div>
                                        <input type="hidden" name="news_id" value="{{$news->id}}">
                                    </form>
                                    <hr>

                                @endguest


                                <div class="comments">
                                    <h5 style="font-weight: bold;">Comments</h5>
                                    <hr>
                                    <div id="comments_section">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.0/jquery.timeago.min.js" integrity="sha512-4g1PvFI8aR8IYr3mnvKJpjkarHtqNstmP/teCXWyMZImLPOJ+uK01Co6UnMCMtD12I4N3zQUNSJ3EVJpbwhQmw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
//get comments ajax 
function getComments(str) {
    $.ajax({
        method: 'GET',
        url: '{{ route('get.comments')}}',
        data:{c: {{$news->id}}, lang: 'en-us', cat:'news'}

    })
    .done(function(msg){
        if (msg.comments.length) {
            let comments = ``;
            msg.comments.forEach(com => {
                
                comments += `<div>
                                <div class="ml-2 col-12 col-md-8"
                                                style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                border-top-left-radius: 0.25rem; flex: 1;"
                                >
                                    <b class="mr-5">${com.user.username} </b>
                                    <br>
                                    <small class="comment_date" title="${com.created_at}">${com.created_at}</small>
                                    <div class="mt-2"
                                        >
                                        ${com.content}
                                    </div>
                                </div>
                                <div class="col-12 mt-1">
                                    <div class="row" id="reply_row${com.id}">
                                        @auth()
                                            <p class="ml-4 mt-2" onclick="replyForm(${com.id})"><a href="javascript:void(0)" id="show_reply${com.id}">reply</a> </p>
                                        @endauth
                                    </div>
                                </div>
                            </div>
    
                            <div id="reply_input${com.id}" class="ml-5" style="display:none">
                                <div class="ml-2 col-12 col-md-8"
                                                style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                border-top-left-radius: 0.25rem; flex: 1;">
                                    <form action="{{ route('news.comment.reply.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="interaction mt-3 mb-3 row">
                                            <div class="col-9 col-sm-9" style="padding-right: 0;">
                                                @guest()
                                                    <p>please <a href="/login">log in</a>  or <a href="/register">sign up</a>  to reply</p>
                                                @endguest
                                                <textarea placeholder="Reply comment ..." name="comment"
                                                        type="text" class="form-control-lg form-control  mb-3" style="border-radius: 30px !important;" 
                                                        required></textarea>
    
                                                        <select name="language">
                                                            <option value="English">English</option>
                                                            <option value="Portuguese">Portuguese</option>
                                                            <option value="Spanish">Spanish</option>
                                                            <option value="Russian">Russian</option>
                                                        </select>
                                            </div>
                                            <div class="col-3 col-sm-3 mt-3 float-right">
                                                
                                                <button type="submit" class="btn btn-primary b-circle">
                                                    <i class="fa fa-paper-plane"></i>
                                                </button>
                                            </div> 
                                        </div>
                                        <input type="hidden" name="comment_id" value="${com.id}">
                                        <input type="hidden" name="competition_news_id" value="${com.competition_news_id}">
                                    </form>
                                </div>
                                <br>
                            </div>
                            <div id="reply_section${com.id}" class="ml-5" style="display:none">
    
                            </div>
                            <hr>`;
        
            });
            $('#comments_section').html(comments);
            msg.comments.forEach(com => {
                if (com.reply.length) {
                    let view = `<p class="ml-4 mt-2" onclick="viewReplies(${com.id})"><a href="javascript:void(0)" id="view_reply${com.id}">view replies</a> </p>`;
                    $("#reply_row"+com.id).append(view);
                    let news_reply = '';   
                    com.reply.forEach(rep => {
                        news_reply += `
                                        <div class="ml-2 col-12 col-md-8"
                                                        style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                        opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                        border-top-left-radius: 0.25rem; flex: 1;"
                                        >
                                            <b class="mr-5">${rep.user.username} </b>
                                            <br>
                                            <small class="comment_date" title="${rep.created_at}">${rep.created_at}</small>
                                            <div class="mt-2"
                                                >
                                                ${rep.content}
                                            </div>
                                        </div>
                                        <br>
                        `;
                        
                    });
                    $("#reply_section"+com.id).html(news_reply);
                }
            });
       
            var $j = jQuery.noConflict();
        } else {
            let comments = `
                            <div class="alert alert-info text-center">
                                <b>Be the first to comment.</b>
                            </div>
            `;
            $('#comments_section').html(comments);
            
        }
    })
    .fail(function(xhr, status, error) {
        // alert(error)
    });

}
this.getComments();




//toggle replies
function viewReplies(id){
    $("#reply_section"+id).toggle(1000);
    var text = $('#view_reply'+id).text();
    $('#view_reply'+id).text(
        text == "view replies" ? "hide replies" : "view replies");
}

//toggle reply form
function replyForm(id){
    $("#reply_input"+id).toggle(1000);
    var text = $('#show_reply'+id).text();
    $('#show_reply'+id).text(
        text == "reply" ? "X" : "reply");
}
</script>
<script type="text/javascript">
    $(document).ajaxStop(function () {
        $("small.comment_date").timeago();
    });
</script>
@endsection

