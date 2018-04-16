<template>
<div id = "knocks_rightbar"
	:class = '[{"animated slideInRight" : show} ,  {"animated slideOutRight" : !show} ]'
	class = "knocks_house_keeper fixed  grey lighten-5" >
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
			<knockschattingzone style = "height : inherit;overflow-y: auto;" :class = "[{' knocks_hidden' : tap != 'chat' },{'animated fadeIn' : tap == 'chat' }]"></knockschattingzone>
			<div style = "height : inherit;" :class = "[{'knocks_hidden' : tap != 'ballons' },{'animated fadeIn' : tap == 'ballons' } , {'knocks_ofy' : showKeyBallon > 2}]">
				<knocksballon
				keep_showing
				container_class = " row knocks_tinny_border_radius knocks_gray_hover knocks_gray_border knocks_house_keeper"
				v-for = "(ballon , index) in regBallons" :key="index"
				:gid="'knocks_notification_rightbar_'+index"
				mute
				@seen = "seenCounter--"
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
			</div>
			<div style = "height : inherit;" :class = "[{'knocks_hidden' : tap != 'requests' },{'animated fadeIn' : tap == 'requests' } , 
			{'knocks_ofy' : showKeyFrBallon > 6}]">
				<knocksballon
				keep_showing
				container_class = " row knocks_tinny_border_radius knocks_gray_hover knocks_gray_border knocks_house_keeper"
				v-for = "(ballon , index) in frBallons" :key="index"
				:gid="'knocks_notification_req_rightbar_'+index"
				mute
				@seen = "fqseenCounter--"
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
    	ballonsOption : { icon : 'knocks-balloon' , label : 'Ballons' , static : true , value : 'ballons'} ,
    	friendRequestOption : { icon : 'knocks-user-add-outline' , label : 'Friendship Requests' , static : true , value : 'requests'} ,
    	seenCounter : 0 ,
    	showKeyBallon : 3 ,
    	showKeyFrBallon : 3 ,
    	ballonsTickedOnce : false ,
    	requestsTickedOnce : false ,
    	regBallons : [] ,
    	frBallons : [] ,
    	fqseenCounter : 0 ,
    }
  },
  mounted(){
  	const vm = this;
  	App.$on('knocksBallonsUpdate' , (payloads)=>{
  		vm.ballons = payloads.patch;
  		vm.regBallons = [];
  		let i ;
  		vm.seenCounter = 0;
  		vm.fqseenCounter = 0;
  		for(i = 0 ; i < vm.ballons.length; i++){
  			if(vm.ballons[i].index.category != 'friend_request' && vm.ballons[i].index.category != 'friend_request_accepted' ){
  		    if(!vm.isRepeatedBallon(i , vm.ballons)){
  			vm.regBallons.push(vm.ballons[i])
  			if(vm.ballons[i].seen == 0){
  				vm.seenCounter++
  			}
  		}
  		}else{
  			if(!vm.isRepeatedBallon(i , vm.ballons)){
  			vm.frBallons.push(vm.ballons[i])
  			if(vm.ballons[i].seen == 0){
  				vm.fqseenCounter++
  			}
  		}

  		}
  		}
  		if(vm.seenCounter == 0){
  			vm.ballonsOption = { icon : 'knocks-balloon ' , label : 'Ballons' , static : true , value : 'ballons'} 
  		}else{
  			vm.ballonsOption = { icon : 'knocks-balloon red-text' , label : 'Ballons' , static : true , value : 'ballons' , counter : vm.seenCounter} 
  		}
  		if(vm.fqseenCounter == 0){
  			vm.friendRequestOption = { icon : 'knocks-user-add-outline ' , label : 'Friendship Requests' , static : true , value : 'requests'} ;
  		}else{
  			vm.friendRequestOption = { icon : 'knocks-user-add-outline red-text' , label : 'Friendship Requests' , static : true , value : 'requests' , counter : vm.fqseenCounter} 
  		}
  	})
  },methods : {
  	handleTaps(){
  		if(this.tap == 'ballons' && !this.ballonsTickedOnce) this.ballonsTickedOnce = true;
  		if(this.tap == 'requests' && !this.requestsTickedOnce) this.requestsTickedOnce = true;
  	},
  	isRepeatedBallon(ind , arr){
  		let i ;
  		for(i = 0 ; i < ind; i++){
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
}
  }
}
</script>

<style lang="css" scoped>
</style>