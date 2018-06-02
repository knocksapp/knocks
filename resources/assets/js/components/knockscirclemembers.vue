<template>
<div>
	<knocksretriver
	url = "retrive_circle"
	v-model = "retriver"
	:xdata = "{circle : circle}"
	@success = "handle($event)"></knocksretriver>
	<div class = "col s12 white knocks_gray_border knocks_tinny_border_radius" v-loading = "retriver.loading">
		<div v-if = "handled">
		<span class = 'knocksapp-edit'></span>
		<static_message 
		class = "animated fadeIn" 
		msg = "Edit %%% Members."
		replaceable
		:replacements = "[{ target : '%%%'  , body : retriver.response.name }]"></static_message>
		</div>
		<knockselinput
		icon = "knocks-search-2"
		v-if = "handled"
		autocomplete
		:autocomplete_start="1"
		show_autocomplete_progress
		placeholder = "Add Members"
		inner_placeholder
		v-model = "searchInput"
		autocomplete_from = "user/search"
		@input = "refreshUsersContent()"
		@autocomplete="searchUsers = $event; userShowKey = 2; refreshUsersContent()" >
		</knockselinput>
		<ul class = "knocks_house_keeper" v-if = "handled && searchInput.length > 0">
			<li v-for = "(member , index) in searchUsers" class = "knocks_house_keeper knocks_tinny_border_radius col knocks_gray_hover s12" v-if = "currentMembers.indexOf(member) == -1 && index < userShowKey && member != auth">
				<div class = "row knocks_house_keeper">
					<knocksuser as_label class = "col" :user="member" show_image>
					</knocksuser>
					<knockselbutton
					 icon = "el-icon-plus"
			         class = "right "
			         size = "mini"
			         submit_at = "circle/member/add"
                     :submit_data = "{ circle : circle , user : member}"
                     :scope = "['sidebar_circle_add_member_'+circle]"
                     success_at = "done"
	                 :error_at = "[
	                 { res : 'invalid' , msg : 'This process can\'t be done, please try again.' } ,
	                 { res : 'exisits' , msg : 'This user is already a member.' }
	                 ]"
                     @knocks_submit_accepted = "addMember(member , circle)"
			         disable_placeholder
			         type="success"
			         circle
			         style = "margin-right : 2px !important; margin-top : 8px !important;" 
					 ></knockselbutton>
				</div>
			</li>
		</ul>
		<div class = "row" v-if = "handled && ( (userShowKey > 2 && searchUsers.length > 2) || (searchUsers.length > userShowKey) )">
			<a :class ="[{'knocks_hidden':!(searchUsers.length > userShowKey)}]" @click = "userShowKey += 2">
				<static_message msg = "See More"></static_message>
			</a>
			<a :class ="[{'knocks_hidden':!(userShowKey > 2 && searchUsers.length > 2)}]" class = "right" @click = "userShowKey -= 2">
				<static_message msg = "See Less"></static_message>
			</a>
		</div>
		<center  v-if = "handled && currentMembers.length == 0">
		<span class = "grey-text text-darken-2 animated fadeIn  ">
		  <span class = "knocksapp-prick2"></span>
		  <static_message msg = "There is no members in this circle."></static_message>
		</span>
	   </center>
		<span v-else class = "grey-text text-darken-2 animated fadeIn  ">
		  <span>{{currentMembers.length}}</span>
		  <static_message msg = "Members."></static_message>
		</span>
		<ul class = "knocks_house_keeper">
			<li v-for = "(member , index) in currentMembers" class = "knocks_house_keeper col s12" v-if = "index < memShowKey">
				<div class = "row animated fadeIn">
					<knocksuser as_label class = "col " :user="member" show_image>
					</knocksuser>
					<knockselbutton
					 icon = "el-icon-minus"
			         class = "right "
			         size = "mini"
			         submit_at = "circle/member/remove"
                     :submit_data = "{ circle : circle , user : member}"
                     :scope = "['sidebar_circle_add_member_'+circle]"
                     success_at = "done"
	                 :error_at = "[
	                 { res : 'invalid' , msg : 'This process can\'t be done, please try again.' } ,
	                 { res : 'exisits' , msg : 'This user is not a member in the circle already.' }
	                 ]"
                     @knocks_submit_accepted = "removeMember(member , circle)"
			         disable_placeholder
			         type="danger"
			         circle
			         style = "margin-right : 2px !important; margin-top : 8px !important;" 
					 ></knockselbutton>
				</div>
			</li>
		</ul>
		<div class = "row" v-if = "handled && ( (memShowKey > 2 && currentMembers.length > 2) || (currentMembers.length > memShowKey) )">
			<a :class ="[{'knocks_hidden':!(currentMembers.length > memShowKey)}]" @click = "memShowKey += 2">
				<static_message msg = "See More"></static_message>
			</a>
			<a :class ="[{'knocks_hidden':!(memShowKey > 2 && currentMembers.length > 2)}]" class = "right" @click = "memShowKey -= 2">
				<static_message msg = "See Less"></static_message>
			</a>
		</div>
	</div>
</div>
</template>

<script>
export default {

  name: 'knockscirclemembers',
  props : {
  	circle : {
  		type : Number ,
  		required : true ,
  	}
  },
  data () {
    return {
    	retriver : { loading : false } , 
    	currentMembers : [] , 
    	searchUsers : [] ,
    	searchInput : '' ,
    	userShowKey : 2 ,
    	memShowKey : 2 ,
    	lastEdit : null ,
    	handled : false , 
    	auth : parseInt(window.UserId)
    }
  },
  computed : {
  	showKeyMin(){
  		return Math.min( this.userShowKey , this.currentMembers.length)
  	}
  },
   methods : {
   	handle(e){
   		this.handled = true;
   		this.lastEdit = e.response;
   		this.currentMembers = e.response.members ;
   	},
   	refreshUsersContent(){
   		let i ;
   		for(i = 0; i < this.searchUsers.length; i++){
   			if(this.currentMembers.indexOf(this.searchUsers[i]) != -1 || this.searchUsers[i] == this.auth){
   				this.searchUsers.splice(i , 1 );
   			}
   		}
   		App.$emit('KnocksContentChanged')
   	},
   	addMember( member , circle ){
   		this.currentMembers.splice(0 , 0 , member);
   		this.lastEdit.members = this.currentMembers ; 
   		App.$emit('knocksRebindCircle' , { circle : circle , object : this.lastEdit })
   		this.refreshUsersContent();
   	},
   	removeMember( member , circle ){
   		this.currentMembers.splice(this.currentMembers.indexOf(member) , 1);
   		this.lastEdit.members = this.currentMembers ; 
   		App.$emit('knocksRebindCircle' , { circle : circle , object : this.lastEdit })
   		this.refreshUsersContent();
   	}
   }
}
</script>

<style lang="css" scoped>
</style>