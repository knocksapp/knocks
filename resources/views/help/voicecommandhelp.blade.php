@extends('layouts.user')
@section('content')
<title>Knocks | Help</title>
<h4 class="ui horizontal divider header transparent knocks_fair_padding">
  <i class="knocks-microphone-3"></i>
<static_message msg = "Record Your Knocks Tips" classes = "knocks_text_ms"  ></static_message>

</h4>
<div class = "row white">
  <div  class = "center knocks_fair_padding">
    <div class = "row">
  <img :src="asset('snaps/voice_command.png')" alt="tips" class = "col s8 push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
  <div class = "knocks_fair_padding">
    <h4>
        <i class="knocks-microphone-3 knocks_text_md "style = " color : #922459;"></i>
  <static_message style = " color : #922459;" msg = "Voice Command" classes = "knocks_text_ms"  ></static_message>

  </h4>

  <h5>  <static_message msg = "What is this?" classes = "knocks_text_ms"  ></static_message></h5>

        <ul class="uk-list uk-list-divider">
          <li><static_message msg = "Knocks Assistant is designed to make your life cicle much easier in the KnocksApp.
          "></static_message></li>
          <li><static_message msg = "You can use it through your voice, or texting in the upper text box.
            "></static_message><static_message msg = " Type what you like and press GO button."></static_message></li>
            <li><static_message msg = "Knocks Assistant can take the most common tasks in the app, such as navigating, creating knocks and many more.
            "></static_message></li>

            </ul>

      <h5>      <static_message msg = "Knock Knock!" classes = "knocks_text_ms"  ></static_message> </h5>

              <li><static_message msg = "Knock Knock is a feature to let call your assistant anytime using your voice.
              "></static_message></li>
              <li><static_message msg = "You can enable Knock Knock by telling your assistant `enable Knock Knock`.
              "></static_message></li>
              <li><static_message msg = "You can also disable it by the same way, just `disable Knock Knock`.
              "></static_message></li>
            </ul>

      <h5>      <static_message msg = "Quick Visiting" classes = "knocks_text_ms"  ></static_message> </h5>

              <li><static_message msg = "If you need to make a quick visit to a freind or someone's home (profile) in general
                you can tell your Knocks Assistant to `visit X profile` or `go to X's home`, Knocks Assistant will search people and find your name,
                if there were many people has the same name he will give options to choose from.
              "></static_message></li>
              <li><static_message msg = "You can even go to your own home, just tell your assistant `go to my own profile`.
              "></static_message></li>
              <li><static_message msg = "Knocks Assistant can take you directly to your setting, just tell him `take me to settings` and its done.
              "></static_message></li>
            </ul>

          <h5>  <static_message msg = "Write a Knock" classes = "knocks_text_ms"  ></static_message></h5>

              <li><static_message msg = "Knocks Assistant helps you to create a Knock, just tell him what content do you want, and there it is!.
              "></static_message></li>
              <li><static_message msg = "If you asked Knocks Assistant to `create a new knock` or `create a new post`, he will ask you back to begin with `i want to say` as a begining and then complete your content normally.
              "></static_message></li>
              <li><static_message msg = "However, if you already know all of this you can start creating your Knock directly saying `i want to say *Your Knock*`.
              "></static_message></li>
            </ul>

        <h5>    <static_message msg = "Logging Out" classes = "knocks_text_ms"  ></static_message> </h5>

              <li><static_message msg = "Quick Logging out can be done through Knocks Assistant in just one word, ne need to fetch hundreds of menus to find where to log out, just tell your assistant `logout` , or `sign out`, he will do it for you in a moment!
              "></static_message></li>

              </ul>

          <h5>    <static_message msg = "Support" classes = "knocks_text_ms"  ></static_message> </h5>

                <li><static_message msg = "Knock Knock voice commands works on PC, it only requires
                  "></static_message>
                  <b class = " red-text">
                  <span class = "knocks-chrome " style="border-color : green"></span>
                  <static_message msg=" Google Chrome" classes = "blue-text"></static_message>
                  </b>
                  <static_message msg = " Browser."></static_message>
                </li>
                <li><static_message msg = "Knock Knock voice commands works on most of PC operating systems, such as
                  "></static_message>
                  <ul class="uk-list uk-list-bullet">
                    <li>
                      <b class = " blue-text">
                      <span class = "knocks-brand286 " ></span>
                      <static_message msg=" Microsoft, Windows" classes = "blue-text"></static_message>
                      </b>
                    </li>
                    <li>
                      <b class = " blue-text">
                      <span class = "knocks-brand9 " ></span>
                      <static_message msg=" Apple, OSX" classes = "grey-text text-darken-1"></static_message>
                      </b>
                    </li>
                    <li>
                      <b class = " ">
                      <span class = "knocks-linux " ></span>
                      <static_message msg="Linux" classes = "black-text"></static_message>
                      </b>
                    </li>
                  </ul>
                  <static_message msg = " However, Knocks Assistant will reply to you with voice on almost all devices."></static_message>
                </li>
              
              </ul>


  </div>
  </div>
</div>
@endsection
