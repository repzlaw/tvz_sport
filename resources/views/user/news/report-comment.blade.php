@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-8 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                          <h5>
                            Report comment
                          </h5> 
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <form action="{{ route('news.report.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Policies</span>
                                            </div>
                                            <select class="form-control custom-select" name="policy_id" id="sport-type" required >
                                                <option value="">-- Select Policies -- </option>
                                                @foreach ($policies as $policy)
                                                    <option value="{{$policy->reason}}">{{$policy->reason}} </option>                           
                                                @endforeach                          
                                            </select>
                                        </div>
                                        <textarea name="user_notes" id="user_notes" rows="5" class="form-control"  placeholder="State reason here ..." value="{{ old('user_notes') }}" required></textarea>
                                        <input type="hidden" name="comment_id" id="comment_id" value="{{$comment_id}}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id = "modal-save">Save changes</button>
                                    </div>
                                </form>
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
