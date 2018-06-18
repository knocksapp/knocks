<ul id = "knocks_sidebar" class = "side-nav fixed knocks_house_keeper grey lighten-5" >
  <div class="force-overflow"></div>
  <li id = "sidebar_head"><div class="user-view ">
    <div class="background">
      <img src="{{asset('snaps/cover.png')}}" class = "">
    </div>
    <a >
      <img src="{{asset('snaps/avatar.jpg')}}" class = "circle" />
    </a>
    <a><span class="white-text name">
      Guest
    </span></a>
  </div></li>
  <div id = "sidebar_search">
    <div class = "row" >
      @include('layouts.sidesearch')
            </div>
          </div>
          <div id = "sidebar_contents" :class = "{'animated slideOutUp' : sidebarSearchFocus}">
            <div class = "row">
              <ul id = "knocks_sidebar_list" class = "l10 push-l1 s10 push-l1" style="margin-bottom: 100px">

                <knockstrendslist></knockstrendslist>

              </ul>
            </div>
          </div>

        </ul>

        <!-- sidebar -->