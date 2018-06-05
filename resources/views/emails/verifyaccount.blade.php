@extends('layouts.standard')
@section('externals')
<title>Verify Your Account</title>
@endsection
@section('content')
<div class="container" style="margin-top: 70px !important">
<div class = 'row white knocks_tinny_border_radius knocks_gray_border knocks_fair_bounds'>
	<div class="col s12">
		<h4 class = "blue-grey-text">
		<span class = "knocks-knocks"></span>
		<span msg = "Welcome to KnocksApp"></span>
		</h4>
		<h5 style="font-family: sans-serif !important;">
		<p>Hello {{$user->fullName()}}</p>!
		<p>Thank's for registering in <b><a href = "{{asset('')}}">KnocksApp</a></b>, as we are very carefull to protect your privacy</p>
		<ul class = "blue-grey-text uk-list uk-list-divider">
			<li>
				<p>You have not verify your E-mail Address yet.</p>
			</li>
			<li>
				<p>Press the button below to verify your E-mail please.</p>
			</li>
		</ul>
		</h5>
		<h5 class = "knocks_text_danger center">
		<span msg = "You have not verify your account yet, press the button below to verify it."></span>
		</h5>
	</div>
	<div class="col s12 knocks_tinny_top_margin">
		<h4 class="ui horizontal divider header transparent knocks_tinny_top_margin">

		</h4>
		<a class="fluid ui button basic purple" href = "{{asset('user/verify/try/'.$user->api_token)}}">
			Verify My Account
		</a>
	</div>
</div>
</div>
@endsection


