<template>
<div :class = "[{'row' : !tiny } , {'row white knocks_gray_border knocks_tinny_border_radius ' : tiny}] ">
  <knocksuser v-model = "authModel" class = "knocks_hidden" :user = 'auth'></knocksuser>
  <div :class="[ { 'col s12 l4' : !tiny} , {'col s12 knocks_xs_padding' : tiny}]">
    <p class = "knocks_text_ms center knocks_text_dark" v-if = "tiny">
      <span class = "knocks-graduate"></span>
      <static_message msg = "Add high education"></static_message>
    </p>
    <knockselinput
    inner_placeholder
    el_follower
    :mat_follower=  "false"
    placeholder = "Study at ?"
    icon = "knocks-bank"
    is_required
    gid = "q"
    :max_len = "100"
    v-model = "study_at"
    :scope = "[ 'higheducation_adder']"
    ></knockselinput>
  </div>
  <div :class="[ { 'col s12 l4' : !tiny} , {'col s12 knocks_xs_padding' : tiny}]">
    <knockselinput
    inner_placeholder
    el_follower
    :mat_follower=  "false"
    placeholder = "Study what ?"
    icon = "knocks-book13"
    gid = "q"
    :max_len = "100"
    :scope = "[ 'higheducation_adder']"
    v-model = "study_what"
    ></knockselinput>
  </div>
  <div :class="[ { 'col s12 l4' : !tiny} , {'col s12 knocks_xs_padding' : tiny}]">
    <knockselinput
    inner_placeholder
    el_follower
    :mat_follower=  "false"
    placeholder = "Your Grade ?"
    gid = "q"
    icon = "knocks-certificate3"
    :max_len = "100"
    :scope = "[ 'higheducation_adder']"
    v-model = "grade"
    ></knockselinput>
  </div>
  <div class = "row">
  <div :class="[ { 'col s12 l4' : !tiny} , {'col s12 knocks_xs_padding' : tiny}]">
    <knockseldatepicker
    v-if = "authModel != null"
    :scope = "[ _uid + 'education_adder']"
    icon = "knocks-calendar7"
    is_required
    :quick = "[
    {msg : 'When i was 18' , margins : { count : 18 , unit : 'y' , from : authModel.birthdate } } ,
    {msg : 'When i was 22' , margins : { count : 22 , unit : 'y' , from : authModel.birthdate } }
    ]"
    :margins = '{ max : { count : 0 , unit : "y" } , min : { from : authModel.birthdate , count : 3 , unit : "y" } }'
    placeholder = "Study Since ?"
    v-model = "study_since"></knockseldatepicker>
  </div>
</div>
  <div :class="[ { 'col s12 l4 block' : !tiny} , {'col s12 knocks_xs_padding' : tiny}]">
    <knockseldatepicker
    v-if = "authModel != null"
    :quick = "[]"
    icon = "knocks-calendar-check-o"
    :scope = "[ _uid + 'education_adder']"
    :margins = '{ max : { count : 0 , unit : "y" } , min : { date : study_since } }'
    placeholder = "Study To ?"
    v-model = "study_to"></knockseldatepicker>
  </div>
  <knockselbutton
  placeholder = "Add"
  type = "primary"
  class = "right"
  :error_at = []
  :scope = "['higheducation_adder']"
  validation_error = "You need to complete some fields"
  reset_on_success
  submit_at = "high_education"
  computed_response
  success_msg = "Added Successfully"
  gid = "stage_one_net"
  :submit_data = " {study_at : study_at , study_what : study_what, study_since : studySince, study_to : studyTo , grade : grade} "
  :disabled = "!testDate"
  @knocks_submit_accepted = "passToParent($event)">
  >
  </knockselbutton>
</div>
</div>
</template>
<script>
export default {
  name: 'knockshigheducation',
  props : {
    tiny : {
      type : Boolean ,
      default : false
    }
  },
  methods:{
        passToParent(e){
            let ob = e.submit_data ;
            ob.id = e.response;
            this.$emit('knocks_high_education_submited' , ob );
        }
  },
  mounted(){
  },
  data() {
      return {
        pickerOptions1: {
          disabledDate(time) {
            return time.getTime() > Date.now();
          },
          shortcuts: [{
            text: 'Today',
            onClick(picker) {
              picker.$emit('pick', new Date());
            }
          }, {
            text: 'Yesterday',
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() - 3600 * 1000 * 24);
              picker.$emit('pick', date);
            }
          }, {
            text: 'A week ago',
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit('pick', date);
            }
          }]
        },
        value1: '',
        value2: '',
        study_at : '',
        study_to : null,
        study_what : '',
        study_since : null,
        grade : '',
        auth : parseInt(UserId) ,
        authModel : null
      };
    },
    computed : {
        studyTo(){
            if(this.study_to == null) return null ;
            return moment(this.study_to).format('YYYY-MM-DD');
        },
        studySince(){
            if(this.study_since == null) return null ;
            return moment(this.study_since).format('YYYY-MM-DD');
        },
        testDate(){
            if(this.studySince == null) return false ;
            if(this.studyTo == null && this.studySince != null) return true;
            if (moment(this.studyTo).diff(moment(this.studySince)) <= 0)
                return false;
            else
                return true;
        }
    }
  }
</script>
<style lang="css" scoped>
</style>
