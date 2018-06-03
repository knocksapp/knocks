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
		<static_message msg = "Welcome to KnocksApp"></static_message>
		</h4>
		<h5>
		<ul class = "blue-grey-text uk-list uk-list-divider">
			<li>
				<span class = "animated rotateIn knocks-globe"></span>
				<static_message classes = "animated rubberBand  " msg="Reimagining The Social Media!"></static_message>
				<static_message classes = "animated rubberBand  " msg=", Express yourself using your voice or any type of multimedia."></static_message>
			</li>
			<li>
				<span class = "animated rubberBand knocks-newspaper5 "></span>
				<static_message classes = "animated rubberBand  " msg="Sharing your long text content is much better, Knocks Provides a features for text editing and many tamplates for poet and articles!"></static_message>
			</li>
			<li>
				<span class = "animated zoomIn knocks-atom2 "></span>
				<static_message classes = "animated rubberBand  " msg="Categorize your people into Circles, this could make it much easier to communicate with a lot of people at the same time."></static_message>
			</li>
			<li>
				<span class = "animated rotateIn knocks-locked4 "></span>
				<static_message classes = "animated rubberBand" msg="Because your privacy matters!, You can set your own restrictions on every thing that belongs to you, Customizing your privacy setting is also easy and smart to guess what kind of restrictions you may like."></static_message>
			</li>
		</ul>
		</h5>
		<h5 class = "knocks_text_danger center">
		<static_message msg = "You have not verify your account yet, press the button below to verify it."></static_message>
		</h5>
	</div>
	<div class="col s12 knocks_tinny_top_margin">
		<h4 class="ui horizontal divider header transparent knocks_tinny_top_margin">
		<span class = "knocks-mailbox knocks_text_md grey-text"></span>

		</h4>
		<a class="fluid ui button basic purple" href = "{{asset('user/verify/try/'.$user->api_token)}}">
			Verify My Account
		</a>
	</div>
</div>
</div>
@endsection


