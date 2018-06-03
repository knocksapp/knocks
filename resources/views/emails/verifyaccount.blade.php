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
		<ul class = "blue-grey-text uk-list uk-list-divider">
			<li>

				<span class = "animated rubberBand  " >Reimagining The Social Media!</span>
				<span class = "animated rubberBand  " >, Express yourself using your voice or any type of multimedia."></span>
			</li>
			<li>

				<span class = "animated rubberBand  " >Sharing your long text content is much better, Knocks Provides a features for text editing and many tamplates for poet and articles!</span>
			</li>
			<li>

				<span class = "animated rubberBand  " >Categorize your people into Circles, this could make it much easier to communicate with a lot of people at the same time.</span>
			</li>
			<li>

				<span class = "animated rubberBand" >Because your privacy matters!, You can set your own restrictions on every thing that belongs to you, Customizing your privacy setting is also easy and smart to guess what kind of restrictions you may like.</span>
			</li>
		</ul>
		</h5>
		<h5 class = "knocks_text_danger center">
		<span msg = "You have not verify your account yet, press the button below to verify it."></span>
		</h5>
	</div>
	<div class="col s12 knocks_tinny_top_margin">
		<h4 class="ui horizontal divider header transparent knocks_tinny_top_margin">
		<i class="check icon knocks_text_md grey-text"></i>

		</h4>
		<a class="fluid ui button basic purple" href = "{{asset('user/verify/try/'.$user->api_token)}}">
			Verify My Account
		</a>
	</div>
</div>
</div>
@endsection


