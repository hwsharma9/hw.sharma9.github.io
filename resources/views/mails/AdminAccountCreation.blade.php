<p><strong>Dear {{ $user->name }},</strong></p>
<p>Your account has been {{ $user->message }} by Admin-IIFM. Following are the details:</p>
<p>Designation - {{ $user->designation }}</p>
<p>Username - {{ $user->username }}</p>
<p>Password - {{ $password }}</p>
<p>Mobile Number - {{ $user->mobile }}</p>
<p>Please login using below URL:</p>
<a target='_blank' href='{{ route('login') }}'>{{ route('login') }}</a>
<br />
<p><strong>Regards</strong></p>
<p><strong>IIFM Team</strong></p>
