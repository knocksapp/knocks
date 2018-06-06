<!DOCTYPE html>
<html class = "">
  <head  prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <!--OG TAGS-->
    <meta property="fb:app_id" content="1796023703741381" />
    <meta property="og:type"   content="website" />
    <meta property="og:url"    content="{{Request::url()}}" />
    <meta property="og:title"  content="Knocks" />
    <meta property="og:image"  content="https://knocksapp.com/snaps/knocks_logo.png" />
    <meta property="og:description" content="Knocks, Reimagining the social media.">
    <meta property="og:site_name" content="Knocks, Inc.">
    <!--Google-->
    <meta name="google-site-verification" content="tsUIFUH4rGfxzV0M-SOdbUhgUTrwisWXmhNZpda_pVk" />
    <meta name="robots" content="follow"/>
    <meta charset="UTF-8" />
    <meta name="title" content="Knocks">
    <meta name="author" content="Knocks Development Team">
    <meta name="publisher" content="Knocks, INC">
    <meta name="copyright" content="Knocks 2017">
    <meta name="description" content="Knocks, Reimagining The Social Media">
    <meta name="abstract" content="Knocks, Reimagining The Social Media">
    <meta http-equiv="content-language" content="en">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="robots" content="index,follow">
    <meta name="DC.Language" content="en">
    <meta name="keywords" lang="en" content="knocks">
    <meta name="keywords" lang="en" content="knocksapp">
    <meta name="keywords" lang="en" content="register">
    <meta name="keywords" lang="en" content="signin">
    <meta name="keywords" lang="en" content="login">
    <meta name="keywords" lang="en" content="survey">
    <meta name="keywords" lang="en" content="social media">
    <meta name="keywords" lang="en" content="social">
    <meta name="keywords" lang="en" content="media">
    <meta name="keywords" lang="en" content="analysis">
    <meta name="keywords" lang="en" content="statistics">
    <div id = "knocks_nav_vue">
      @include('layouts.emailnav')
    </div>
    <link rel="alternate" href="{{Request::url()}}" hreflang="en" />
    <!--Internet Explorer Comp -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/animate.css')}}">
    <link rel="icon" type="text/css" href="{{asset('snaps/knocks_tiny.png')}}">
    <link rel="shortcut icon" type="text/css" href="{{asset('snaps/knocks_tiny.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile First -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="user_lang" content = "en"/>
    <meta name="lang_font" content = "titillium"/>
    <meta name="lang_alignment" content = "left"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="-1">
    <meta name="session-type" content="guest">
    <meta name="keywords" content="Knocks,KnocksApp,Who's There,Social Media,social media,social,knocksapp,knocks,survey,Survey,survey,Survey,answers,knocksapp,KnocksApp,knocksapp.com">
    <meta name="author" content="KnocksApp">
    <link rel = "stylesheet" href = {{asset('css/app.css')}}  />

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


    @yield('externals')
  </head>
  <body class = "">
    <main style="padding-left:0px !important; padding-right: 0px !important; ">
      <div id = "app">
        <div>
          @yield('content')
        </div>
      </div>
    </main>
  </body>
  @include('layouts.footer_dark')

  <script src = "{{asset('js/app.js')}}"></script>
</html>