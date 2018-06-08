@component('mail::message')
<title>Recover Your Account</title>
<h4><span style="color : #922459">Hello, {{$user->fullName()}}!</span></h4>
<p>
	someone has repeatedly tried to access your account ,if that was you and you’ve forgot your password just click
	<b>Set A Temporary Password</b> to use the given password below to access your account temporary, otherwise just click <b>Unblock My Account</b> to restore it.
</p>
<p style="color : red">Your Temporary Password</p>
@component('mail::panel', [ ])
$user->temp_password
@endcomponent
@component('mail::button', ['url' => asset('user/blocked/temp/'.$user->api_token) ])
Set A Temporary Password
@endcomponent
@component('mail::button', ['url' => asset('user/blocked/unblock/'.$user->api_token) ])
Unblock My Account
@endcomponent
Thanks,<br>
<b style="color : #922459">
{{ config('app.name') }}</b>
<span style="color : pink">Who's there!</span>
@endcomponent