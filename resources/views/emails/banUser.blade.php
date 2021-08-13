@component('mail::message')
<h3>Hi, {{ $user->username }}</h3>

<p>{{$error}}</p>

@component('mail::button', ['url' => route('login')])
    Request Review
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
