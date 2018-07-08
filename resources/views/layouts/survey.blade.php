<!DOCTYPE html>
<html>
  <head  prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
<meta name="auth_mod" content="{{auth()->check() ? json_encode(auth()->user()->retriveForUser( auth()->user()->id ) ): '{}'}}">
  <meta property="fb:app_id" content="1796023703741381" />
  <meta property="og:type"   content="website" />
  <meta property="og:url"    content="https://knocksapp.com/faq/survey/Analysis" />
  <meta property="og:title"  content="Knocks" />
  <meta property="og:image"  content="https://knocksapp.com/snaps/knocks_logo.png" />
  <meta charset="UTF-8" />
  <link rel="alternate" href="{{Request::url()}}" hreflang="en" />
  <meta name="description" content="Knocks Survey, See what do poeple think about Social Networking.">
  <meta name="keywords" content="Knocks , KnocksApp , Who's There , Social Media , social media , social, knocksapp , knocks , survey , Survey , survey , Survey , answers ">
  <meta name="author" content="KnocksApp">
  <meta name="google-site-verification" content="tsUIFUH4rGfxzV0M-SOdbUhgUTrwisWXmhNZpda_pVk" />
    <!--Internet Explorer Comp -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile First -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="user_lang" content = "en"/>
    <meta name="lang_font" content = "titllium"/>
    <meta name="lang_alignment" content = "left"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="Knocks">
    <meta property="og:description" content="Knocks Survey Analysis, See what do people think about Social Networking.">


    <meta property="og:site_name" content="Knocks, Inc.">
    <meta name="twitter:title" content="Knocks">

    <meta name="twitter:description" content=" Knocks Survey Analysis, See what do people think about Social Networking.">
    <meta name="twitter:image" content="{{asset('snaps/knocks.png')}}">
    <meta name="twitter:card" content="knocks">
    @if(Auth::check())
    <meta name="pp_index" content="{{ auth()->user()->profile_picture }}">
    <meta name="user" content="{{auth()->user()->id}}">
    <meta name="main_circle" content="{{auth()->user()->mainCircle()->id}}">
    <meta name="session-type" content="user">
    @endif
    @if(!Auth::check())
    <meta name="session-type" content="guest">
    <meta name="user" content="-1">
    <meta name="main_circle" content="-1">
    @endif
    <link rel="icon" type="text/css" href="{{asset('snaps/knocks.png')}}">
    <link rel="shortcut icon" type="text/css" href="{{asset('snaps/knocks.png')}}">
    <link rel = "stylesheet" href = {{asset('css/app.css')}}  />
    @include('layouts.surveynav')
    @yield('externals')
    <meta name="session-type" content="guest">

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
    <main id = "knocks_main">
      <div class = "knocks_full_wrapper"></div>
      <div id = "app"  class = "row">
        <div>
          @yield('content')
        </div>
      </div>
    </main>
    @include('layouts.footer')
  </body>
  @yield('tail')
  <script src = "{{asset('js/app.js')}}"></script>
</html>