<nav class = " top-nav nav-extended knocks_house_keeper z-depth-5" id = "knocks_main_navbar" style="position: fixed; top:0; z-index : 10000000 !important;">
  <div class="nav-wrapper knocks_nav_content">
    <div class="row">
      <a  data-activates="knocks_sidebar" class="button-collapse knocks_icon_motion"><i class="knocks-navigation3 knocks_text_light  "></i></a>
      <div class = "container">
        <a href="{{asset('')}}" class="brand-logo ">
          <span class = "knocks_text_light">
            <span class = "knocks-knocks"></span>
            <span class = "knocks_text_xs">Knocks</span><span class =  "knocks_responsive_text_xs knocks_text_light_active">App</span>
          </span>
        </a>
      </div>
      @if(auth()->check())
      <a class=" right knocks_rightbar_toggler" @click = "showRightSideBar = !showRightSideBar">
        <i class=" knocks_text_light show-on-small " :class = "[{'knocksapp-direction' : !showRightSideBar} , {'knocksapp-direction2' : showRightSideBar}  ]" ></i>
      </a>
      @endif
    </div>
    <div class="nav-content ">
    </div>
  </div>
</nav>
@if(auth()->check())
@include('layouts.sidebar')
@endif
@if(!auth()->check())
@include('layouts.guestsidebar')
@endif