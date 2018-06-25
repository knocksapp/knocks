@component('mail::message')
<title>Recover Your Account</title>
<h4><span style="color : #922459">Hello, {{$user->fullName()}}!</span></h4>
<p>
	someone has requested a Forgot My Password email ,if that was you and you’ve forgot your password just click
	<b>Set A Temporary Password</b> to use the given password below to access your account temporary, otherwise feel free to ignore this message as there will be nothing changed in your account.
</p>
<p style="color : red">Your Temporary Password</p>
@component('mail::panel', [ ])
{{$user->temp_password}}
@endcomponent
@component('mail::button', ['url' => asset('user/fmp/temp/'.$user->id.'/'.$user->api_token) ])
Set A Temporary Password
@endcomponent
Thanks,<br>
<b style="color : #922459">
{{ config('app.name') }}</b>
<span style="color : pink">Who's there!</span>
@endcomponent