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
                                @if ($news->enable_comment)
                                    @guest()
                                        <p>please <a href="/login">log in</a>  or <a href="/register">sign up</a>  to comment</p>

                                    @else
                                        <form action="{{ route('news.comment.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="interaction mt-3 mb-3 row">
                                                <div class="col-9 col-sm-9" style="padding-right: 0;">
                                                    <textarea placeholder="Add comment ..." name="comment" type="text" 
                                                    class="form-control-lg form-control mb-3" style="border-radius: 30px !important;" required></textarea>
                                                    <select name="language" required>
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
                                            <p id="comment_number"></p>
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

    //get comments ajax 
    function getComments() {
        status = false;
        $.ajax({
            method: 'GET',
            url: '{{ route('comment.get')}}',
            data:{pages:page, c: {{$news->id}}, lang: language, cat:'news', orderby:orderby}
        })
        .done(function(msg){
            if (msg.comments.data.length) {
                let AuthUser = {{ auth()->check() ? 'true' : 'false' }}
                let auth_user_id = 0; 

                if (AuthUser === true) {
                    let user_details = {!! auth()->user() !!}
                    auth_user_id = user_details.id
                } 
                else{
                    auth_user_id = 0;
                }
                $("#comment_text").show();
                let comments = ``;
                msg.comments.data.forEach(com => {
                    
                    comments += `<div id="comment_div${com.id}">
                                    <div class="ml-2 col-12 col-md-8" 
                                                    style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                    opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                    border-top-left-radius: 0.25rem; flex: 1;">
                                        <b class="mr-5">${com.user.username} </b>
                                        <br>
                                        <small class="comment_date" title="${com.created_at}">${com.created_at}</small>
                                        <div class="mt-2">
                                            ${com.content}
                                        </div>
                                    </div>
                                    <div class="col-12 mt-1">
                                        <div class="row" id="reply_row${com.id}">
                                            @auth()
                                                <p class="ml-4 mt-2" onclick="upvoteComment(${com.id})"><a href="javascript:void(0)" ><i class="far fa-thumbs-up" id="upvote_comment_icon${com.id}"></i></a></p>
                                                <a href="javascript:void(0)" class="ml-2 mt-2" id="num_recommend${com.id}">${com.numRecommends}</a>
                                                <p class="ml-4 mt-2" onclick="replyForm(${com.id})"><a href="javascript:void(0)" id="show_reply${com.id}">reply</a> </p>
                                            @else
                                                <div class="ml-3 mt-2">${com.numRecommends} upvote</div>

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
        
                                                            <select name="language" required>
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
                                <hr>

                                `;
            
                });
                $('#comments_section').html(comments);
                if (msg.comments.next_page_url !== null) {
                    $('#comments_section').append(`<div class="container m-auto" id="view_more" onclick="getComments('${msg.summary.lang_iso}')"><a href="javascript:void(0)">view more<a/></div>`);
                }
                msg.comments.data.forEach(com => {
                    if (auth_user_id) {
                        // checkUpvote(com.id)
                        if (auth_user_id === com.user_id) {
                            // let delete_comment = `<p class="ml-4 mt-2" onclick="deleteComment(${com.id},${com.user_id})"><a href="javascript:void(0)" id="delete_comment${com.id}">delete</a> </p>`;
                            // $("#reply_row"+com.id).append(delete_comment);
                        }else{
                            let report_comment = `<p class="ml-4 mt-2" onclick="reportComment(${com.id},${com.user_id})"><a href="javascript:void(0)" id="report_comment${com.id}">report</a> </p>`;
                            $("#reply_row"+com.id).append(report_comment);
                        }
                    }
                    if (com.reply.length) {
                        let view = `<p class="ml-4 mt-2" onclick="viewReplies(${com.id})"><a href="javascript:void(0)" id="view_reply${com.id}">view replies</a> </p>`;
                        $("#reply_row"+com.id).append(view);
                        let news_reply = '';   
                        com.reply.forEach(rep => {
                            news_reply += `<div id="reply_div${rep.id}">
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
                                                <div class="col-12 mt-1">
                                                    <div class="row" id="rep_row${rep.id}">
                                                        @auth()
                                                            <p class="ml-4 mt-2" onclick="upvoteComment(${rep.id})"><a href="javascript:void(0)" ><i class="far fa-thumbs-up" id="upvote_comment_icon${rep.id}"></i></a></p>
                                                            <a href="javascript:void(0)" class="ml-2 mt-2" id="num_recommend${rep.id}">${rep.numRecommends}</a>
                                                            ${auth_user_id === rep.user_id ? 
                                                                `<span/>`
                                                              // `<p class="ml-4 mt-2" onclick="deleteReply(${rep.id},${rep.user_id})"><a href="javascript:void(0)" id="delete_reply${rep.id}">delete</a> </p>` 
                                                                :  `<p class="ml-4 mt-2" onclick="reportComment(${rep.id},${rep.user_id})"><a href="javascript:void(0)" id="report_reply${rep.id}">report</a> </p>`
                                                            }
                                                        @else
                                                            <div class="ml-3 mt-2">${rep.numRecommends} upvote</div>
                                                        @endauth
                                                    </div>
                                                </div>

                                            </div>
                            `;
                            
                        });
                        $("#reply_section"+com.id).html(news_reply);
                        if (auth_user_id) {
                            com.reply.forEach(rep => {
                                // checkUpvote(rep.id)
                            });
                        }

                    }
                });
                // var $j = jQuery.noConflict();
                page++;

            } else {
                let comments = `
                                <div class="alert alert-info text-center">
                                    <b>Be the first to comment.</b>
                                </div>
                `;
                $('#comments_section').html(comments);
                
            }
            $('#comment_number').text(msg.summary.total + ' comment(s)');
            
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

    //delete comment
    // function deleteComment(com_id,user_id){
    //     $.ajax({
    //         method:'GET',
    //         url: '{{ route('comment.delete')}}',
    //         data:{user_id:user_id, comment_id:com_id}
    //     })
    //     .done(function(res){
    //         if (res.status) {
    //             $('#comment_div'+res.comment_id).remove();
    //         }
    //     })
    // }

    //delete reply
    // function deleteReply(com_id,user_id){
    //     $.ajax({
    //         method:'GET',
    //         url: '{{ route('comment.reply.delete')}}',
    //         data:{user_id:user_id, comment_id:com_id}
    //     })
    //     .done(function(res){
    //         if (res.status) {
    //             $('#reply_div'+res.comment_id).remove();
    //         }
    //     })
    // }

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

    //check if comment is upvoted
    function checkUpvote(com_id){
        $.ajax({
            method:'GET',
            url: '{{ route('comment.check.upvote')}}',
            data:{comment_id:com_id, model:'news'}
        })
        .done(function(res){
            if (res) {
                $("#upvote_comment_icon"+com_id).attr('class', 'fas fa-thumbs-up');
            
            }
        })
    }

    //upvote or remove vote
    function upvoteComment(com_id){
        $.ajax({
            method:'GET',
            url: '{{ route('comment.upvote')}}',
            data:{comment_id:com_id, model:'news'}
        })
        .done(function(res){
            $("#num_recommend"+com_id).text(res.numRecommends);
            res.status ?
                $("#upvote_comment_icon"+com_id).attr('class', 'fas fa-thumbs-up')
            :
                $("#upvote_comment_icon"+com_id).attr('class', 'far fa-thumbs-up')
        })
    }
</script>
@endsection

