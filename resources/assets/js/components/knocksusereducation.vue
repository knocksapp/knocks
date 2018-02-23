<template>
    <div class = "row">
  <div class = "row">
    <div class="col s12 l4">
        <knockselinput
        el_follower
        :mat_follower=  "false"
        placeholder = "Study at ?"
                is_required
        gid = "q"
        :max_len = "15"
        v-model = "study_at"
        :scope = "[ 'education_adder']"></knockselinput>
    </div>
    <div class="col s12 l4">
      <knockselinput
      el_follower
      :mat_follower=  "false"
      placeholder = "Study what ?"
      gid = "q"
      :max_len = "15"
      :scope = "[ 'education_adder']"
      v-model = "study_what"
      ></knockselinput>
      </div>
      <div class="col s12 l4">
        <knockselinput
        el_follower
        :mat_follower=  "false"
        placeholder = "Your Grade ?"
        gid = "q"

        :max_len = "15"
        :scope = "[ 'education_adder']"
        v-model = "grade"
        ></knockselinput>
      </div>
    </div>
    <div class = "row">
        <div class="col s12 l4 ">
          <span class="uk-badge knocks_fair_bounds  light-blue lighten-1" style="border-radius : 5px !important">
           <static_message msg = "To"></static_message>
         </span>
            <el-date-picker
            v-model="study_to"
            type="date" class = "knocks_fair_bounds"
            placeholder="Study to ?" >
          </el-date-picker>
              </div>
        <div class="col s12 l4">
         <span class="uk-badge knocks_fair_bounds  light-blue lighten-1" style="border-radius : 5px !important">
           <static_message msg = "Since"></static_message>
         </span>
          <el-date-picker
            v-model="study_since"
            type="date" class = "knocks_fair_bounds"
            placeholder="Study since ?" >
     </el-date-picker>
    </div>
    <div class = "col s12 l4">
      <knockselbutton
    placeholder = "Done!"
    :error_at = []
    :scope = "['education_adder']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "education"
    computed_response
    success_msg = "Mabrok 3alek el Ta3lem"
    gid = "stage_one_net"
    :submit_data = " {study_at : study_at , study_what : study_what, study_since : studySince, study_to : studyTo , grade : grade} "
    :disabled = "!testDate"
        @knocks_submit_accepted = "passToParent($event)">
    </knockselbutton>
    </div>
</div>
</div>
</template>
<script>
export default {
  name: 'knocksusereducation',
  methods:{
        passToParent(e){
            let ob = e.submit_data ;
            ob.id = e.response;
            this.$emit('knocks_education_submited' , ob );
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
        grade : ''
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
