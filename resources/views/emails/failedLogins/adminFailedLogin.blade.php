@component('mail::message')
# Failed login attempt 

A login attempt was made on an administrators account with this email {{$event->credentials['email']}}

@component('mail::button', ['url' => route('admin.home')])
Log in
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
