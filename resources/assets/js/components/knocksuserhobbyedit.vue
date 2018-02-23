<template>
	<div>
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
        title="Hobby Edit"
        :visible.sync="dialogVisible"
        center>
  <div class="col s12 l4">
	 	<knockselinput
        el_follower
        :mat_follower=  "false"
        placeholder = "hobby ?"
				is_required
        gid = "q"
        :max_len = "15"
        v-model = "name_e"
        :scope = "[ 'hobby_edit']"
        :start_as="hobbyObject.name"

        ></knockselinput>
</div>

        <knockselbutton
        placeholder = "Done!"
        :error_at = []
        :scope = "[ 'hobby_edit']"
        validation_error = "You need to complete some fields"

        submit_at = "hobby/update"
        computed_response
        success_msg = "Hobby is Updated Successfully"
        gid = "stage_one_net"
        :submit_data = " {hobby_id : hobby_id, name : name_e} "
        button_classes = "right"
        @knocks_submit_accepted = "passToParent($event)"
        >
        </knockselbutton>
    </el-dialog>
    </div>
</div>


</template>

<script>
export default {

  name: 'knocksuserhobbyedit',
  methods:{
		passToParent(e){

			let ob = e.submit_data ;
			ob.id = e.response;
			this.$emit('knocks_hobby_updated' , ob );
			this.dialogVisible=false;
		}
  },
  mounted(){
  	const vm = this
    setTimeout(()=>{

    	vm.name_e = vm.hobbyObject.name;
    	vm.hobby_id= vm.hobbyObject.id;

    },1000)
  },
  props:{
    hobbyObject :{
      type : Object ,
      required : true
    }
  },
  data() {
      return {
        name : '',
        hobby_id: '',
        name_e: '',
       dialogVisible: false
      };

    },
    computed : {


    	}

    }

</script>

<style lang="css" scoped>
</style>
