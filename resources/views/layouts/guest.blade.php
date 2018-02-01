<!DOCTYPE html>
<html class = "knocks_color_kit">


  <head>
    <meta charset="UTF-8" />
    <div id = "knocks_nav_vue"></div>
    <!--Internet Explorer Comp -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/animate.css')}}">
    <link rel="icon" type="text/css" href="{{asset('snaps/knocks_tiny.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile First -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="user_lang" content = "en"/>
    <meta name="lang_font" content = "titillium"/>
    <meta name="lang_alignment" content = "left"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="-1">
    <meta name="session-type" content="guest">
    <meta name="description" content="Knock, KnocksApp,knocks, knocksapp">
    <meta name="keywords" content="Knocks , KnocksApp , Who's There , Social Media , knocksapp ">
    <meta name="author" content="Knocks App">
    <link rel = "stylesheet" href = {{asset('css/app.css')}}  />
    @yield('externals')
  </head>
  <body class = "knocks_color_kit">

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
