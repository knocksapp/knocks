@extends('layouts.user')
@section('content')
<!DOCTYPE html>
<html>
<head>
	<title>#<?php echo $trend?></title>
</head>
<body>
	<div class="knocks_tinny_top_padding" style="">
		<div class="row knocks_parent_container lighten-3 z-depth-3" style="width: 90%; background-color : rgba(255, 255, 255, 0.9); padding-top : 15px; border-radius : 15px">
			<h1 class="knocks_fair_bounds blue-text center"><?php echo $trend->hashtag; ?></h1>
			<h3 class="knocks_fair_bounds grey-text center"><i class="knocks-fire orange-text"></i>  <span class="green-text"><?php $s = App\hashtags::where('hashtag', '=', '#' . $trend)->get()->pluck('count');
              $name = (int) str_replace('[', '', $s);
              $name1 = (int) str_replace(']', '', $name);
              echo $name1;
			 ?></span></h3>
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