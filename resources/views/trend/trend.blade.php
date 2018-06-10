@extends('layouts.user')
@section('content')
<!DOCTYPE html>
<html>
	<head>
		<title>{{ $trend->hashtag }}</title>
	</head>
	<body>
		<div class="" style="">
			<knockswatchmywindow v-model = "watchMyWindow"></knockswatchmywindow>
			<div class="row knocks_parent_container lighten-3 z-depth-3 knocks_color_kit_active"
			:class = "[{'row slideInDown' : watchMyWindow.isSmall} , {'col s10 push-s1 knocks_standard_border_radius knocks_mp_top_margin zoomIn' : !watchMyWindow.isSmall}]"
			style="margin-top: -1%;">

				<h1 class="knocks_fair_bounds blue-text center knocks_text_light animated flash">{{ $trend->hashtag }}</h1>
				<h3 class="knocks_fair_bounds grey-text center  animated rubberBand"><i class="knocks-fire orange-text"></i>  <span class="green-text">
					<knocksmeganumber :num = "{{$trend->count}}"></knocksmeganumber>
				</h3>
			</div>
			<div class="col s12 knocks_fair_bounds" style="margin-left: 3% !important; width: 95%; background-color : rgba(255, 255, 255, 0.9); border-radius : 15px">
				<knocksknockinjector class = ""
				as_atimeline
				:current_user = "{{ auth()->check() ? auth()->user()->id : -1 }}"
				newer_retrive = "trend/posts/newer"
				older_retrive = "trend/posts/older"
				basic_retrive = "trend/posts"
				:requsted = "{{$trend->id}}">
				</knocksknockinjector>
			</div>
		</div>

	</body>
</html>
@endsection