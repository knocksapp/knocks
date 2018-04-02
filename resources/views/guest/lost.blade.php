@extends('layouts.lost')
@section('externals')
<title>Content Was Not Found</title>
@endsection
@section('content')
<div class = "container">
	<h1> <span class="knocks-sun13 knocks_text_lg yellow-text"></span> </h1>
<h2 class = "center">
	<span class="knocks-compass16 knocks_text_lg blue-text"></span>
	<span class="knocks-exclamation knocks_text_lg orange-text"></span>
	<span class = "knocksapp-prick3 knocks_text_md green-text"></span>
</h2>
<h3 class = "center">

<static_message msg = "Whoops! Content Was Not Found!" classes = "knocks_text_dark_active"></static_message>
<br/>
<a href = "{{asset('')}}">
	<static_message msg = "Take me home."></static_message>
</a>
<br/>
<a>
	<static_message msg = "Learn more."></static_message>
</a>


</h3>
</div>


@endsection