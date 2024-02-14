@component('mail::message')
    Dear {{ $admin->first_name }}

    The {{ $otp }} is your OTP to verify your {{ $type }}.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
