@extends('layouts.editor')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">2FA Authentication </div>
                <div class="card-body">
                    <p>Enter the pin from the google authenticator app</p>
                    <form action="{{ route('editor.2faVerify') }}" method="post">
                        @csrf
                        <input id="one_time_password" type="password" class="form-control" name="one_time_password" required>
                        <div class="col-md-8 col-12 mt-2">
                            <button type="submit" class="btn btn-success"> Proceed </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection