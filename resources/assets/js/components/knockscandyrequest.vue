<template>
	<div class="row">
		<knocksuser :user="user" v-model="auth" class="knocks_hidden"></knocksuser>
		 <el-tooltip class="item" v-if="auth != null && !auth.kid" effect="light" icon = "knocks-knocks"placement="top" >
       <span slot="content">Candy Session <i> </i> </span>
	<div class="balloon" >
		<a @click="dialogFormVisible = true">
			<h1 style="padding-top : 20px !important;" class="knocks_fair_bounds">
				<i class="knocks-group-1 white-text" >
				</i>
			</h1>
		</a>
	</div>
	</el-tooltip>
	<el-tooltip class="item" effect="light"  v-if="auth != null && auth.kid" icon = "knocks-knocks"placement="top" >
    <span slot="content">Candy Session <i> </i> </span>
    <el-badge :value="12" class="item">
    
	<div class="balloon1" >
		<a @click="dialogFormVisible1 = true">
			<h1 style="padding-top : 20px !important;" class="knocks_fair_bounds">
				<i class="knocks-heart red-text" >
				</i>
			</h1>
		</a>
	</div>
</el-badge>
	</el-tooltip>
	<el-dialog  :visible.sync="dialogFormVisible" width="100%">
		<span slot="title" class="left"><h3>Candy Session <i class="knocks-group-1"></i></h3></span>
   <div class="row">
   	  <h6>Protect your children from the dark side of social media, take care of them using the parental monitor.</h6>
   </div>
   <div class="container">
   	<transition enter-active-class = "animated fadeIn" leave-active-class = "animated fadeOut" >
   	   <div class="row" v-if = "Stage1">
   	   	   <div class="col s2">
   	   	   	 <h1>
   	   	   	<i class="knocks-man-woman left"></i>
   	   	   </h1>
   	   	   	 </div>
   	   	   	 <h1 class="col s8 ui horizontal divider" style="background-color : transparent !important;">
   	   	   	 	<h1 class="infinite animated pulse">
					  <i class="knocks-knocks-circle-fill"></i>
					</h1>
					</h1>
   	   	   	 <div class="col s2">
   	   	   	 	<h1>
   	   	   	<i class="knocks-child right"></i>
   	   	   </h1>
   	   	   </div>
   	   </div>
   	</transition>
   	<transition enter-active-class = "animated fadeIn" leave-active-class = "animated fadeOut" >
   	   <div class="row" v-if = "Stage2">
   	   	     Search

   	   	      <knockselinput
   	   	      v-model="test6"
   	   	      autocomplete
   	   	      autocomplete_from="child/search"
   	   	      @autocomplete="childs = $event"
   	   	      @input = "empty()"
   	   	      placeholder = "Find Your Child"
   	   	      icon = "knocks-search2"
   	   	      inner_placeholder
   	   	      >
   	   	      </knockselinput>
   	   	      <knocksshowkeys
   	   	      as_result

   	   	      :as_label = "false"
              :show_input = "childs"
   	   	      ></knocksshowkeys>
   	   	      <div>
   	   	      		
   	   	      </div>
   	   </div>
   	</transition>
   </div>
  <span slot="footer" class="dialog-footer">
    <el-button @click="dialogFormVisible = false; stagesOut()">Cancel</el-button>
    <el-button type="primary" v-if = "Stage1" icon="knocks-search2" @click="stages()"> Find Your Child</el-button>
  </span>
</el-dialog>

<el-dialog  :visible.sync="dialogFormVisible1" width="100%">
		<span slot="title" class="left"><h3>Candy Session <i class="knocks-group-1"></i></h3></span>
   <div class="row">
   	  <h6>Protect yourself from the dark side of social media, take care and use the parental monitor.</h6>
   </div>
   <div class="container">
   	<transition enter-active-class = "animated fadeIn" leave-active-class = "animated fadeOut" >
   	   <div class="row" v-if = "Stage1">
   	   	   <div class="col s2">
   	   	   	 <h1>
   	   	   	<i class="knocks-man-woman left"></i>
   	   	   </h1>
   	   	   	 </div>
   	   	   	 <h1 class="col s8 ui horizontal divider" style="background-color : transparent !important;">
   	   	   	 	<h1 class="infinite animated pulse">
					  <i class="knocks-knocks-circle-fill"></i>
					</h1>
					</h1>
   	   	   	 <div class="col s2">
   	   	   	 	<h1>
   	   	   	<i class="knocks-child right"></i>
   	   	   </h1>
   	   	   </div>
   	   </div>
   	</transition>
   	<transition enter-active-class = "animated fadeIn" leave-active-class = "animated fadeOut" >
   	   <div class="row" v-if = "Stage2">
   	   	     Search

   	   	      <knockselinput
   	   	      v-model="test6"
   	   	      autocomplete
   	   	      autocomplete_from="parent/search"
   	   	      @autocomplete="childs = $event"
   	   	      @input = "empty()"
   	   	      placeholder = "Find Your Parent"
   	   	      icon = "knocks-search2"
   	   	      inner_placeholder
   	   	      >
   	   	      </knockselinput>
   	   	      <knocksshowkeys
   	   	      as_result
   	   	      :as_label = "false"
              :show_input = "childs"
   	   	      ></knocksshowkeys>
   	   	      <div>
   	   	      		
   	   	      </div>
   	   </div>
   	</transition>
   </div>
  <span slot="footer" class="dialog-footer">
    <el-button @click="dialogFormVisible1 = false; stagesOut()">Cancel</el-button>
    <el-button type="primary" v-if = "Stage1" icon="knocks-search2" @click="stages()"> Find Your Parent</el-button>
  </span>
</el-dialog>
	</div>
</template>

<script>
export default {

  name: 'knockscandyrequest',

  data () {
    return {
       dialogFormVisible : false,
       dialogFormVisible1 : false,
       user : parseInt(UserId),
       Stage1 : true,
       Stage2 : false,
       test6 : '',
       childs : [],
       auth : null
    }
  },
  methods:{
  	  stages(){
  	  	  const vm = this;
  	  	  vm.Stage1 = false;
  	  	  setTimeout(()=>{
                vm.Stage2 = true;
  	  	  },1000);
  	  },
  	  stagesOut(){
  	  	  const vm = this;
  	  	  vm.Stage2 = false;
                vm.Stage1 = true;
  	  	 
  	  },
  	  empty(){
  	  	if(this.test6.length == 0)
  	  		this.childs = [];
  	  }
  	 


  }
}
</script>

<style lang="css" scoped>
.row { margin:20px; text-align:center; }

.balloon {
  display:inline-block;
   width:80px;
  height:105px;
  background-color : #0091ea;
  border-radius:80%;
  position:relative;
  box-shadow:inset -10px -10px 0 rgba(0,0,0,0.07);
  margin:20px 30px;
  transition:transform 0.5s ease;
  z-index:10;
  animation:balloons 4s ease-in-out infinite;
  transform-origin:bottom center;
}
.balloon1 {
  display:inline-block;
   width:80px;
  height:105px;
  background-color : #ffff00;
  border-radius:80%;
  position:relative;
  box-shadow:inset -10px -10px 0 rgba(0,0,0,0.07);
  margin:20px 30px;
  transition:transform 0.5s ease;
  z-index:10;
  animation:balloons 4s ease-in-out infinite;
  transform-origin:bottom center;
}
@keyframes balloons {
  0%,100%{ transform:translateY(0) rotate(-4deg); }
  50%{ transform:translateY(-25px) rotate(4deg); }
}


.balloon:before {
  content:"▲";
  font-size:20px;
  color:#0091ea;
  display:block;
  text-align:center;
  width:100%;
  position:absolute;
  bottom:-12px;
  z-index:-100;
}
.balloon1:before {
  content:"▲";
  font-size:20px;
  color:#ebed01;
  display:block;
  text-align:center;
  width:100%;
  position:absolute;
  bottom:-12px;
  z-index:-100;
}



.balloon:nth-child(2){  animation-duration:3.5s; }
.balloon:nth-child(2):before {   }

.balloon:nth-child(3){  animation-duration:3s; }
.balloon:nth-child(3):before {  }

.balloon:nth-child(4){ animation-duration:4.5s; }
.balloon:nth-child(4):before {   }

.balloon:nth-child(5){  animation-duration:5s; }
.balloon:nth-child(5):before {   }


.balloon1:nth-child(2){  animation-duration:3.5s; }
.balloon1:nth-child(2):before {   }

.balloon1:nth-child(3){ animation-duration:3s; }
.balloon1:nth-child(3):before {   }

.balloon1:nth-child(4){  animation-duration:4.5s; }
.balloon1:nth-child(4):before {  }

.balloon1:nth-child(5){  animation-duration:5s; }
.balloon1:nth-child(5):before {   }


</style>