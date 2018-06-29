<template>
  <div>
     <knocksretriver
  v-model=  "request"
  url = "retrieve/candy_request"
  recursed
   @success = "onSucc()"
  >
  </knocksretriver>
   <knocksretriver
  v-model=  "candy_status"
  url = "retrieve/candy_status"
  recursed
  >
  </knocksretriver>
     <knocksretriver
  v-model=  "candy_records"
  url = "delete/candy_records"
  recursed
  >
  </knocksretriver>
  <knockswatchmywindow v-model = "win" @input = "wi()"></knockswatchmywindow>
  
	<div class="row">
    
		<knocksuser :user="user" v-model="auth" class="knocks_hidden"></knocksuser>
		 <el-tooltip class="item" v-if="auth != null && !auth.kid" effect="light" icon = "knocks-knocks"placement="top" >
       <span slot="content">Candy Session <i> </i> </span>
	<div class="balloon"   >
		<a @click="dialogFormVisible = true;  getLen()">
			<h1 style="padding-top : 20px !important;" class="knocks_fair_bounds">
				<i class="knocks-group-1 white-text" >
				</i>
			</h1>
		</a>
	</div>
	</el-tooltip>
  <div class="row" v-if="auth != null && !auth.kid">
      <p class="knocks_text_md">
        KnocksApp provides you the facility of supervising your Child activies to protect your child from dark web , all you have to do is to Click on this <strong class=" light-blue-text darken-3">Ballon</strong> .
      </p>
      <table class="ui very basic collapsing celled table col s10 knocks_fair_bounds">
  <thead>
    <tr><th class="knocks_text_md"><i class="knocks-child pink-text"></i> Your Kids  </th>
   
  </tr></thead>
  <tbody>

        <knocksshowkeys
        class="knocks_fair_bounds"
              main_container = "col s10 knocks_fair_bounds"
              list_classes = "uk-list uk-list-divider knocks_list_scroll"
              :as_label = "false"
              v-if="candy_status.response != null"
              :show_input = "candy_status.response"
              >
                <div  v-for="(can,index) in candy_records.response" :slot = "index">
                  <div class="right knocks_fair_bounds">
                    <knockscandybutton as_delete :rec_id="can"></knockscandybutton>
                  </div>
                </div>
              </knocksshowkeys>
      
  </tbody>
</table>
  </div>
	<el-tooltip class="item" effect="light"  v-if="auth != null && auth.kid" icon = "knocks-knocks"placement="top" >
    <span slot="content">Candy Session <i> </i> </span>
    
	<div class="balloon1">
		<a @click="dialogFormVisible1 = true; getLen()">
			<h1 style="padding-top : 20px !important;" class="knocks_fair_bounds">
				<i class="knocks-heart red-text" >
				</i>
			</h1>
		</a>
	</div>
	</el-tooltip>
  <div class="row" v-if="auth != null && auth.kid">
      <p class="knocks_text_md">
        You can control on your account but for more safety your account can be supervised by your <i class="knocks-transformers red-text"></i> <strong> Heros</strong> which you verifed , all you have to do is to Click on this <strong class="amber-text">Ballon</strong> .
      </p>
      <div>
        <table class="ui very basic collapsing celled table col s10 knocks_fair_bounds">
  <thead>
    <tr><th class="knocks_text_md"><i class="knocks-transformers red-text"></i> Your Heros  </th>
   
  </tr></thead>
  <tbody>

        <knocksshowkeys
        class="knocks_fair_bounds"
              main_container = "col s10 knocks_fair_bounds"
              list_classes = "uk-list uk-list-divider knocks_list_scroll"
              :as_label = "false"
              v-if="candy_status.response != null"
              :show_input = "candy_status.response"
              >
                <div  v-for="(can,index) in candy_status.response" :slot = "index">
                  <div class="right knocks_fair_bounds knocks_house_keeper">
                    <div class="knocks-eye green-text knocks_text_lmd "></div>
                  </div>
                </div>
              </knocksshowkeys>
      
  </tbody>
</table>

      </div>
  </div>
	<el-dialog  :visible.sync="dialogFormVisible" @close="stagesOut()" v-if = "win" :width=" win.isSmall ? '100%' : '70%' ">
		<span slot="title" class="left"><h3>Candy Session <i class="knocks-group-1"></i></h3></span>
   <div class="row">
   	  <h6>Protect your children from the dark side of social media, take care of them using the parental monitor.</h6>
   </div>
   <div class="row knocks_house_keeper">
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
   	<transition enter-active-class = "animated fadeIn" leave-active-class = "animated fadeOut"  >
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
   	   	      <div class="row knocks_house_keeper">
                <knocksshowkeys
              main_container = "col s10"
              list_classes = "uk-list uk-list-divider knocks_list_scroll"
              :as_label = "false"
              v-if="childs != null"
              :show_input = "childs"
              >
                <div v-for="(child,index) in childs" :slot = "index">
                  <knockscandybutton :to="child" as_request></knockscandybutton>
                </div>
              </knocksshowkeys>
              </div>
   	   	      <div>
   	   	      		
   	   	      </div>
   	   </div>
   	</transition>
    <transition enter-active-class = "animated fadeIn" leave-active-class = "animated fadeOut"  >
       <div class="row" v-if = "Stage3">
             Requests
             <div class="row knocks_house_keeper">
                <knocksshowkeys
              main_container = "col s8"
              list_classes = "uk-list uk-list-divider knocks_list_scroll"
              :as_label = "false"
              v-if="request_req_id != null"
              :show_input = "request_req_id"
              >
                <div v-for="(req,index) in requests" :slot = "index">
                  <knockscandybutton @knocks_candy_request_deleted = "deleteRequest(index)" 
                   
                  :target="req.req_id" :rec_id="req.id" as_accept></knockscandybutton>
                </div>
              </knocksshowkeys>
              </div>
            
              
       </div>
    </transition>
   </div>
  <span slot="footer" class="dialog-footer">
    <el-button @click="dialogFormVisible = false; stagesOut()">Cancel</el-button>
    <el-badge :value="requestLen" class="item" v-if = "Stage1 || Stage2">
     <el-button  type="success" v-if = "Stage1 || Stage2" @click="stages1()">Requests</el-button> 
   </el-badge>
    <el-button type="primary" v-if = "Stage1" icon="knocks-search2" @click="stages()"> Find Your Child</el-button>
  </span>
</el-dialog>

<el-dialog  :visible.sync="dialogFormVisible1" @close="stagesOut()" v-if = "win" :width=" win.isSmall ? '100%' : '70%' " >
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
   	<transition enter-active-class = "animated fadeIn" leave-active-class = "animated fadeOut"  >
   	   <div class="row knocks_house_keeper" v-if = "Stage2">
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
              main_container = "col s8"
              list_classes = "uk-list uk-list-divider knocks_list_scroll"
              :as_label = "false"
              v-if="childs != null"
              :show_input = "childs"
              >
                 <div v-for="(child,index) in childs" :slot = "index">
                  <knockscandybutton :to="child" as_request></knockscandybutton>
                </div>
              </knocksshowkeys>
   	   	    
   	   </div>
   	</transition>
    <transition enter-active-class = "animated fadeIn" leave-active-class = "animated fadeOut"  >
       <div class="row" v-if = "Stage3">
             Requests
             <div class="row knocks_house_keeper">
                <knocksshowkeys
              main_container = "col s8"
              list_classes = "uk-list uk-list-divider knocks_list_scroll"
              :as_label = "false"
              v-if = "request_req_id != null"
              :show_input = "request_req_id"
              >
                <div v-for="(req,index) in requests" :slot = "index">
                  <knockscandybutton @knocks_candy_request_deleted = "deleteRequest(index)" :target="req.req_id" :rec_id="req.id" as_accept></knockscandybutton>
                </div>
              </knocksshowkeys>
              </div>
            
              
       </div>
    </transition>
   </div>
  <span slot="footer" class="dialog-footer" >
    <el-button @click="dialogFormVisible1 = false; stagesOut()">Cancel</el-button>
     <el-badge :value="requestLen" class="item" v-if = "Stage1 || Stage2">
     <el-button  type="success" v-if = "Stage1 || Stage2" @click="stages1()">Requests</el-button> 
   </el-badge>
    <el-button type="primary" v-if = "Stage1" icon="knocks-search2" @click="stages()"> Find Your Parent</el-button>
  </span>
</el-dialog>
	</div>
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
       Stage3 : false,
       test6 : '',
       childs : [],
       auth : null,
       request : null,
       requests : null,
       candy_status : null,
       requestLen : 0,
       req_id : null,
       request_req_id : [] , 
       win : null ,
       candy_records : null
    }
  },
  methods:{
    wi(){
      console.log(this.win)
    },
    getLen(){
        const vm = this
        
          vm.request.retrive();
    },
     updateCandyUser(e)
      {
        this.request_req_id.push(e) ;
        let temp = this.request_req_id;
        this.request_req_id = [];
        setTimeout(()=>{
          this.request_req_id = temp;
        },500);
      },
    onSucc(){
      const vm = this
     let i;
             vm.requestLen = vm.request.response.length;
             vm.requests = vm.request.response;
             if(vm.request != null)
             for(i = 0; i < vm.requestLen; i++)
             {
              if(!vm.request_req_id.includes(vm.request.response[i].req_id))
              vm.request_req_id.push(vm.request.response[i].req_id);
             }
             
   
    },
  	  stages(){
  	  	  const vm = this;
  	  	  vm.Stage1 = false;
  	  	  setTimeout(()=>{
                vm.Stage2 = true;
  	  	  },1000);
  	  },
       stages1(){
          const vm = this;
          vm.Stage1 = false;
          vm.Stage2 = false;
          setTimeout(()=>{
                vm.Stage3 = true;
          },1000);
      },
  	  stagesOut(){
  	  	  const vm = this;
  	  	  vm.Stage2 = false;
          vm.Stage3 = false;
                vm.Stage1 = true;
                vm.request_req_id = [];
  	  	 
  	  },
  	  empty(){
  	  	if(this.test6.length == 0)
  	  		this.childs = [];
  	  },
      deleteRequest(index){
        this.request_req_id.splice(index,1);
      },
      

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