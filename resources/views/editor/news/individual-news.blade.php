@extends('layouts.editor')

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
                                <h3>{{$news->headline}}</h3>
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
                            @if ($news->enable_comment)
                                <div class="comments" id="footer">
                                    <div style="display:none;" id="comment_text">
                                        <div class="row">
                                            <h5 style="font-weight:bold;" class="mr-5 ml-4">Comments</h5>
                                            <div class="input-group mb-4 mr-5" style="width: 250px; ">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Select language</span>
                                                </div>
                                                <select class="form-control custom-select" name="language" onchange="getLanguage(this.value)"required>
                                                    <option value="en-us">English</option>
                                                    <option value="pt">Portuguese</option>
                                                    <option value="es">Spanish</option>
                                                    <option value="ru">Russian</option>                         
                                                </select>
                                            </div>
                                            <div class="input-group mb-4" style="width: 250px; ">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Order by</span>
                                                </div>
                                                <select class="form-control custom-select" name="orderby" onchange="getOrder(this.value)"required>
                                                    <option value="newest">Newest</option>
                                                    <option value="oldest">Oldest</option>
                                                    <option value="upvote">Upvotes</option>
                                                </select>
                                            </div>


                                        </div>
                                    </div>
                                    <hr>
                                    <div id="comments_section">

                                    </div>

                                </div>
                            {{-- @else
                                <div class="alert alert-info text-center">
                                    <b>Comments disabled for this post.</b>
                                </div> --}}
                            @endif

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
    let language = 'en-us';
    let orderby = 'asc';

    function getOrder(order){
        orderby = order
        getComments();
    }

    function getLanguage(lang){
        language = lang
        getComments();
    }
let status = true;
let page = 1;
// let last_page = 0;

//get comments ajax 
function getComments() {
    // let page_no = page +1;
    status = false;
    $.ajax({
        method: 'GET',
        url: '{{ route('comment.get')}}',
        data:{pages:page, c: {{$news->id}}, lang: language, cat:'news', orderby:orderby}
    })
    .done(function(msg){
        if (msg.comments.data.length) {
            $("#comment_text").show();

            let comments = ``;
            msg.comments.data.forEach(com => {
                //get image to display
                let com_path = com.user.picture;
                    let com_src = com_path ? "/storage/images/user_images/"+com.user.picture.file_path 
                                    : "https://ui-avatars.com/api/?background=random&name="+com.user.username;

                comments += `<div id="comment_div${com.id}">
                                <div class="ml-2 col-12 col-md-8" 
                                                style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                border-top-left-radius: 0.25rem; flex: 1;"
                                >
                                    <img
                                        src="${com_src}"
                                        alt="${com.user.username}"
                                        style="height: 30px; width:30px;  border-radius: 15px;"/>
                                    <b class="ml-1 mr-5">${com.user.display_name ? com.user.display_name : com.user.username}</b>
                                    <br>
                                    <small class="comment_date" title="${com.created_at}">${com.created_at}</small>
                                    <div class="mt-2"
                                        >
                                        ${com.content}
                                    </div>
                                </div>
                                <div class="col-12 mt-1">
                                    <div class="row" id="reply_row${com.id}">
                                            <div href="javascript:void(0)" class="ml-3 mt-2" style="text-decoration:none" id="num_recommend${com.id}">${com.numRecommends} upvote</div>
                                    </div>
                                </div>
                            </div>
    
                            <div id="reply_section${com.id}" class="ml-5" style="display:none">
    
                            </div>
                            <hr>

                            `;
        
            });
            $('#comments_section').html(comments);
            if (msg.comments.next_page_url !== null) {
                $('#comments_section').append(`<div class="container m-auto" id="view_more" onclick="getComments('${msg.summary.lang_iso}')"><a href="javascript:void(0)">view more<a/></div>`);
            }
            msg.comments.data.forEach(com => {
                if (com.reply.length) {
                    let view = `<p class="ml-4 mt-2" onclick="viewReplies(${com.id})"><a href="javascript:void(0)" id="view_reply${com.id}">view replies</a> </p>`;
                    $("#reply_row"+com.id).append(view);
                    let news_reply = '';   
                    com.reply.forEach(rep => {
                        //get image to display
                        let rep_path = rep.user.picture;
                            let rep_src = rep_path ? "/storage/images/user_images/"+rep.user.picture.file_path 
                                            : "https://ui-avatars.com/api/?background=random&name="+rep.user.username;

                        news_reply += `<div id="reply_div${rep.id}">
                                            <div class="ml-2 col-12 col-md-8"
                                                            style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                            opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                            border-top-left-radius: 0.25rem; flex: 1;"
                                            >
                                                <img
                                                    src="${rep_src}"
                                                    alt="${rep.user.username}"
                                                    style="height: 30px; width:30px;  border-radius: 15px;"/>
                                                <b class="ml-1 mr-5">${rep.user.display_name ? rep.user.display_name : rep.user.username}</b>
                                                <br>
                                                <small class="comment_date" title="${rep.created_at}">${rep.created_at}</small>
                                                <div class="mt-2"
                                                    >
                                                    ${rep.content}
                                                </div>
                                            </div>
                                            <div class="col-12 mt-1">
                                                <div class="row" id="rep_row${rep.id}">
                                                    <div href="javascript:void(0)" class="ml-3 mt-2" style="text-decoration:none" id="num_recommend${rep.id}">${rep.numRecommends} upvote</div>
                                                </div>
                                            </div>

                                        </div>
                        `;
                        
                    });
                    $("#reply_section"+com.id).html(news_reply);

                }
            });
       
            page++;

        } else {
            let comments = `
                            <div class="alert alert-info text-center">
                                <b>No comments.</b>
                            </div>
            `;
            $('#comments_section').html(comments);
            
        }
        
    })
    .fail(function(xhr, status, error) {
        // alert(error)
    });

}

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

//load comments only on scroll
$(document).scroll(function() {
    if ({{$news->enable_comment}}) {
        var value = $("#footer").offset().top,
            position = $(document).scrollTop() + $(window).height();
        if (status && position >= value ) {
            getComments('en-us');
        }
        
    }
});

// Check if body height is less than or equal to window height :)
$(document).ready(function() {
    if ({{$news->enable_comment}}) {
        if (status && $("body").height() <= $(window).height()) {
            getComments('en-us');
        }
    }
});

// report comment
function reportComment(){

}
</script>
@endsection
