@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-8 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Settings</h5> 
                        </div>
                        {{-- <div class="float-right">
                            <p><a href="#" class="btn btn-primary btn-sm"  id="create-button">Create Policies</a></p>
                        </div> --}}
                    </div> 
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                          <form action="{{ route('admin.setting.save')}}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-1 col-12 col-md-10" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">reCAPTCHA Enable</span>
                                </div>
                                <select class="form-control custom-select" name="captcha_enable" id="captcha_enable" required>
                                  <option value="0">disable </option>                           
                                  <option value="1">enable </option>                           
                              </select>
                              <div class="input-group-append">
                                <button class="btn btn-success" type="submit">Save</button>
                              </div>
                            </div>
                          </form>
                        </li>
                        <li class="list-group-item">
                          <form action="{{ route('admin.setting.save')}}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-1 col-12 col-md-10" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">reCAPTCHA Site Key</span>
                                </div>
                                <input type="text" name="captcha_site_key" class="form-control"  value="{{ $captcha_site_key }}" required>
                                <div class="input-group-append">
                                  <button class="btn btn-success" type="submit">Save</button>
                              </div>
                            </div>
                          </form>
                        </li>
                        <li class="list-group-item">
                          <form action="{{ route('admin.setting.save')}}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-1 col-12 col-md-10" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">reCAPTCHA Secret Key</span>
                                </div>
                                <input type="text" name="captcha_secret_key" class="form-control"  value="{{ $captcha_secret_key }}" required>
                                <div class="input-group-append">
                                  <button class="btn btn-success" type="submit">Save</button>
                              </div>
                            </div>
                          </form>
                        </li>
                        <li class="list-group-item">
                          <h5 class="ml-3 mb-2">reCaptcha for forms</h5>
                          <form action="{{ route('admin.setting.save')}}" method="post">
                            {{ csrf_field() }}
                            <div class="row ml-2">
                              <div class="input-group mb-1 col-12 col-md-4" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Login</span>
                                </div>
                                <select class="form-control custom-select" name="captcha_login" id="captcha_login" required>
                                  <option value="0">disable </option>                           
                                  <option value="1">enable </option>                           
                                </select>
                              </div>

                              <div class="input-group mb-1 col-12 col-md-4" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Registration</span>
                                </div>
                                <select class="form-control custom-select" name="captcha_register" id="captcha_register" required>
                                  <option value="0">disable </option>                           
                                  <option value="1">enable </option>                           
                                </select>
                              </div>
                              {{-- <div class="col-12 col-md-3">
                                <input type="checkbox" value="1" name="captcha_login"> 
                                <span class="ml-2">Login form</span>
                              </div>
                              <div class="col-12 col-md-3">
                                <input type="checkbox" value="1" name="captcha_register">
                                <span class="ml-2">Registration form</span>
                              </div> --}}
                            </div>
                            <div class="float-right">
                              <button class="btn btn-success" type="submit">Save</button>
                            </div>
                          </form>
                        </li>
                        <li class="list-group-item">
                          <form action="{{ route('admin.setting.security')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="security_question_id" class="col-md-4 col-form-label text-md-right">{{ __('Choose Security Question') }}</label>
                                <div class="col-md-6">
                                    <select name="security_question_id" class="form-control">
                                        @foreach ($securityQuestions as $question)
                                            <option value="{{ $question->id }}">{{ $question->question }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="security_answer" class="col-md-4 col-form-label text-md-right">{{ __('Answer to that Question') }}</label>
    
                                <div class="col-md-6">
                                    <input id="security_answer" type="text" class="form-control" name="security_answer" required>
                                </div>
                            </div>
    
                            <div class="float-right">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
    
                          </form>
                        </li>
                        <li class="list-group-item">
                          <div>
                            <p>Configure Google two factor authentication</p>
                            <a class="btn btn-outline-primary" href="/admin/2fa">2fa Settings</a>
                          </div>
                      </li>
                      <li class="list-group-item"></li>

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
  $(document).ready(function() {
    $('#captcha_enable').val({{$captcha_enable}});
    $('#captcha_login').val({{$captcha_login}});
    $('#captcha_register').val({{$captcha_register}});
});


</script>
    
@endsection