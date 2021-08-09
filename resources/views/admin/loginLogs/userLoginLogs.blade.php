@extends('layouts.master')
@section('links')
@endsection
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>{{$user->username}}'s log</h5> 
                        </div>
                    </div> 
                    <div class="card-body">
                        <table id="log_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                <th width="3%">#</th>
                                <th width="7%">IP address</th>
                                <th width="7%">action</th>
                                <th width="10%">Browser Info</th>
                                <th width="10%">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $key =>$log)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$log->last_login_ip}}</td>
                                        <td>
                                            @if ($log->action === 'login')
                                                <div class="ml-1 badge badge-pill badge-success"> {{$log->action}}</div>
                                            @else
                                                <div class="ml-1 badge badge-pill badge-danger"> {{$log->action}}</div>
                                            @endif
                                        </td>
                                        <td>{{$log->browser_info}}</td>
                                        <td>{{$log->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $logs->links() }}
                        
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