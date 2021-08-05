@component('mail::message')
<h3>Hi, {{ $user->username }}</h3>

<p>{{$message}}</p>

@component('mail::button', ['url' => route('login')])
    Log-in to account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
