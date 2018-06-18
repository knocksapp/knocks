<!DOCTYPE html>
<html class = "knocks_bg_color_kit">
  <head>
 @include('layouts.acheaders')
<div id="knocks_nav_vue">
@include('layouts.usernav')
@if(auth()->check())
@include('layouts.rightnav')
@endif
</div>
@yield('headers')
</head>
<body>
<main id = "knocks_main" style= "background-color: #eceff1">
<div class = "knocks_full_wrapper"></div>
<div id = "app"  class = "row" style="margin-bottom: 0px;">

<!--Notification-->
@if(auth()->check())
 <knocksgroupcreation></knocksgroupcreation>
<div class = "knocks_balloons_container" >

  <knocksvoicecommands></knocksvoicecommands>
  <knocksballon
  show_browser_notification
  :index_timer = "ind"
  v-for = "(ballon , ind) in ballons" :key="ind"
  :gid="'knocks_notification_wall_'+ind"
  v-if = "ballon.index.sender_id != auth"
  :constrains = "ballon"
  ></knocksballon>
</div>
@endif
<div>
  @yield('content')
</div>
</div>
</main>
@include('layouts.footer')
</body>
<script src = "{{asset('js/app.js')}}"></script>
</html>