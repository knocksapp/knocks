<template>
	<div>
    <static_message :msg = "placeholder" class = "knocks_hidden" v-model = "placeholderTrans"></static_message>
  <el-input :placeholder="placeholderTrans" v-model="circleName" @input  = "inSearchScope" class="input-with-select">
    		<knockselbutton 
    		slot="append" 
				disable_placeholder
				:disabled = "disabled"
				icon = "knocks-plus5"
				submit_at = "create/circles"
				success_at = "done"	
				@knocks_submit_accepted = "refreshCircles()"
				reset_on_success			
				:error_at = "[{ res : 'already_exists' , msg : 'You already have this circle!' }]"
				:success_msg= " 'Added to your Circles succesfully!'"
				:scope = "['add_circle']"
				validation_error = "There's some feilds we need you to complete it."
				connection_error = "There's a problem in your connection, please try again."
				:submit_data = "{ name : circleName ,icon: '' }">
				</knockselbutton>
  </el-input>
</div>

</template>

<script>
export default {

  name: 'knocksquickaddcircle',
  props :{
    placeholder : {
      type : String , 
      default : 'Add or Search for a circle'
    }
  },
  data () {
    return {
    	circleName : '' ,
      placeholderTrans : ''

    }
  },
  mounted(){
  	this.inSearchScope();
  	const vm = this;
  	App.$on('KnocksGlogbalCirclesList' , ()=>{
      vm.inSearchScope();
    });
  },
  computed : {
  	alreadyExists(){
  		let cir;
  		for (cir in UserCircles){
  			if(this.circleName == UserCircles[cir].name)
  				return true;
  		} return false;
  	},
  	typed(){
  		return this.circleName == '' ?  false : true;
  	},
  	disabled(){
  		return this.typed && !this.alreadyExists ? false : true;
  	}

  },
  methods : {
    refreshCircles(){
  		App.$emit('knocksRequestCirclesRefresh');
      this.circleName = '';
  	},
  	inSearchScope(){
  		let counter = 0;
  		let cir;
  		let array = [];
  		for(cir in UserCircles){
  			if(UserCircles[cir].name.toLowerCase().includes(this.circleName.toLowerCase()) && UserCircles[cir].id != UserMainCircle){
  				array.push(parseInt(cir));
  			}
  		}
  		this.$emit('input' , array);
  		App.$emit('KnocksContentChanged');

  	}
  	
  }
}
</script>

<style lang="css" scoped>
</style>