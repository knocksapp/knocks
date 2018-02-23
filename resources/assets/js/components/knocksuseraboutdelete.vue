<template>

	<div >
		 <el-tooltip class="item" effect="light" content="Delete" placement="bottom">
    		<knockselbutton
    		      icon = "knocks-trash-can3 knocks_text_md"
              class = "right knocks_tinny_margin"
              size = "mini"
              disable_placeholder
              type=""
              button_classes = "knocks_rounded_border"
              :submit_flag = "false"
              @knocks_button_clicked="centerDialogVisible = true"
    		 ></knockselbutton>
            		    </el-tooltip>
                      <el-dialog
                       :title="message"
                       center
                       width="50%"
                       :visible.sync="centerDialogVisible"
                       center>

                       <span v-if="message == 'careers' || message == 'Careers' || message == 'career' || message == 'Career'"> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{about_object.works_at}}</strong>  from your Careers?</span>

                       <span v-if="message == 'education' || message == 'Education' || message == 'Educations' || message == 'educations'"> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{about_object.study_at}}</strong>  from your Educations?</span>

                       <span v-if="message == 'High Education' || message == 'High Educations' || message == 'high education' || message == 'high educations'"> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{about_object.study_at}}</strong>  from your High Educations?</span>

                       <span v-if="message == 'Hobbies' || message == 'hobbies' || message == 'Hobby' || message == 'hobby'"> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{about_object.name}}</strong>  from your Hobbies?</span>

                       <span v-if="message == 'Sport' || message == 'sport' || message == 'sports' || message == 'Sports'"> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{about_object.name}}</strong>  from your Sports?</span>

                       <span slot="footer" class="dialog-footer">

                        <el-button @click="centerDialogVisible = false">
                          Cancel
                        </el-button>

                       <knockselbutton
                       :error_at = []
                      :scope = "['delete']"
                      type ="danger"
                      validation_error = "You need to complete some fields"
                      reset_on_success
                      :submit_at = "route+'/delete'"
                      success_at = "done"
                      :success_msg = "message + ' has been Deleted Successfully!'"
                      gid = "stage_one_net"
                      :submit_data = " {about_id : about_object.id} "
                      @knocks_submit_accepted = "passToParent($event)"
                      placeholder = "Delete"
                      button_classes="right"
                         ></knockselbutton>

                      </span>
        </el-dialog>
	</div>

</template>

<script>
export default {

  name: 'knocksuseraboutdelete',
  methods:{
		passToParent(e){

			let ob = e.submit_data ;
			ob.id = e.response;
			this.$emit('knocks_about_deleted' , ob );
			this.centerDialogVisible = false;
		}
  },
  mounted(){
  },
  data() {
      return {
        centerDialogVisible: false,
      };

        },
        props:{
         about_object : {
         	type : Object,
         	default : null
         },
         route : {
          type: String,
          required : true
         },
         message : {
          type : String,
          required : true
         }
    },
  }
</script>

<style lang="css" >
@media only screen and (max-width : 800px){

.el-dialog--small{
	width: 80% !important;
}
}
</style>
