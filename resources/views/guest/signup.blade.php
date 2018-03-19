@extends('layouts.guest')
@section('externals')
<style type="text/css">
.select-dropdown {
color: #fff3cc !important;
}
.bounce-enter-active {
.slide-fade-enter-active {
transition: all .3s ease !important;
}
.slide-fade-leave-active {
transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0) !important;
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
transform: translateX(10px) !important;
opacity: 0 !important;
}
.page-footer, footer {
z-index: -1 !important;
padding-top: 20px !important;
color: #fff !important;
background-color: #ee6e73 !important;
}
/**/
</style>
<link rel = "icon" href = "{{asset('snaps/knocks_tiny.png')}}"/>
<title>Welcome To Knocks</title>
@endsection
@section('content')

<div class = "">
    <div class = "row">
        <div class = "col l6 hide-on-med-and-down">
            <h1 class = "center">
            <span class = "knocks-knocks knocks_text_light"></span>
            <static_message msg = "Welcome To Knocks" classes = "knocks_text_light "></static_message>
            <hr class="uk-divider-icon">
            <static_message msg = "Coming Soon" classes = "knocks_text_light "></static_message>
            </h1>
            <div class = "">
                <transition name="custom-classes-transition" enter-active-class="animated flipInX" leave-active-class="flipOutX">
                    <div class = "row knocks_slideshow_element" v-if = "slideShow == 1">
                        <center>

                        <static_message classes = "animated rubberBand knocks_text_light knocks_text_lg pink-text text-lighten-3" msg="Who's there!"></static_message>
                        </center>
                    </div>
                </transition>
                <transition name="custom-classes-transition" enter-active-class="animated flipInX" leave-active-class="flipOutX">
                    <div class = "row knocks_slideshow_element" v-if = "slideShow == 2">
                        <center>
                        <span class = "animated rotateIn knocks_text_light knocks_text_lg knocks-globe "></span>
                        <static_message classes = "animated rubberBand knocks_text_light knocks_text_lmd" msg="Reimagining The Social Media!"></static_message>
                        <static_message classes = "animated rubberBand knocks_text_light knocks_text_lmd" msg=", Express yourself using your voice or any type of multimedia."></static_message>
                        </center>
                    </div>
                </transition>
                <transition name="custom-classes-transition"enter-active-class="animated flipInX" leave-active-class="flipOutX">
                    <div class = "row knocks_slideshow_element" v-if = "slideShow == 3">
                        <center>
                        <span class = "animated rubberBand knocks_text_light knocks_text_lg knocks-newspaper5 "></span>
                        <static_message classes = "animated rubberBand knocks_text_light knocks_text_lmd" msg="Sharing your long text content is much better, Knocks Provides a features for text editing and many tamplates for poet and articles!"></static_message>
                        </center>
                    </div>
                </transition>
                <transition name="custom-classes-transition" enter-active-class="animated flipInX" leave-active-class="flipOutX">
                    <div class = "row knocks_slideshow_element" v-if = "slideShow == 4">
                        <center>
                        <span class = "animated zoomIn knocks_text_light knocks_text_lg knocks-atom2 "></span>
                        <static_message classes = "animated rubberBand knocks_text_light knocks_text_lmd" msg="Categorize your people into Circles, this could make it much easier to communicate with a lot of people at the same time."></static_message>
                        </center>
                    </div>
                </transition>
                <transition name="custom-classes-transition" enter-active-class="animated flipInX" leave-active-class="flipOutX">
                    <div class = "row knocks_slideshow_element" v-if = "slideShow == 5">
                        <center>
                        <span class = "animated rotateIn knocks_text_light knocks_text_lg knocks-locked4 "></span>
                        <static_message classes = "animated rubberBand knocks_text_light knocks_text_lmd" msg="Because your privacy matters!, You can set your own restrictions on every thing that belongs to you, Customizing your privacy setting is also easy and smart to guess what kind of restrictions you may like."></static_message>
                        </center>
                    </div>
                </transition>
            </div>
        </div>
        <div class = "col l6 s12"  :class = "[{'knocks_left_dashed_border':windowWidth > 800}]">
            <div class  = "">
                <transition  name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
                    <h3 class = "center knocks_text_lmd knocks_language_default_font" v-if = "loginStage == null"><static_message class = "knocks_text_light" msg = "Welcome To Knocks"></static_message></h3>
                </transition>
                <transition  name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
                    <div :class = "[{'animated zoomIn' : loginStage} , {'knocks_hidden' : !loginStage}]">
                        <h2 class = "">
                        <span class = "knocks-knocks knocks_text_light"></span>
                        <static_message msg = "Welcome To Knocks" classes = "knocks_text_light "></static_message>
                        </h2>
                        <h4 class = "knocks_language_default_font knocks_text_lmd knocks_text_light animated slideInDown">
                        <static_message classes ="knocks_text_light" msg = "Please Login, "></static_message>
                        <a @click="triggerStages()" class = "knocks_fair_bounds knocks_pointer teal-text text-accent-4">
                            <static_message classes = "knocks_pointer" msg = "or Create an account."></static_message>
                        </a>
                        </h4>
                        <div class = "row animated slideInUp">


                            <knocksinput
                            placeholder = "Username, Email Or Phone number"
                            gid = "username_login"
                            icon = "knocks-email3"
                            :is_required = "true"
                            :min_len = "5"
                            el_follower
                            :mat_follower=  "false"
                            v-model = "username_login"
                            knocksclass = "knocks_input_ps_light"
                            icon_class = "knocks_text_light"
                            icon_error = "red-text text-lighten-1"
                            error_class = "knocks_input_light_error animated shake"
                            :scope = "['login']"></knocksinput>
                            <knocksinput
                            el_follower
                            :mat_follower=  "false"
                            placeholder = "Password"
                            gid = "password_login"
                            icon = "knocks-locked4 "
                            :is_required = "true"
                            :min_len = "8"
                            v-model = "password_login"
                            type = "password"
                            knocksclass = "knocks_input_ps_light"
                            icon_class = "knocks_text_light"
                            icon_error = "red-text text-lighten-1"
                            error_class = "knocks_input_light_error animated shake"
                            :scope = "['login']"
                            regex_example = "Your password should contain both charachters and numbers."
                            ></knocksinput>
                            <a @click="triggerStages()" class = "knocks_fair_bounds col s12  knocks_pointer teal-text text-accent-4">
                                <static_message msg = "Create an account"></static_message>
                            </a>
                            <knocksbutton
                            placeholder = "Login"
                            icon = ""
                            :materialize_feedback = "false"
                            submit_at = "userlogin"
                            success_at = "done"
                            gid = "knocks_login_button"
                            @knocks_submit_rejected  = "elementCategoryNotify({ type : 'error' , msg : getTranslation('Invalid Data, please make sure you enter the correct data and try again.') , title : getTranslation('Login Error!') })"
                            :error_at = "[{ res : 'failed' , msg : getTranslation('Invalid Data, please make sure you enter the correct data and try again.') }]"
                            @knocks_submit_accepted  = "logInUser()"
                            button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md col s5 "
                            label_classes = "knocks_text_sm"
                            hide_success_msg
                            :scope = "['login']"
                            validation_error = "There're some fields we need you to complete."
                            connection_error = "There's a problem in your connection, please try again."
                            :submit_data = "{ q : username_login ,pw : password_login ,}"></knocksbutton>
                        </div>

                    </div>
                </transition>

                <transition  name="custom-classes-transition"
                    enter-active-class="animated slideInUp "
                    leave-active-class="animated zoomOut">
                    <div :class = "[{'animated zoomIn' : loginStage == false} , {'knocks_hidden' : loginStage != false}]">
                        <h4 class = " knocks_text_lmd animated bounceInDown knocks_language_default_font">
                        <static_message classes ="knocks_text_light" msg = "We're happy to see you in Knocks."></static_message>
                        <a @click="triggerStages()" class = "knocks_fair_bounds knocks_pointer teal-text text-accent-4">
                            <static_message classes = "knocks_pointer" msg = "Already have an account?, Login."></static_message>
                        </a>
                        </h4>
                        <div class = "row animated slideInUp">
                            <!--Stage One-->
                            <div class = "row animated zoomIn" :class = "{ 'knocks_hidden':stageNumber != 1 }">
                                <knocksinput
                                placeholder = "First Name"
                                el_follower
                                :mat_follower=  "false"
                                gid = "first_name"
                                icon = "knocks-grinning-face"
                                :is_required = "true"
                                :max_len = "15"
                                :min_len = "2"
                                v-model = "first_name"
                                knocksclass = "knocks_input_ps_light"
                                icon_class = "knocks_text_light"
                                icon_error = "red-text text-lighten-1"
                                error_class = "knocks_input_light_error animated shake"
                                :scope = "['registeration' ,'stage_one']"
                                :submit_scope = "['stage_one']"
                                ></knocksinput>
                                <knocksinput
                                el_follower
                                :mat_follower=  "false"
                                placeholder = "Middle Name (optional)"
                                gid = "middle_name"
                                icon = "knocks-face-moustache3"
                                :max_len = "15"
                                :is_required = "false"
                                v-model = "middle_name"
                                knocksclass = "knocks_input_ps_light"
                                icon_class = "knocks_text_light"
                                icon_error = "red-text text-lighten-1"
                                error_class = "knocks_input_light_error animated shake"
                                :scope = "['registeration' , 'stage_one']"
                                :submit_scope = "['stage_one']"
                                ></knocksinput>
                                <knocksinput
                                el_follower
                                :mat_follower=  "false"
                                placeholder = "Last Name"
                                gid = "last_name"
                                icon = "knocks-face-moustache"
                                :is_required = "true"
                                :max_len = "15"
                                :min_len = "2"
                                v-model = "last_name"
                                knocksclass = "knocks_input_ps_light"
                                icon_class = "knocks_text_light"
                                icon_error = "red-text text-lighten-1"
                                error_class = "knocks_input_light_error animated shake"
                                :scope = "['registeration' , 'stage_one']"
                                :submit_scope = "['stage_one']"
                                ></knocksinput>
                                <knocksinput
                                el_follower
                                :mat_follower=  "false"
                                placeholder = "Nickname (optional)"
                                gid = "nickname"
                                icon = "knocks-face-sunglasses"
                                :is_required = "false"
                                :max_len = "15"
                                v-model = "nickname"
                                knocksclass = "knocks_input_ps_light"
                                icon_class = "knocks_text_light"
                                icon_error = "red-text text-lighten-1"
                                error_class = "knocks_input_light_error animated shake"
                                :scope = "['registeration' , 'stage_one']"
                                :submit_scope = "['stage_one']"
                                ></knocksinput>
                                <knocksbutton
                                placeholder = "Next"
                                @knocks_stack_passed  = "stageSwitch(2)"

                                :submit_flag = "false"
                                success_at = "done"
                                gid = "stage_one_next"
                                button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md col s5 "
                                :scope = "['stage_one']"
                                label_classes="knocks_text_sm"
                                validation_error = "There're some fields we need you to complete.">
                                </knocksbutton>
                            </div>
                            <!--Stage Two-->
                            <div class = "row animated zoomIn" :class = "{'knocks_hidden' :stageNumber != 2}">

                                <div class="row">
                                    <div class = "col">
                                        <span class = "knocks-birthday-cake knocks_text_light"></span>
                                        <span class = "knocks_text_light ">Birthdate</span>
                                    </div>
                                    <div class = "col ">
                                        <el-date-picker
                                        v-model="birthdate"
                                        type="date"
                                        @input = "birthdateIsFired = true"
                                        placeholder="Pick a day">
                                        </el-date-picker>
                                        <transition enter-active-class = "animated shake" leave-active-class = "animated zoomOut">
                                          <p class = "knocks_text_danger" v-if = "!validDate && birthdateIsFired">
                                            <span class = "knocks-alert-circle"></span>
                                            <static_message msg ="Invalid Birthdate."></static_message>
                                          </p>
                                        </transition>
                                    </div>
                                </div>
                                <div class = "col s4 l3">
                                    <span class = "knocks-male2 knocks_text_light knocks_text_ms"></span>
                                    <span class = "knocks-female2 knocks_text_light knocks_text_ms"></span>
                                    <static_message msg = "Gender" classes = "knocks_text_ms"></static_message>
                                </div>
                                <div class = "col s12 l8 ">
                                <knockstaps :multiple = "false"
                                 v-model="gender"
                                :options = "knocksTapsDevOptions" >
                                  </knockstaps>
                                </div>
                                <br/><br/>
                                <center>

                                <knocksbutton
                                placeholder = "previous"
                                @knocks_button_clicked  = "stageSwitch(1)"
                                :validate = "false"
                                :submit_flag = "false"
                                success_at = "done"
                                gid = "stage_one_next"
                                label_classes = "knocks_text_sm"
                                button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md knocks_fair_bounds col s5"
                                :scope = "['stage_two']"
                                validation_error = "There're some fields we need you to complete.">
                                </knocksbutton>
                                <knocksbutton
                                placeholder = "Next"
                                @knocks_stack_passed  = "stageSwitch(3)"
                                :submit_flag = "false"
                                success_at = "done"
                                gid = "stage_one_next"
                                :precondition = "validDate"
                                label_classes = "knocks_text_sm"
                                button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md knocks_fair_bounds col s5 push-s1"
                                :scope = "['stage_two']"
                                validation_error = "There're some fields we need you to complete.">
                                </knocksbutton>
                                </center>

                            </div>
                            <!--Stage Three-->
                            <div class = "row animated zoomIn" :class = "{ 'knocks_hidden':stageNumber != 3 }">
                                <knocksinput
                                el_follower
                                :mat_follower=  "false"
                                placeholder = "Username"
                                gid = "username"
                                icon = "knocks-user"
                                :is_required = "true"
                                :max_len = "15"
                                :min_len = "6"
                                v-model = "username"
                                :check_live = "true"
                                check_at = "user/check"
                                check_invalid_at = "exist"
                                check_valid_at = "not_exist"
                                regex = "^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$"
                                check_live_prefix_msg = ", This Username is already taken."
                                regex_example = "Your username can't contain a special charachters."
                                knocksclass = "knocks_input_ps_light"
                                icon_class = "knocks_text_light"
                                icon_error = "red-text text-lighten-1"
                                error_class = "knocks_input_light_error animated shake"
                                :scope = "['registeration' , 'stage_three']"
                                :submit_scope = "['stage_three']"
                                ></knocksinput>
                                <knocksinput
                                el_follower
                                :mat_follower=  "false"
                                placeholder = "Email"
                                gid = "email"
                                icon = "knocks-email3"
                                type = "email"
                                :is_required = "true"
                                :min_len = "2"
                                v-model = "email"
                                check_live
                                regex = '^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$'
                                regex_example = "Your email format is not correct, please follow this schema example@foo.bar"
                                check_live_prefix_msg = ", This Email already has an account."
                                check_at = "email/check"
                                check_invalid_at = "exist"
                                check_valid_at = "not_exist"
                                knocksclass = "knocks_input_ps_light"
                                icon_class = "knocks_text_light"
                                icon_error = "red-text text-lighten-1"
                                error_class = "knocks_input_light_error animated shake"
                                :scope = "['registeration' , 'stage_three']"
                                :submit_scope = "['stage_three']"
                                ></knocksinput>
                                <knocksbutton
                                placeholder = "previous"
                                @knocks_button_clicked  = "stageSwitch(2)"
                                :validate = "false"

                                :submit_flag = "false"
                                success_at = "done"
                                gid = "stage_one_next"
                                label_classes = "knocks_text_sm"
                                button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md knocks_fair_bounds col s5"
                                :scope = "['stage_three']"
                                validation_error = "There's some feilds we need you to complete it.">
                                </knocksbutton>
                                <knocksbutton
                                placeholder = "Next"
                                @knocks_stack_passed  = "stageSwitch(4)"

                                :submit_flag = "false"
                                success_at = "done"
                                gid = "stage_one_next"
                                button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md knocks_fair_bounds col s5 push-s1"
                                :scope = "['stage_three']"
                                label_classes = "knocks_text_sm"
                                validation_error = "There're some fields we need you to complete.">
                                </knocksbutton>
                            </div>
                            <!--Stage Four-->
                            <div class = "row animated zoomIn" :class = "{ 'knocks_hidden': stageNumber != 4}">
                                <knocksinput
                                el_follower
                                :mat_follower=  "false"
                                placeholder = "Password"
                                gid = "password"
                                icon = "knocks-locked4 "
                                :is_required = "true"
                                :min_len = "8"
                                v-model = "password"
                                type = "password"
                                knocksclass = "knocks_input_ps_light"
                                icon_class = "knocks_text_light"
                                icon_error = "red-text text-lighten-1"
                                error_class = "knocks_input_light_error animated shake"
                                :scope = "['registeration']"
                                :submit_scope = "['registeration']"
                                regex = "^(?=.*[a-zA-Z])(?=.*[0-9])"
                                regex_example = "Your password should contain both charachters and numbers."
                                ></knocksinput>
                                <el-progress :text-inside="false" :stroke-width="25"
                                :percentage="passwordComplixty.percentage" :status="passwordComplixty.status">
                                </el-progress>
                                <br/>
                                <knocksinput
                                el_follower
                                :mat_follower=  "false"
                                placeholder = "Password Confirmation"
                                gid = "password_confirmation"
                                icon = "knocks-checkmark5"
                                :is_required = "true"
                                :min_len = "8"
                                v-model = "password_confirmation"
                                :same_as = "password"
                                same_as_name = "your password"
                                type = "password"
                                knocksclass = "knocks_input_ps_light"
                                icon_class = "knocks_text_light"
                                icon_error = "red-text text-lighten-1"
                                error_class = "knocks_input_light_error animated shake"
                                :scope = "['registeration']"
                                :submit_scope = "['registeration']"
                                ></knocksinput>
                                <knocksbutton
                                placeholder = "previous"
                                @knocks_button_clicked  = "stageSwitch(3)"
                                :validate = "false"

                                :submit_flag = "false"
                                success_at = "done"
                                label_classes = "knocks_text_sm"
                                gid = "stage_one_next"
                                button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md knocks_fair_bounds col s5"
                                validation_error = "There're some fields we need you to complete.">
                                </knocksbutton>
                                <knocksbutton
                                placeholder = "Register"

                                submit_at = "registeration"
                                success_at = "done"
                                label_classes = "knocks_text_sm"
                                gid = "knocks_registeration_button"
                                :error_at = []
                                button_classes = "waves-effect waves-light btn knocks_btn_light knocks_color_kit_light knocks_text_md knocks_fair_bounds col s5 push-s1"
                                label_classes = ""
                                @knocks_submit_accepted  = "logInUser()"
                                hide_success_msg
                                :scope = "['registeration']"
                                validation_error = "There're some fields we need you to complete."
                                connection_error = "There's a problem in your connection, please try again."
                                :submit_data = "{
                                first_name : first_name ,
                                last_name : last_name ,
                                middle_name : middle_name ,
                                nickname : nickname ,
                                username : username ,
                                email : email ,
                                gender : gender ,
                                birthdate : formateMySqlDate ,
                                password : password ,
                                language : 'en'
                                }"></knocksbutton>
                            </div>
                            <el-steps :active="stageNumber">
                            <el-step title="Enter Your Name"
                            :icon="stageIcon(1,'knocks-face-sunglasses2')"></el-step>
                            <el-step title="More Personal Data" :icon="stageIcon(2,'knocks-face-glasses2')"></el-step>
                            <el-step title="Username And Phone" :icon="stageIcon(3,'knocks-email3')"></el-step>
                            <el-step title="Protect Your Account" :icon="stageIcon(4,'knocks-locked4')"></el-step>
                            </el-steps>

                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
    @endsection