@extends('layouts.master')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Reported team comments</h5> 
                        </div>
                    </div> 
                    <div class="card-body">
                        @if (count($posts))
                            <table id="post_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th>policy</th>
                                        <th>reason</th>
                                        {{-- <th>title</th> --}}
                                        <th>body</th>
                                        <th width="10%">reported by</th>
                                        <th>date & time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $key =>$post)
                                        <tr>
                                           <td>{{$key+1}} </td>
                                            <td>{{$post->reason}}</td>
                                            <td>{{$post->user_notes}}</td>
                                            {{-- <td>{{$post->title}}</td> --}}
                                            <td>{{$post->content}}</td>
                                            <td>{{$post->username}}</td>
                                            <td>{{$post->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        @else
                            <div class="alert alert-info text-center">
                                <b>No team comment reported</b>
                            </div>
                            
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

</script>
    
@endsection