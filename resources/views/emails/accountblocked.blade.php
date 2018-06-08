@component('mail::message')
<title>Recover Your Account</title>
<h4><span style="color : #922459">Hello, {{$user->fullName()}}!</span></h4>
<p>
	Someone has repeatedly tried to access your account.<br/>
	If that was you and you’ve forgot your password, just click
	<b>Set A Temporary Password</b>, and use the given password below to access your account.<br/>
	Otherwise just click <b>Unblock My Account</b> to restore it.<br/>
	<span style="color : red">It's recommended to change your password in both cases.</span>
</p>
<p style="color : red">Your Temporary Password</p>
@component('mail::panel', [ ])
{{$user->temp_password}}
@endcomponent
@component('mail::button', ['url' => asset('user/blocked/temp/'.$user->id.'/'.$user->api_token) ])
Set A Temporary Password
@endcomponent
@component('mail::button', ['url' => asset('user/blocked/unblock/'.$user->id.'/'.$user->api_token) ])
Unblock My Account
@endcomponent
Thanks,<br>
<b style="color : #922459">
{{ config('app.name') }}</b>
<span style="color : pink">Who's there!</span>
@endcomponent