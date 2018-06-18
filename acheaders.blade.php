  <meta charset="UTF-8" />
  <!--Internet Explorer Comp -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Mobile First -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="user_lang" content = "{{ auth()->check() ? auth()->user()->userLanguage() : 'en'}}"/>
  <meta name="lang_font" content = "{{ auth()->check() ? auth()->user()->userLanguageFont() : 'titillium' }}"/>
  <meta name="lang_alignment" content = "{{ auth()->check() ? auth()->user()->userLanguageAlignment() : 'left' }}"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="pp_index" content="{{ auth()->check() ? auth()->user()->profile_picture : '-1'}}">
  <meta name="user" content="{{auth()->check() ? auth()->user()->id : '-1'}}">
  <meta name="main_circle" content="{{auth()->check() ? auth()->user()->mainCircle()->id : '-1'}}">
  <meta http-equiv="Content-Security-Policy" content="
  default-src * data: blob: ws: wss: gap://ready file://*;
  style-src * 'unsafe-inline';
  script-src * 'unsafe-inline' 'unsafe-eval';
  connect-src * ws: wss:;">
  <?php
if (auth()->check()) {
	auth()->user()->updateToken(csrf_token());
}
?>
  <link rel = "stylesheet" href = {{asset('css/app.css')}}  />
  <meta name="session-type" content="user">
  <audio src = "{{asset('snaps/knocks_notification.mp3')}}" id = "knocks_notification" style = "display : none" controls></audio>
  <audio src = "{{asset('snaps/knocks_recording.mp3')}}" id = "knocks_recording_vid_src" style = "display : none" controls></audio>
  <audio src = "{{asset('snaps/knocks-react.mp3')}}" id = "knocks_disreact_vid_src" style = "display : none" controls></audio>
  <audio src = "{{asset('snaps/knocks-disreact.mp3')}}" id = "knocks_react_vid_src" style = "display : none" controls></audio>
  <link rel="icon" type="text/css" href="{{asset('snaps/knocks.png')}}">
  <style>
  html , body , .knocks_language_default_font{
  font-family : {{ auth()->check() ? auth()->user()->userLanguageFont() : 'titillium' }} ;
  text-align : {{ auth()->check() ? auth()->user()->userLanguageAlignment() : 'left' }} ;
  }
  @media only screen and (min-width : 993px){
  main{
  padding-right: 302px !important;
  padding-left: 300px !important;
  }
  }
  .knocks_language_font{
  font-family : {{ auth()->check() ? auth()->user()->userLanguageFont() : 'titillium' }} ;
  }
  .knocks_language_default_float{
  float : {{ auth()->check() ? auth()->user()->userLanguageAlignment() : 'left'}} ;
  }
  </style>