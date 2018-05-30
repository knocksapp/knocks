<template>
<div id = "knocks_rightbar"
	:class = '[{"animated slideInRight" : show} ,  {"animated slideOutRight" : !show} ]'
	class = "knocks_house_keeper fixed  grey lighten-5" >
	<knocksretriver
    url = "ballons/batch"
    v-model = "ballonsBatchRetriver"
    :scope = "['knocks_rightbar_ballons_retriver']"
    @success = "handleBallonsRetriving($event)"
    :xdata = "{ min : ballonsRetriverMin}"></knocksretriver>
    <knocksretriver
    url = "ballons/fr/batch"
    v-model = "ballonsBatchRetriverFr"
    :scope = "['knocks_rightbar_ballons_retriver_fr']"
    @success = "handleBallonsRetrivingFr($event)"
    :xdata = "{ min : ballonsRetriverMinFr}"></knocksretriver>
	<div style="height : inherit">
		<div style="height : 5vh" class = "knocks_gray_bottom_border">

			<knockstaps :multiple = "false"
			v-model="tap"
			anchor_class = " col s4 center knocks_gray_hover knocks_tinny_border_radius knocks_tinny_padding "
			left_most_class = ""
			right_most_class = ""
			unlabeled
			@input = "handleTaps()"
			anchor_regular_class=" grey-text text-darken-2 knocks_text_ms "
			anchor_active_class = "blue-text knocks_text_md animated rubberBand grey lighten-4 "
			:options = "
			[
			{ icon : 'knocks-speech-bubble-2' , label : 'Chatting' , static : true , value : 'chat'} ,
			ballonsOption ,
			friendRequestOption ,
			]" >
			</knockstaps>
		</div>
		<div style="height : calc(95vh - 50px)" id = "knocks_rightbar_taps_container">
			<knockschattingzone style = "height : inherit; max-height : calc(95vh - 50px); overflow-y : auto; width : 100% " :class = "[{' knocks_hidden' : tap != 'chat' },{'animated fadeIn' : tap == 'chat' }]"></knockschattingzone>
			<div style = "max-height : calc(95vh - 50px); overflow-y : auto; width : 100%" id = "knocks_rightbar_regballons" :class = "[{'knocks_hidden' : tap != 'ballons' },{'animated fadeIn' : tap == 'ballons' } ]" v-if = "ballons != null">
				<knocksballon
				keep_showing
				container_class = " row  knocks_gray_hover knocks_gray_border knocks_house_keeper"
				v-for = "(ballon , index) in regBallons" :key="index"
				:gid="'knocks_notification_rightbar_'+index"
				mute
        extended
				hide_replies
				@seen = "seenCounter--; seens.push(ballon)"
				v-if = " index < showKeyBallon && ballonsTickedOnce "
				:constrains = "ballon"
				></knocksballon>
				<div class = "row">
					<a :class ="[{'knocks_hidden':!(regBallons.length > showKeyBallon)}]" @click = "showKeyBallon += 3">
						<static_message msg = "See More"></static_message>
					</a>
					<a :class ="[{'knocks_hidden':!(showKeyBallon > 3 && regBallons.length > 3)}]" class = "right" @click = "showKeyBallon -= 3">
						<static_message msg = "See Less"></static_message>
					</a>
				</div>
				<div class = "row animated fadeIn" v-if = "ballonsBatchRetriver.loading">
					<div class="ui active inline loader"></div>
					<static_message msg = "Loading .. " class = "pulse animated infinite"></static_message>
				</div>
				<div class = "row">
						<center v-if = "noOlderBallonsAvailable && regBallons.length > 0">
						<span  class = "grey-text text-darken-2 knocks_text_ms centered">
						<span class = "knocksapp-spook animated jello"></span>
						<static_message msg = "You have no older ballons."></static_message>
					</span>
					</center>
          <center v-if = "noOlderBallonsAvailable && regBallons.length == 0">
            <span  class = "grey-text text-darken-2 knocks_text_ms centered">
            <span class = "knocksapp-spook animated jello"></span>
            <static_message msg = "You have no ballons."></static_message>
          </span>
          </center>
					<button  
					style="margin-bottom : 40px;"
					class="fluid ui button" v-if = "!noOlderBallonsAvailable && regBallons.length <= showKeyBallon" @click = "askForMoreBallons('r')" v-loading = "ballonsBatchRetriver.loading">
						<span class = "knocks-telescope"></span>
				    <static_message class = "" msg = "Load Older Ballons"></static_message>
					</button>
				</div>
			</div>
			<div style = "max-height : calc(95vh - 50px); overflow-y : auto; width : 100%" :class = "[{'knocks_hidden' : tap != 'requests' },{'animated fadeIn' : tap == 'requests' } , 
			{'knocks_ofy' : showKeyFrBallon > 6}]" v-if = "ballons != null">
				<knocksballon
				keep_showing
				container_class = " row  knocks_gray_hover knocks_gray_border knocks_house_keeper"
				v-for = "(ballon , index) in frBallons" :key="index"
				:gid="'knocks_notification_req_rightbar_'+index"
				mute
				@seen = "fqseenCounter-- ;seens.push(ballon)"
				v-if = " index < showKeyFrBallon && requestsTickedOnce "
				:constrains = "ballon"
				></knocksballon>
				<div class = "row">
					<a :class ="[{'knocks_hidden':!(frBallons.length > showKeyFrBallon)}]" @click = "showKeyFrBallon += 3">
						<static_message msg = "See More"></static_message>
					</a>
					<a :class ="[{'knocks_hidden':!(showKeyFrBallon > 3 && frBallons.length > 3)}]" class = "right" @click = "showKeyFrBallon -= 3">
						<static_message msg = "See Less"></static_message>
					</a>
				</div>
				<div class = "row animated fadeIn" v-if = "ballonsBatchRetriverFr.loading">
					<div class="ui active inline loader"></div>
					<static_message msg = "Loading .. " class = "pulse animated infinite"></static_message>
				</div>
				<div class = "row">
					<center v-if = "noOlderBallonsAvailableFr && frBallons.length == 0">
						<span  class = "grey-text text-darken-2 knocks_text_ms centered">
						<span class = "knocksapp-spook animated jello"></span>
						<static_message msg = "You have no friendship requests."></static_message>
					</span>
					</center>
          <center v-if = "noOlderBallonsAvailableFr && frBallons.length > 0">
            <span  class = "grey-text text-darken-2 knocks_text_ms centered">
            <span class = "knocksapp-spook animated jello"></span>
            <static_message msg = "You have no friendship requests."></static_message>
          </span>
          </center>
					<button  
					v-if = "!noOlderBallonsAvailableFr && frBallons.length <= showKeyFrBallon" 
					class="fluid ui button" @click = "askForMoreBallons('f')" v-loading = "ballonsBatchRetriverFr.loading">
					<span class = "knocks-telescope"></span>
				    <static_message class = "" msg = "Load Older Requests"></static_message>
				</button>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>
export default {

  name: 'knocksrightbar',
  props : {
  	show : {
  		type : Boolean , 
  		default : true 
  	}
  },

  data () {
    return {
    	tap : 'chat' , 
    	ballons : [] ,
    	seenCounter : 0 ,
    	showKeyBallon : 3 ,
    	showKeyFrBallon : 3 ,
    	ballonsTickedOnce : false ,
    	requestsTickedOnce : false ,
    	regBallons : [] ,
    	frBallons : [] ,
    	fqseenCounter : 0 ,
    	seens : [] ,
    	noOlderBallonsAvailable : false ,
    	noOlderBallonsAvailableFr : false ,
    	ballonsRetriverMin : null ,
    	ballonsBatchRetriver : { loading : false } ,
    	ballonsRetriverMinFr : null ,
    	ballonsBatchRetriverFr : { loading : false }
    }
  },
  mounted(){
  	const vm = this;
  	App.$on('knocksBallonsUpdate' , (payloads)=>{	
  	    let i ;	  		
  		for( i = 0 ; i <  payloads.patch.length; i++){
  			vm.ballons.splice(0,0,payloads.patch[i]);
  		}
  		vm.handleBallonsStructure();
  	})
  	App.$on('knocksBallonGlobalSeen' , (payloads)=>{
      if(vm.seens.indexOf(payloads.ballon) == -1){
        vm.seens.push(payloads.ballon)
      }
     })
  },
  computed : {
  	ballonsOption(){
  		const vm = this;
  		if(vm.seenCounter <= 0){
  			return  { icon : 'knocks-balloon ' , label : 'Ballons' , static : true , value : 'ballons'} 
  		}else{
  			return { icon : 'knocks-balloon red-text' , label : 'Ballons' , static : true , value : 'ballons' , counter : vm.seenCounter} 
  		}
  	},
  	friendRequestOption(){
  		const vm = this;
  		if(vm.fqseenCounter <= 0){
  			return { icon : 'knocks-user-add-outline ' , label : 'Friendship Requests' , static : true , value : 'requests'} ;
  		}else{
  			return { icon : 'knocks-user-add-outline red-text' , label : 'Friendship Requests' , static : true , value : 'requests' , counter : vm.fqseenCounter} 
  		}
  	}
  },
  methods : {
  	handleTaps(){
  		if(this.tap == 'ballons' && !this.ballonsTickedOnce) this.ballonsTickedOnce = true;
  		if(this.tap == 'requests' && !this.requestsTickedOnce) this.requestsTickedOnce = true;
  	},
  	handleBallonsRetriving(e){
  		let i , len = e.response.length , ids = []; 
  		if(len == 0 ){
  			this.noOlderBallonsAvailable = true;
  			return;
  		} 
  		for(i = 0; i < len ; i++){
  			e.response[i].index = JSON.parse(e.response[i].index);
  			this.ballons.push(e.response[i])
  			ids.push(e.response[i].id)
  		}
  		this.handleBallonsStructure()
  		this.ballonsRetriverMin = Math.min(...ids);
  		this.showKeyBallon += 3
  	},
  	handleBallonsRetrivingFr(e){
  		let i , len = e.response.length , ids = []; 
  		if(len == 0 ){
  			this.noOlderBallonsAvailableFr = true;
  			return;
  		} 
  		for(i = 0; i < len ; i++){
  			e.response[i].index = JSON.parse(e.response[i].index);
  			this.ballons.push(e.response[i])
  			ids.push(e.response[i].id)
  		}
  		this.handleBallonsStructure()
  		this.ballonsRetriverMinFr = Math.min(...ids);
  		this.showKeyFrBallons += 3
  	},
  	handleBallonsStructure(){
  		const vm = this;
  		let temp = vm.ballons;
  		vm.ballons = null;
  		vm.regBallons = [];
  		vm.frBallons = [];
  		let i ;
  		vm.seenCounter = 0;
  		vm.fqseenCounter = 0;
  		vm.ballons = temp;
  		for(i = 0 ; i < vm.ballons.length; i++){
        if(vm.ballons[i].category != 'hidden'){
  			if(vm.ballons[i].index.category != 'friend_request' && vm.ballons[i].index.category != 'friend_request_accepted' ){
  		    if(!vm.isRepeatedBallon(i , vm.ballons)){
  			vm.regBallons.push(vm.ballons[i])
  			if(vm.ballons[i].seen == 0 && vm.seens.indexOf(vm.ballons[i]) == -1){
  				vm.seenCounter++
  			}
  		}
  		}else{
  			if(!vm.isRepeatedBallon(i , vm.ballons)){
  			vm.frBallons.push(vm.ballons[i])
  			if(vm.ballons[i].seen == 0 && vm.seens.indexOf(vm.ballons[i]) == -1){
  				vm.fqseenCounter++
  			}
  		}
  		}
    }
  		}
  		App.$emit('knocks_refresh_posts_done');
  	},
  	isRepeatedBallon(ind , arr){

  		let i ;
  		for(i = 0 ; i < ind; i++){
  			if(arr[i].id == arr[ind].id) return true;
  			if( (arr[i].index.category == arr[ind].index.category) && (arr[i].index.sender_id == arr[ind].index.sender_id) ){
  				if(arr[ind].index.category == 'comment'){
  					if( (arr[i].index.knock == arr[ind].index.knock ) && (arr[i].index.comment == arr[ind].index.comment) ){
  						return true ;
  				}
  			}else if(arr[ind].index.category == 'friend_request'){
  				
  				 return true ;
  			}
  		}
  	}
  	return false;
},
askForMoreBallons(category){
	if(category == 'r'){
this.ballonsBatchRetriver.retrive()
     }
    if(category == 'f'){
   	this.ballonsBatchRetriverFr.retrive()
   }
  }
}
}
</script>

<style lang="css" scoped>
</style>