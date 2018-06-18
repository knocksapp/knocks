<!DOCTYPE html>
<html class = "knocks_bg_color_kit">


  <head>
   @include('layouts.acheaders')
   <style>
   @if(!auth()->check())
     main{
      padding-right: 0px !important;
      padding-left: 0px !important;
     }
     @endif
   </style>
    @yield('head_externals')
        <div id="knocks_nav_vue">
          <nav class = " top-nav nav-extended knocks_house_keeper" id = "knocks_main_navbar" style="position: fixed; top:0; z-index : 10000000 !important;">
              <div class="nav-wrapper knocks_nav_content">
                <div class = "container">
                  <!-- <a  data-activates="knocks_sidebar" class="button-collapse knocks_icon_motion"><i class="knocks-navigation3 knocks_text_light  "></i></a> -->
                  <a class=" right" @click = "showRightSideBar = !showRightSideBar"><i class="knocks-more-horizontal knocks_text_light show-on-small" ></i></a>

                  <a href="{{asset('')}}" class="brand-logo">
                    <span class = "knocks_text_light">
                      <span class = "knocks-knocks"></span>
                      <span>Knocks</span>
                    </span>
                  </a>

                </div>
                 <div class="nav-content ">
               </div>



              </div>
              </nav>

          @include('layouts.rightnav')
        </div>
  </head>
  <body>
    <main id = "knocks_main" style= "background-color: #eceff1">
      <div class = "knocks_full_wrapper"></div>
      <div id = "app"  class = "row" style="margin-bottom: 0px;">
        <div class = "knocks_balloons_container" >
        <knocksballon
        v-for = "(ballon , ind) in ballons" :key="ind"
        :gid="'knocks_notification_wall_'+ind"
        v-if = "ballon.poped == 0"
        :constrains = "ballon"
        ></knocksballon>
      </div>


     <div>
       @yield('content')




       </div>
      </div>
    </main>
    @include('layouts.footer')
  </body>


  <script src = "{{asset('js/app.js')}}"></script>
</html>
