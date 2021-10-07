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
                            {{-- <i class="fab fa-forumbee  mr-2"></i> --}}
                            Report Thread
                          </h5> 
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-12 col-md-6">
                                <h5>cleanup report</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
                                    <label class="form-check-label" for="exampleRadios1">
                                      Code of conduct Voilation:
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                    <label class="form-check-label" for="exampleRadios2">
                                      Thread is in a wrong forum
                                    </label>
                                  </div>
                                  <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" >
                                    <label class="form-check-label" for="exampleRadios3">
                                      Thread has misleading title
                                    </label>
                                  </div>
                                  <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="option3" >
                                    <label class="form-check-label" for="exampleRadios4">
                                      Technical issue
                                    </label>
                                  </div>
                                  <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios5" value="option3" >
                                    <label class="form-check-label" for="exampleRadios5">
                                      other:
                                    </label>
                                  </div>

                            </div> --}}
                            <div class="col-12 col-md-12">
                                <form action="{{ route('forum.thread.report.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Policies</span>
                                            </div>
                                            <select class="form-control custom-select" name="policy_id" id="sport-type" required >
                                                <option value="">-- Select Policies -- </option>
                                                @foreach ($policies as $policy)
                                                    <option value="{{$policy->id}}">{{$policy->reason}} </option>                           
                                                @endforeach                          
                                            </select>
                                        </div>
                                        <textarea name="user_notes" id="user_notes" rows="5" class="form-control"  placeholder="State reason here ..." value="{{ old('user_notes') }}" required></textarea>
                                        <input type="hidden" name="forum_thread_id" id="forum_thread_id" value="{{$thread_id}}" required>
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
