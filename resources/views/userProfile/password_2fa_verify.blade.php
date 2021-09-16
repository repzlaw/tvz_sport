@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Two Factor Password Verification') }}</div>
                    @if(count($errors)>0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('message'))
                        <div class="alert alert-danger alert-dismissible fade show mt-2 ml-2">
                            {{ session('message') }}
                        </div>
                    @endif
                    <span class="text-muted" style="padding: 10px">
                        An email has been sent to <b>{{Auth::user()->email}}</b> which contains your secret code. <br>
                        <a href="{{ route('profile.token.resend') }}" class="">Resend token</a>
                    </span>
                    <div class="card-body">
                        
                        <form method="POST" action="{{route('profile.password-token.confirm')}}">
                            @csrf
                            <div class="form-group ">
                                <div class="input-group mb-3 col-12 col-md-8" >
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> Two Factor Code</span>
                                    </div>
                                    <input id="code" placeholder="enter code" type="number" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}"  autocomplete="code" autofocus required>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Verify</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection