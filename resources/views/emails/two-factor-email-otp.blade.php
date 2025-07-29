@component('mail::message')
# Verification Code

Hello {{ $user->name }},

Someone is trying to sign in to your {{ config('app.name') }} account. To complete the sign-in, enter this verification code:

@component('mail::panel')
<div style="font-size: 32px; font-weight: bold; text-align: center; letter-spacing: 8px; color: #1a202c;">
{{ $otp }}
</div>
@endcomponent

**This code will expire in 10 minutes.**

@if($ipAddress)
**Sign-in attempt from:** {{ $ipAddress }}
@endif

@component('mail::button', ['url' => route('login')])
Go to {{ config('app.name') }}
@endcomponent

If you didn't try to sign in, please ignore this email and consider changing your password.

Thanks,<br>
{{ config('app.name') }} Team

---
*This verification code is only valid for 10 minutes. For your security, don't share this code with anyone.*
@endcomponent