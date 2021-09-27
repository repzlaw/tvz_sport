@extends('layouts.editor')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">2fa </div>
                <div class="card-body">
                    
                    @if (!$data['user']->passwordSecurity)
                        <p>enable 2fa for your account.</p>
                        <p>Click the generate secret button to generate your code</p>
                        <p>Enter this into Google authenticator app.</p>
                        <form method="POST" action="{{ route('editor.generate2faSecret') }}">
                            @csrf
                            <div class="col-md-8 col-12">
                                <button type="submit" class="btn btn-info"> Generate secret key</button>
                            </div>
                        </form>
                    @else

                        @if (! $data['user']->passwordSecurity->google2fa_enable)
                            <p>Scan this barcode with the google authenticator App</p>
                            <img style="width: 200px" src="data:image/png;base64, <?php echo $data['google2faUrl']; ?> "/>
                            {{-- <img src="{{$data['google2faUrl']}}" alt=""> --}}
                            <form action="{{ route('editor.enable2fa') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input id="verify_code" type="password" class="form-control" name="verify_code" required>
                                </div>
                                <div class="col-md-8 col-12">
                                    <button type="submit" class="btn btn-success"> Enable 2fa</button>
                                </div>
                            </form>
                        @elseif ($data['user']->passwordSecurity->google2fa_enable)
                            <p>2fa is enabled </p>
                            <p>Enter your account password to disable 2fa </p>
                            <form action="{{ route('editor.disable2fa') }}" method="post">
                                @csrf
                                <input id="current_password" type="password" class="form-control" name="current_password" required>
                                <div class="col-md-8 col-12 mt-2">
                                    <button type="submit" class="btn btn-success"> Disable 2fa</button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection