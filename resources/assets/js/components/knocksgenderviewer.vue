<template>
	<div :class = "classes">
		<span :class = "getGender().icon"></span>
		<static_message :msg = "getGender().label"></static_message>
	</div>
</template>

<script>
export default {

  name: 'knocksgenderviewer',
  props : { 
  	gender : {
  		type : String , 
  		required : true ,
  	},
  	classes  : {
  		type : [Array , Object , String] , 
  		default : ''
  	}
  },
  data () {
    return {
		feeds :[
				{ label : 'Male' , value : 'Male' , icon : 'knocks-male2' } ,
				{ label : 'Female' , value : 'Female' , icon : 'knocks-female2' } ,
				{ label : 'Mercury' , value : 'Mercury' , icon : 'knocks-mercury' } ,
				{ label : 'Intersex' , value : 'Intersex' , icon : 'knocks-intersex' } ,
				{ label : 'Transgender (Non-binary)' , value : 'Transgender' , icon : 'knocks-transgender-alt' } ,
				{ label : 'Mars Stroke (Androgyny)' , value : 'Marse Stroke' , icon : 'knocks-mars-stroke' } ,
				{ label : 'Marse Stroke Vertical' , value : 'Marse Stroke Vertical' , icon : 'knocks-mars-stroke-v' } ,
				{ label : 'Marse Stroke Horizontal' , value : 'Marse Stroke Horizontal' , icon : 'knocks-mars-stroke-h' } ,
				{ label : 'Neuter' , value : 'Neuter' , icon : 'knocks-neuter' } ,
				{ label : 'Genderless' , value : 'Genderless' , icon : 'knocks-genderless' } ,
			],
    }
  },
  methods : {
  	getGender(){
  		let i 
  		for(i = 0 ; i < this.feeds.length; i++){
  			if(this.gender == this.feeds[i].value)
  				return { icon : this.feeds[i].icon , label : this.feeds[i].label }
  		}
  		return {icon : 'knocks-user4' , label : this.gender}
  	}
  }
}
</script>

<style lang="css" scoped>
</style>