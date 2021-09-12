@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-6 m-auto">
                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                    <h5>Friend requests</h5> 
                                </div>
                                @auth
                                <div class=" float-right">
                                    @if(Auth::user()->user_type === 'editor')
                                        <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create friend</a></p>
                                    @endif
                                </div>
                                @endauth
                            </div> 
                            <ul class="list-group list-group-flush">
                                @forelse ($friends as $friend)
                                {{-- <!-- {{$friends}} --> --}}
                                    <li class="list-group-item">
                                        <a href="{{route('profile.user-profile',['user_slug'=>$friend->user->username.'-'.$friend->user->id])}}" 
                                            style="text-decoration: none;" class="">
                                            @if ($friend->user->picture)

                                                <img 
                                                    src="/storage/images/profile/{{$friend->user->picture->file_path}}"
                                                    alt="{{$friend->user->username}}"
                                                    class="mr-2"
                                                    style="height: 30px; width:30px; border: 2px solid #eee; border-radius: 100px;"
                                                >
                                            @else
                                                <img 
                                                    src="/storage/images/profile/no_image.png"
                                                    alt="{{$friend->user->username}}"
                                                    class="mr-2"
                                                    style="height: 30px; width:30px; border: 2px solid #eee; border-radius: 100px;"
                                                >
                                            @endif
                                            {{$friend->user->display_name? $friend->user->display_name : $friend->user->username}}
                                        </a>
                                        <a href="{{route('friend.decline-request', ['friend_slug'=>$friend->user->username.'-'.$friend->user->id])}}" style="border-radius: 20%" class="btn btn-danger btn-sm mt-2 float-right" id="">Decline</a>
                                        <a href="{{route('friend.accept.request', ['friend_slug'=>$friend->user->username.'-'.$friend->user->id])}}" style="border-radius: 20%" class="btn btn-success btn-sm ml-2 mr-3 mt-2 float-right"> Accept</a>
                                    
                                    </li>
                                @empty
                                <div class="alert alert-info text-center">
                                    <b>No pending friend requests.</b>
                                </div>
                                @endforelse 
                            </ul>
                            
                        </div>

                    </div>

                </div>

            </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

</script>
    
@endsection