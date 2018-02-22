<template>
    <div class = "row">
    <div class="col s12 l4">
        <knockselinput
        el_follower
        :mat_follower=  "false"
        placeholder = "Works at ?"
                is_required
        gid = "q"
        :max_len = "15"
        v-model = "works_at"
        :scope = "[ 'career_adder']"
        ></knockselinput>
    </div>
    <div class="col s12 l4">
                <knockselinput
                el_follower
                :mat_follower=  "false"
                placeholder = "Major ?"
                gid = "q"

                :max_len = "15"
                :scope = "[ 'career_adder']"
                v-model = "works_what"
                ></knockselinput>
            </div>
                <div class="col s12 l4 block">
                <knockselinput
                el_follower
                :mat_follower=  "false"
                placeholder = "Works as ?"
                gid = "q"
                :max_len = "15"
                :scope = "[ 'career_adder']"
                v-model = "works_as"
                ></knockselinput>
            </div>
                <div class="col s12 l4 block">
                    <span class="uk-badge knocks_fair_bounds  light-blue lighten-1" style="border-radius : 5px !important">
           <static_message msg = "To"></static_message>
         </span>
                    <el-date-picker
                    v-model="works_to"
                    type="date"
                    placeholder="Works to ?" >
                </el-date-picker>
            </div>
               <div class="col s12 l4">
                   <span class="uk-badge knocks_fair_bounds  light-blue lighten-1" style="border-radius : 5px !important">
           <static_message msg = "Since"></static_message>
         </span>
    <el-date-picker
      v-model="works_since"
      type="date"
      placeholder="Works since ?"
  >
    </el-date-picker>
</div>
    <knockselbutton
    placeholder = "Done!"
    :error_at = []
    :scope = "['career_adder']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "career"
    computed_response
    success_msg = "Mabrok 3alek el shoghlana"
    gid = "stage_one_net"
    :submit_data = " {works_at : works_at , works_since : worksSince, works_to : worksTo , works_what : works_what , works_as : works_as} "
    :disabled = "!testDate"
        @knocks_submit_accepted = "passToParent($event)"
    >
    </knockselbutton>
</div>
     </div>
</template>
<script>
export default {
  name: 'knocksusercareers',
  methods:{
        passToParent(e){
            let ob = e.submit_data ;
            ob.id = e.response;
            this.$emit('knocks_career_submited' , ob );
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
        works_at : '',
        works_to : null,
        works_what : '',
        works_as : '',
        works_since : null
      };
    },
    computed : {
        worksTo(){
            if(this.works_to == null) return null ;
            return moment(this.works_to).format('YYYY-MM-DD');
        },
        worksSince(){
            if(this.works_since == null) return null ;
            return moment(this.works_since).format('YYYY-MM-DD');
        },
        testDate(){
            if(this.worksSince == null) return false ;
            if(this.worksTo == null && this.worksSince != null) return true;
            if (moment(this.worksTo).diff(moment(this.worksSince)) <= 0)
                return false;
            else
                return true;
        }
    }
  }
</script>
<style lang="css" scoped>
</style>
