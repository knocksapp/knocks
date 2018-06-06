@component('mail::message')
<title>Welcome To KnocksApp</title>

<h4><span style="color : #922459">Welcome to KnocksApp, {{$user->fullName()}}!</span></h4>
@component('mail::panel', [ ])
Thanks for registeration,
We're happy to see you in
<p><b><a style="text-decoration: none; color : #922459" href= "{{asset('')}}">KnocksApp</a></b></p>.
<p>As we're very carefull to protect your privacy,
please verify your account and enjoy our amazing App!</p>
<p>If you didn't ask for a verification E-mail yet, press the button below and you will recieve another E-mail to verify your account.</p>
@endcomponent
@component('mail::button', ['url' => asset('user/offer/verify') ])
Ask for Verification E-mail
@endcomponent
<p style="background-color: #f7f7f7; border-radius: 5px; padding:12px; color :#e57373">
	If you didn't register for KnocksApp, then most probably someone else did it, however, feel free to ignore this message,
	<b><a style="text-decoration: none; color : #922459" href= "{{asset('')}}">KnocksApp</a></b> doesn't allow
unverified accounts to make any activities!</p>
Thanks,<br>
<b style="color : #922459">
{{ config('app.name') }}</b>
<span style="color : pink">Who's there!</span>
@endcomponent