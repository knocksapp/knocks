@component('mail::message')
<title>Verify Your Account</title>
<table>
	<tr>
		<td><img style="width: 50px; height: 50px; display: inline;" src= "https://knocksapp.com/snaps/knocks.png"/></td>
		<td><span style="color : #922459">Welcome to KnocksApp, {{$user->fullName()}}!</span></td>
	</tr>
</table>
@component('mail::panel', [ ])
<p>Thanks for registeration,
We're happy to see you in
<b><a style="text-decoration: none; color : #922459" href= "{{asset('')}}">KnocksApp</a></b></p>
<p>As we're very carefull to protect your privacy,
please verify your account and enjoy our amazing App!</p>
@endcomponent
@component('mail::button', ['url' => asset('user/verify/try/'.$user->api_token) ])
Verify My Account.
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