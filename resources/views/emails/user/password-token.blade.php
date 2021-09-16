@component('mail::message')
# Change Password Token

You have requested to change your password. This is your secret code.
<br/>
<b>{{$user->two_factor_secret}}</b>
<br>
This code expires in 10 minutes.
<br>
Ignore this message if this is not you.

@component('mail::button', ['url' => route('profile.verify.change-password')])
Enter Token
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
