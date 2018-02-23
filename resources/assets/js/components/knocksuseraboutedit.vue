<template>
	<div class = "row">
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
<div class = "row">
    <el-dialog
      title="High Education Edit"
      :visible.sync="dialogVisible"
      center
			>

	<div class="col s12 l4">
	 	<knockselinput
        el_follower
        :mat_follower=  "false"
				:start_as="highEducationObject.study_at"
        placeholder = "Study at ?"
				is_required
        gid = "q"
        :max_len = "15"
        v-model = "study_at_e"
        :scope = "[ 'higheducation_edit']"

        ></knockselinput>
    </div>
    <div class="col s12 l4">

                <knockselinput
                el_follower
                :mat_follower=  "false"
                placeholder = "Study what ?"
								:start_as="highEducationObject.study_what"
                gid = "q"

                :max_len = "15"
                :scope = "[ 'higheducation_edit']"
                v-model = "study_what_e"
                ></knockselinput>
            </div>

            <div class="col s12 l4">

                <knockselinput
                el_follower
                :mat_follower=  "false"
                placeholder = "Your Grade ?"
								:start_as="highEducationObject.grade"
                gid = "q"
                
                :max_len = "15"
                :scope = "[ 'higheducation_edit']"
                v-model = "grade_e"
                ></knockselinput>
            </div>


<div class="row">
                <div class="col s12 col l4" >
									<div>
                    <span class="  uk-badge knocks_fair_bounds  light-blue lighten-1 col" style="border-radius : 5px !important">
           <static_message msg = "To" classes = ""></static_message>
         </span>
			 </div>
				 <div class=" ">
	                <el-date-picker

	                v-model="study_to_e"
	                type="date"
	                placeholder="Study to ?" >
                </el-date-picker>
							</div>
							</div>

               <div class="col s12 l4" >
                  <span class="uk-badge knocks_fair_bounds  light-blue lighten-1 col" style="border-radius : 5px !important">
           <static_message msg = "Since"></static_message>
         </span>
    <el-date-picker
      v-model="study_since_e"
      type="date"
      placeholder="Study since ?"
  >
    </el-date-picker>
</div>
<div class = "col s12 l4">
	<knockselbutton
	placeholder = "Done!"
	:error_at = []
	:scope = "[ 'higheducation_edit']"
	validation_error = "You need to complete some fields"
	reset_on_success
	submit_at = "high_education/update"
	computed_response
	success_at = "done"
	success_msg = "High Education is Updated Successfully"
	gid = "stage_one_net"
	:submit_data = " {higheducation_id : higheducation_id,study_at : study_at_e , study_since : study_since_e , study_to : study_to_e , study_what : study_what_e , grade : grade_e} "
	:disabled = "!testDate"
	button_classes = "right"
	@knocks_submit_accepted = "passToParent($event)"
	>
	</knockselbutton>
</div>
</div>
</el-dialog>
</div>
     </div>

</template>

<script>
export default {

  name: 'knockshigheducation',
  methods:{
		passToParent(e){

      let ob = e.submit_data ;
      ob.id = e.response;
      this.$emit('knocks_high_education_updated' , ob );
			this.dialogVisible=false;
    }
  },
	props:{

		highEducationObject : {
			type : Object ,
			required : true
		}



	},
  mounted(){
const vm = this ;
setTimeout(()=>{
	vm.study_since_e = vm.highEducationObject.study_since;
	vm.study_to_e = vm.highEducationObject.study_to;
	vm.study_at_e = vm.highEducationObject.study_at;
	vm.study_what_e = vm.highEducationObject.study_what;
	vm.grade_e = vm.highEducationObject.grade;
	vm.higheducation_id= vm.highEducationObject.id;


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
        study_at_e : '',
        study_to_e : null,
        study_what_e : '',
        study_since_e : null,
        grade_e : '',
				higheducation_id : '',
        dialogVisible: false,
      };

    },
    computed : {
    	studyTo_e(){
    		if(this.study_to_e == null) return null ;
    		return moment(this.study_to_e).format('YYYY-MM-DD');
    	},
        studySince_e(){
    		if(this.study_since_e == null) return null ;
    		return moment(this.study_since_e).format('YYYY-MM-DD');
    	},
    	testDate(){
    		if(this.studySince_e == null) return false ;
    		if(this.studyTo_e == null && this.studySince_e != null) return true;

    		if (moment(this.studyTo_e).diff(moment(this.studySince_e)) <= 0)
    			return false;
    		else
    			return true;

    	}


    }
  }
</script>

<style lang="css" scoped>

</style>
