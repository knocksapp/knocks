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
<title>Welcome To KnocksApp</title>
@endsection
@section('content')
<div class = "">
    <div class = "row">
        <div class = "col l6 hide-on-med-and-down">
            <h1 class = "center">
            <span class = "knocks-knocks knocks_text_light"></span>
            <static_message msg = "Welcome To KnocksApp" classes = "knocks_text_light "></static_message>
            </h1>
            <div class = "">
                <knockswelcomeslider></knockswelcomeslider>
            </div>
        </div>
        <div class = "col l6 s12"  :class = "[{'knocks_left_dashed_border':windowWidth > 800}]">
            <div class  = "">
                <transition  name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
                    <h3 class = "center knocks_text_lmd knocks_language_default_font" v-if = "loginStage == null">
                    <static_message class = "knocks_text_light" msg = "Welcome To KnocksApp"></static_message>
                    <img class = "col s8 push-s2 animated rotateIn" src = "{{asset('snaps/knocks_circle.png')}}" style="margin-top : 20px;" />
                    </h3>
                </transition>
                <transition  name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
                    <div :class = "[{'animated zoomIn' : loginStage} , {'knocks_hidden' : !loginStage}]">
                        <h2 class = "">
                        <span class = "knocks-knocks knocks_text_light"></span>
                        <static_message msg = "Welcome To KnocksApp" classes = "knocks_text_light "></static_message>
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
                            handle_autofill
                            :mat_follower=  "false"
                            v-model = "username_login"
                            knocksclass = "knocks_input_ps_light"
                            icon_class = "knocks_text_light"
                            icon_error = "red-text text-accent-1"
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
                            handle_autofill
                            v-model = "password_login"
                            type = "password"
                            knocksclass = "knocks_input_ps_light"
                            icon_class = "knocks_text_light"
                            icon_error = "red-text text-accent-1"
                            error_class = "knocks_input_light_error animated shake"
                            :scope = "['login']"
                            regex_example = "Your password should contain both charachters and numbers."
                            ></knocksinput>
                            <a @click="triggerStages()" class = "knocks_fair_bounds col s12  knocks_pointer teal-text text-accent-4">
                                <static_message msg = "Create an account"></static_message>
                            </a>
                            <knocksforgotmypassword></knocksforgotmypassword>
                            <knocksbutton
                            placeholder = "Login"
                            icon = ""
                            :materialize_feedback = "false"
                            submit_at = "userlogin"
                            success_at = "done"
                            gid = "knocks_login_button"
                            @knocks_submit_rejected = "handleRejectedLogins($event)"
                            :error_at = "[
                            { res : 'failed' , msg : 'Invalid Data, please make sure you enter the correct data and try again.' } ,
                            { res : 'blocked' , msg : 'Your account is blocked, please check your mail to recover your account.' }
                            ]"
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
                                icon_error = "red-text text-accent-1"
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
                                icon_error = "red-text text-accent-1"
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
                                icon_error = "red-text text-accent-1"
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
                                icon_error = "red-text text-accent-1"
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
                                    <div class = "col s12">
                                        <knockseldatepicker
                                        :default_time = "{ date : '1995-06-15' }"
                                        :quick = "[]"
                                        is_required
                                        icon = "knocks-birthday-cake"
                                        :margins = '{ max : { count : -5 , unit : "y" }  }'
                                        placeholder = "Birthdate"
                                        :scope = "['stage_two' , 'registeration']"
                                        v-model = "birthdate"></knockseldatepicker>
                                        <transition enter-active-class = "animated shake" leave-active-class = "animated zoomOut">
                                            <p class = "knocks_text_danger" v-if = "!validDate && birthdateIsFired">
                                                <span class = "knocks-alert-circle"></span>
                                                <static_message msg ="Invalid Birthdate."></static_message>
                                            </p>
                                        </transition>
                                    </div>
                                </div>
                                <div class = "col s4 l3">
                                    <span class = "knocks-controller-record knocks_text_light knocks_text_ms"></span>
                                    <static_message msg = "Gender" classes = "knocks_text_ms"></static_message>
                                </div>
                                <div class = "col s12  ">
                                    <knockselselect
                                    start_as = "Male"
                                    :feeds="[
                                    { label : 'Male' , value : 'Male' , icon : 'knocks-male2' } ,
                                    { label : 'Female' , value : 'Female' , icon : 'knocks-female2' } ,
                                    { label : 'Mercury' , value : 'Mercury' , icon : 'knocks-mercury' } ,
                                    { label : 'Intersex' , value : 'Intersex' , icon : 'knocks-intersex' } ,
                                    { label : 'Transgender (Non-binary)' , value : 'Transgender' , icon : 'knocks-transgender-alt' } ,
                                    { label : 'Mars Stroke (Androgyny)' , value : 'Marse Stroke' , icon : 'knocks-mars-stroke' } ,
                                    { label : 'Marse Stroke Vertical' , value : 'Marse Stroke Vertical' , icon : 'knocks-mars-stroke-v' } ,
                                    { label : 'Marse Stroke Horizontal' , value : 'Marse Stroke Horizontal' , icon : 'knocks-mars-stroke-h' } ,
                                    { label : 'Neuter' , value : 'Neuter' , icon : 'knocks-neuter' } ,
                                    { label : 'Genderless' , value : 'Genderless' , icon : 'knocks-genderless' } ,
                                    ]"
                                    v-model = "gender"
                                    is_required
                                    icon = "knocks-controller-record"
                                    :error_mixins = "[{ key : 'is_required' , mixin : { msg : 'This field is required.' , icon : 'knocks-alert-circle' } }]"
                                    general_icon = "knocks-tag-add"
                                    placeholder = "Gender"
                                    :scope = "['stage_two' , 'registeration']"></knockselselect>
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
                                icon_error = "red-text text-accent-1"
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
                                icon_error = "red-text text-accent-1"
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
                                icon_error = "red-text text-accent-1"
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
                                icon_error = "red-text text-accent-1"
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