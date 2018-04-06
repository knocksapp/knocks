<template>

	<div >
		 <el-tooltip class="col knocks_house_keeper" effect="light" content="Delete" placement="bottom">

				 <knockselbutton
         :placeholder = "placeholder"
				 icon = "knocksapp-trash red-text"
					type = "default"
					success_at = "done"
					button_classes = "knocks_borderless"
					label_classes= "red-text"
					:scope = "['delete_'+message]"
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

                       <span v-if="message == 'middlename' || message == 'Middlename' || message == 'middle name' || message == 'Middle name'"> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{userObject.middle_name}}</strong>  from your Informations?</span>

											 <span v-if="message == 'nickname' || message == 'Nickname' || message == 'nick name' || message == 'Nick name'"> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{userObject.nickname}}</strong>  from your Informations?</span>

											 <span v-if="message == 'orientation' || message == 'Orientation' "> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{userObject.orientation}}</strong>  from your Informations?</span>

											 <span v-if="message == 'religon' || message == 'Religon' "> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{userObject.religon}}</strong>  from your Informations?</span>

											 <span v-if="message == 'maritalstatus' || message == 'Maritalstatus' || message == 'marital status' || message == 'Marital status'"> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{userObject.marital_status}}</strong>  from your Informations?</span>

											 <span v-if="message == 'bio' || message == 'Bio' "> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{"Bio"}}</strong>  from your Informations?</span>

											 <span v-if="message == 'phone' || message == 'Phone' "> <span><i style="color : red; font-size : 30px" class="knocks-trash-can3"> </i></span> Are you sure that you want to delete  <strong style="font-size : 20px; color : red;">{{userObject.phone}}</strong>  from your Informations?</span>


                       <span slot="footer" class="dialog-footer">

                        <el-button @click="centerDialogVisible = false">
                          Cancel
                        </el-button>

                       <knockselbutton
                       :error_at = []
                      :scope = "['userinfodelete']"
                      type ="danger"
                      validation_error = "You need to complete some fields"
                      reset_on_success
                      :submit_at = "route+'/delete'"
                      success_at = "done"
                      :success_msg = "message + ' has been Deleted Successfully!'"
                      gid = "stage_one_net"
                      :submit_data = " {userObject : userObject.id} "
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

  name: 'knocksuserinfodelete',
  methods:{
		passToParent(e){

			let ob = e.submit_data ;
			ob.id = e.response;
			this.$emit('knocks_info_deleted' , ob );
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
         userObject : {
         	type : Object,
         	default : null
         },
				 placeholder: {
					 type : String ,
					 default : ''
				 },
         route : {
          type: String,
          required : true
         },
         message : {
          type : String,
          required : true
				},
				 classes : {
					 type : String,
           required : false
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
