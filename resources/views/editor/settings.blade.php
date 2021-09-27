@extends('layouts.editor')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Settings') }}</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <form action="{{ route('editor.setting.save')}}" method="post">
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
                                <a class="btn btn-outline-primary" href="/editor/2fa">2fa Settings</a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
