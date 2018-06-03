<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
@component('mail::message')
<div class = "row left">
	<div class = "col s12 l6">
		<img class = "col s12 left" src = "https://knocksapp.com/snaps/knocks.png"/>
	</div>
</div>
<div class = "row">
	<div class = "col s12 ">
		<h3 class = 'purple-text'>Welcome to KnocksApp, {{$user->first_name}}!</h3>
	</div>
</div>
@component('mail::button', ['url' => 'https://knocksapp.com'])
Start Browsing
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent