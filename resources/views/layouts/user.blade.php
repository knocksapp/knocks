<!DOCTYPE html>
<html class = "knocks_bg_color_kit">
  <head  prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
 @include('layouts.acheaders')
<div id="knocks_nav_vue">
@include('layouts.usernav')
@if(auth()->check())
@include('layouts.rightnav')
@endif
</div>
@yield('headers')
  <!--Social Scripts-->
  <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1796023703741381',
      xfbml      : true,
      version    : 'v2.12'
    });

    FB.AppEvents.logPageView();

  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "http://www.knocksapp.com",
  "name": "Knocks.",
  "logo":  "https://knocksapp.com/ssnaps/knocks_logo.png" ,
  "legalName" : "Knocks, INC",
   "foundingDate": "2017",
    "founders": [
 {
 "@type": "Person",
 "name": "M.Amr Moussa"
 },
 {
 "@type": "Person",
 "name": "Hesham Ahmed"
 } ,
 {
 "@type": "Person",
 "name": "Salma Roshdy"
 } ,
 {
 "@type": "Person",
 "name": "Khaled Ashraf"
 }
 ]
}
</script>
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