<template>

	<div class = "row">
<el-tooltip class="item" effect="light" content="Edit" placement="bottom">
		<knockselbutton
		 icon = "knocks-pencil8 knocks_text_md"
         class = "right knocks_tinny_margin"
         size = "mini"
         disable_placeholder
         type=""
         button_classes = "knocks_rounded_border"
		 @knocks_button_clicked="dialogVisible = true"
		 :submit_flag = "false"
		 ></knockselbutton>
	 </el-tooltip>
<div class = "row">
    <el-dialog
      title="Career Edit"
      :visible.sync="dialogVisible"
      center>

	<div class="col s12 l4">
	 	<knockselinput
        el_follower
        :mat_follower=  "false"
				:start_as="careerObject.works_at"
        placeholder = "Work at ?"
				is_required
        gid = "q"
        :max_len = "100"
        v-model = "work_at_e"
        :scope = "[ 'career_edit']"

        ></knockselinput>
    </div>
    <div class="col s12 l4">

                <knockselinput
                el_follower
                :mat_follower=  "false"
                placeholder = "Major ?"
								:start_as="careerObject.works_what"
                gid = "q"

                :max_len = "100"
                :scope = "[ 'career_edit']"
                v-model = "work_what_e"
                ></knockselinput>
            </div>

            <div class="col s12 l4">

                <knockselinput
                el_follower
                :mat_follower=  "false"
                placeholder = "Work as ?"
								:start_as="careerObject.works_as"
                gid = "q"

                :max_len = "100"
                :scope = "[ 'career_edit']"
                v-model = "work_as_e"
                ></knockselinput>
            </div>


<div class="row">

               <div class="col s12 l4">
                  <span class="uk-badge knocks_fair_bounds  light-blue lighten-1" style="border-radius : 5px !important">
           <static_message msg = "Since"></static_message>
         </span>
    <el-date-picker
      v-model="work_since_e"
      type="date"
      placeholder="Work since ?"
  >
    </el-date-picker>
</div>

<div class="col s12 l4 block">
		<span class="uk-badge knocks_fair_bounds  light-blue lighten-1" style="border-radius : 5px !important">
<static_message msg = "To"></static_message>
</span>
	<el-date-picker
	v-model="work_to_e"
	type="date"
	placeholder="Work to ?" >
</el-date-picker>
</div>
<knockselbutton
placeholder = "Done!"
:error_at = "[{res : 'not_found' , msg : 'This data is invalid'}]"
:scope = "[ 'career_edit']"
validation_error = "You need to complete some fields"
submit_at = "career/update"
success_at = "done"
success_msg = "Career is Updated Successfully"
gid = "stage_one_net"
:submit_data = " {career_id : career_id,works_at : work_at_e , works_since : workSince_e , works_to : workTo_e , works_what : work_what_e , works_as : work_as_e} "
:disabled = "!testDate"
button_classes = "right"
@knocks_submit_accepted = "passToParent($event)"
>
</knockselbutton>
</div>
</el-dialog>
</div>
     </div>

</template>

<script>
export default {

  name: 'knockscareeredit',
  methods:{
		passToParent(e){

			let ob = e.submit_data ;
			ob.id = e.submit_data.career_id;
			this.$emit('knocks_career_updated' , ob );
			this.dialogVisible=false;
		}
  },
	props:{

		careerObject : {
			type : Object ,
			required : true
		}



	},
  mounted(){
const vm = this ;
setTimeout(()=>{
	vm.work_since_e = vm.careerObject.works_since;
	vm.work_to_e = vm.careerObject.works_to;
	vm.work_at_e = vm.careerObject.workSince_e_at;
	vm.work_what_e = vm.careerObject.works_what;
	vm.work_as_e = vm.careerObject.works_as;
	vm.career_id= vm.careerObject.id;


},1000)
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
        work_at_e : '',
        work_to_e : null,
        work_what_e : '',
        work_since_e : null,
        work_as_e : '',
				career_id : '',
        dialogVisible: false,
      };

    },
    computed : {
    	workTo_e(){
    		if(this.work_to_e == null) return null ;
    		return moment(this.work_to_e).format('YYYY-MM-DD');
    	},
        workSince_e(){
    		if(this.work_since_e == null) return null ;
    		return moment(this.work_since_e).format('YYYY-MM-DD');
    	},
    	testDate(){
    		if(this.work_since_e == null) return false ;
    		if(this.work_to_e == null && this.work_since_e != null) return true;

    		if (moment(this.work_to_e).diff(moment(this.work_since_e)) <= 0)
    			return false;
    		else
    			return true;

    	}


    }
  }
</script>

<style lang="css" scoped>
</style>
