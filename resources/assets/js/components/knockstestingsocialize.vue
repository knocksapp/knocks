<template>
<div>
	<knocksretriver
	prevent_on_mount
	url = "dev/db/add/users"
	:xdata = "{ count : 100 }"
	v-model = "ret.users"
	@progress = "prog = 'Creating Users'"
	></knocksretriver>
		<knocksretriver
	prevent_on_mount
	url = "dev/db/entry/users"
	:xdata = "{ count : 100 }"
	v-model = "ret.entery"
	@progress = "prog = 'Adding Random Entery For Users'"
	></knocksretriver>
		<knocksretriver
	prevent_on_mount
	url = "dev/db/chck/members"
	:xdata = "{ count : 100 }"
	v-model = "ret.dubl"
	@progress = "prog = 'Checking Membership Dublications'"
	></knocksretriver>
		<knocksretriver
	prevent_on_mount
	url = "dev/db/add/groups"
	:xdata = "{ count : 100 }"
	v-model = "ret.grps"
	@progress = "prog = 'Creating Groups'"
	></knocksretriver>
		<knocksretriver
	prevent_on_mount
	url = "dev/db/add/circles"
	:xdata = "{ count : 100 }"
	v-model = "ret.crcls"
	@progress = "prog = 'Creating Circles'"
	></knocksretriver>
		<knocksretriver
	prevent_on_mount
	url = "dev/db/add/knocks"
	:xdata = "{ count : 100 }"
	v-model = "ret.knocks"
	@progress = "prog = 'Creating Knocks'"
	></knocksretriver>
		<knocksretriver
	prevent_on_mount
	url = "dev/db/add/comment"
	:xdata = "{ count : 100 }"
	v-model = "ret.cmnt"
	@progress = "prog = 'Creatig Comments'"
	></knocksretriver>
		<knocksretriver
	prevent_on_mount
	url = "dev/db/add/reaction"
	:xdata = "{ count : 10 }"
	v-model = "ret.react"
	@progress = "prog = 'Making Reactions'"
	></knocksretriver>
	<el-button  @click="dialogVisible = true; star()" type = 'primary' icon = "knocks-globe knocks_xs_padding">Socialize</el-button>
	<el-dialog
	:visible.sync="dialogVisible"
	width="90%">
	<div class="knocks_house_keeper row blue">
	</div>
	</el-dialog>
</div>
</template>

<script>
export default {

  name: 'knockstestingsocialize',

  data () {
    return {
    	dialogVisible: false , 
    	prog : null ,
    	ret : {
    		users : null , 
    		entery : null , 
    		dubl : null , 
    		grps : null , 
    		crcls : null , 
    		knocks : null , 
    		cmnt : null , 
    		react : null , 
    	}
    }
  },
  methods : {
  	star(){
  		
  	}
  }
}
</script>

<style lang="css" scoped>
</style>