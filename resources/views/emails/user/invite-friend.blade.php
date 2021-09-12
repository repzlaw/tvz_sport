@component('mail::message')
# TVZ Sport Invitation

Hi, i'm inviting you join TVZ Sport.

@component('mail::button', ['url' => route('register')])
Register
@endcomponent

Thanks,<br>
{{$display_name}}
@endcomponent
