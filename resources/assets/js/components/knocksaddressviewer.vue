<template>
	<span>
		<span class= 'knocksapp-home'></span>
		<static_message v-if = "address.current == 'f'" msg = "Lives in: "></static_message>
		<static_message v-if = "address.current == 't'" msg = "Currently lives in: "></static_message>
		<span v-if = "address.country !== undefined && address.country !== null"> {{countries[address.country].emoji}} 
			<static_message :msg = "countries[address.country].name"></static_message>
		 </span>
		 <span v-if ="address.state !== undefined && address.state !== null"> , {{address.state}}</span>
		 <span v-if ="address.region !== undefined && address.region !== null"> , {{address.region}}</span>
	</span>
</template>

<script>
export default {

  name: 'knocksaddressviewer',
  props : {
  	address : {
  		type : Object , 
  		required : true ,
  	}
  },
  data () {
    return {
    	countries : window.Countries.countries , 
    }
  }
}
</script>

<style lang="css" scoped>
</style>