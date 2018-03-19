<var></var><footer class="page-footer knocks_color_kit knocks_footer" id = "footer" style="z-index: 1 !important">
         <div class="container">
           <div class="row">
             <div class="col l5 s12">
               <span class="knocks_text_md">
                    <span class = "knocks-knocks knocks_text_light_active"></span>
                    <span class = "knocks_text_light_active"> Knocks</span>
               </span>
               <static_message msg = "Who's there" classes = "center knocks_text_sm knocks_text_pink"  :align='false' ></static_message>
             </div>
             <div class="col l4 offset-l2 s12">
               <h5 class="knocks_color_kit">



               </h5>
               <ul class = "knocks_color_kit ">
                @if(!auth()->check())
                <li><a href = "{{asset('user/login')}}">Login</a></li>
                <li><a href = "{{asset('user/register')}}">Create an account</a></li>
                @endif
               </ul>
             </div>
           </div>
         </div>
         <div class="footer-copyright knocks_color_kit">
           <div class="container">
            <div class = "row">

              <div class = "col s6 knocks_text_light_active  ">
                © 2017 Copyright Knocks, inc.
              </div>
              <div class = "col s6">
              <static_message msg = "All rights reserved" :align = 'false' classes = "knocks_text_center knocks_text_light_active"></static_message>
              </div>

            </div>


         </div>
           </div>
         </div>
       </footer>
