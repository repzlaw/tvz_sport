@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-body">
                            
                                <div class="comments">
                                    <h5 style="font-weight: bold; text-transform: capitalize;"> All {{$type}} Comments</h5>
                                    <div class="col-12 mb-2">
                                        <form action="/v1/comments/individual" method="get">
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-4">
                                                    <div class="input-group mb-4" >
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Search by</span>
                                                        </div>
                                                        <select class="form-control custom-select" name="cat" id="search_column" required>
                                                            <option value="">-- search by -- </option>                           
                                                            <option value="news">News </option>                           
                                                            <option value="match">Match </option>                           
                                                            <option value="player">Player </option>                           
                                                            <option value="team">Team </option>                           
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <input type="hidden" value="{{ Auth::user()->id }}" name="user"> -->
                                                <div class="col-12 col-md-4" id="search_div">
                                                    <button class="btn btn-success" type="submit">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <hr>
                                    <!-- style="border-radius: 30px; box-shadow: 0 0 0 transparent; position: relative;
                                                    opacity: 1; background: #eafff4; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                    border-top-left-radius: 0.25rem; flex: 1; display: flex;max-width: 60%;" -->
                                    @if (count($comments))
                                        @foreach ($comments as $com)
                                            <div id="comment_div{{$com->id}}">
                                                <div>
                                                    <div class="ml-2 col-12 col-md-8"
                                                                    style="border-radius: 30px; box-shadow: 0 0 0 transparent; 
                                                                    opacity: 1; background: #f8f9fa; border: 0; padding: 0.75rem 1.5rem; border-radius: 30px;
                                                                    border-top-left-radius: 0.25rem; flex: 1;"
                                                    >
                                                        <b class="mr-5">{{$com->user->username}} </b>
                                                        <br>
                                                        <small>{{$com->created_at}}</small>
                                                        <div class="mt-2"
                                                            >
                                                            {{$com->content}}
                                                        </div>
                                                    </div>
                                                    <!-- <hr> -->
                                                </div>
                                                @auth()
                                                <div class="col-12 mt-1">
                                                    <div class="row">
                                                        <p class="ml-4 mt-2"><a href="javascript:void(0)" style="text-decoration: none;" id="view_upvotes{{$com->id}}">{{$com->numRecommends}} @choice('upvote|upvotes', $com->numRecommends) </a> </p>
                                                        {{-- <p class="ml-4 mt-2" onclick="deleteComment({{$com->id}},{{$com->user_id}})"><a href="javascript:void(0)" id="delete_comment{{$com->id}}">delete</a> </p>  --}}
                                                    </div>
                                                </div>
                                                @endauth
                                                <hr>
                                            </div>
                                        @endforeach
                                        
                                    @else
                                        <div class="alert alert-info text-center">
                                            <b>You have not commented on any {{$type}}.</b>
                                        </div>
                                    @endif


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
</script>
@endsection

