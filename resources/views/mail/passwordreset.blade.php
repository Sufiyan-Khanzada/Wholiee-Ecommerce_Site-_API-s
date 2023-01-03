@component('mail::message')

You have Requested for password reset.
Your OTP is {{$otp}}


Thanks {{$user}} for using our app<br>
{{ config('app.name') }}
@endcomponent
