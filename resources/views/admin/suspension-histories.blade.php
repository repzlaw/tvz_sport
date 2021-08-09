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
                            <h5>Suspension Histories</h5> 
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="col-12 mb-2 ">
                            <form action="{{ route('admin.history.search')}}" method="get">
                                <div class="row">
                                    <div class="col-12 col-md-4" id="search_div">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="query" name="query" placeholder="Search by user ID..." aria-label="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (count($histories))
                            <table id="history_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                    <!-- <th width="3%">#</th> -->
                                    <th width="7%">user ID</th>
                                    <!-- <th width="7%">fullname</th> -->
                                    <th>policy</th>
                                    <th>action</th>
                                    <th>reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $key =>$history)
                                        <tr>
                                            <!-- <td>
                                                {{$key+1}}
                                            </td> -->
                                            <td class="text-center">
                                                <a href="{{route('admin.user.profile',['id'=>$history->user_id])}}" title="view profile">
                                                    {{$history->user_id}}
                                                </a>    
                                            </td>
                                            <!-- <td>{{$history->user_id}}</td> -->
                                            <!-- <td>{{$history->name}}</td> -->
                                            <td>{{$history->policy->reason}}</td>
                                            <td>
                                                @if ($history->action === 'unsuspension')
                                                    <div class="ml-1 badge badge-pill badge-success"> {{$history->action}}</div></td>
                                                    
                                                @else
                                                    <div class="ml-1 badge badge-danger badge-info"> {{$history->action}}</div></td>
                                                    
                                                @endif
                                            <td>
                                                @if ($history->action === 'unsuspension')
                                                    {{$history->unsuspend_reason}}
                                                    
                                                @else
                                                    {{$history->policy->reason}}
                                                    
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $histories->links() }}
                            
                        @else
                            <div class="alert alert-info text-center">
                                <b>No Suspension History</b>
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