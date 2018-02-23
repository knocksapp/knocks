<template>
	<div>

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
        title="Sport Edit"
        :visible.sync="dialogVisible"
        center>
  <div class="col s12 l4">
	 	<knockselinput
        el_follower
        :mat_follower=  "false"
        placeholder = "sport ?"
				is_required
        gid = "q"
        :max_len = "15"
        v-model = "name_e"
        :scope = "[ 'sport_edit']"
        :start_as="sportObject.name"

        ></knockselinput>
</div>
<el-tooltip class="item" effect="light" content="Edit" placement="bottom">
        <knockselbutton
        placeholder = "Done!"
        :error_at = []
        :scope = "[ 'sport_edit']"
        validation_error = "You need to complete some fields"

        submit_at = "sport/update"
        computed_response
        success_msg = "Sport is Updated Successfully"
        gid = "stage_one_net"
        :submit_data = " {sport_id : sport_id, name : name_e} "
        button_classes = "right"
        @knocks_submit_accepted = "passToParent($event)"
        >
        </knockselbutton>
			</el-tooltip>
    </el-dialog>
    </div>
</div>


</template>

<script>
export default {

  name: 'knocksusersportedit',
  methods:{
		passToParent(e){

			let ob = e.submit_data ;
			ob.id = e.response;
			this.$emit('knocks_sport_updated' , ob );
			this.dialogVisible=false;
		}
  },
  mounted(){
  	const vm = this
    setTimeout(()=>{

    	vm.name_e = vm.sportObject.name;
    	vm.sport_id= vm.sportObject.id;

    },1000)
  },
  props:{
    sportObject :{
      type : Object ,
      required : true
    }
  },
  data() {
      return {
        name : '',
        sport_id: '',
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
