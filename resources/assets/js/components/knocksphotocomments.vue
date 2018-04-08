<template>
	<div>
		<knocksretriver 
		url = "media/image/comments"
		v-model = "retriver"
		@success = "handle($event)"
		:scope = "[gid]"
		recursed
		:xdata = "{token : token , max : max}"></knocksretriver>
				<h4 class="ui horizontal divider header transparent animated slideInDown" slot = "top" v-if = "comments.length > 0" style="padding-top : 7px !important">
	<i class="knocks-chat-12"></i>
	<static_message msg = "Comments"></static_message>
	</h4>
	         <div class = "row knocks_house_keeper">
              <a v-if = "comments != null && showKey < comments.length && showKey > 0" @click = "increaseRang()"
                class = "knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
                <span class = "knocks-chat-2"></span> See More Comments
              </a>
              <a v-if = "comments != null && showKey < comments.length && showKey < 1" @click = "increaseRang()"
                class = "knocks_side_padding knocks_text_sm knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
                <span class = "knocks-chat-2"></span> Show Comments
              </a>
              <span class = "grey-text right knocks_text_sm knocks_side_padding" v-if = "comments != null && comments.length > 0">{{showKeyMin+'/'+comments.length}} Comments</span>
            </div>
		<div class="" v-for = "(com , index) in comments"  v-if = "comments != null && comments.length > 0" >

              <knockscomment
              v-if="inRange(index)"
              :gid= "gid+'_comment_'+index"
              :knock="com"
              @invalid = "removeComment($event)"
              :current_user="current_user"
              replier_message = "Reply here" ></knockscomment>
            </div>
            <div class = "col s12 knocks_house_keeper">
              <a v-if = "comments != null && showKey > 3" @click = "reduceRang()"
                class = "knocks_tinny_padding knocks_text_sm  knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
                <span class = "knocks-chat-1"></span> See Less Comments
              </a>
              <a v-if = "comments != null && showKey > 0 && comments.length > 0" @click = "showKey = 0"
                class = "knocks_tinny_padding knocks_text_sm right  knocks_text_anchor knocks_pointer" style = "margin-left:2px;">
                <span class = "knocks-chat-1"></span> Hide All Comments
              </a>
                
            </div>
	</div>
</template>

<script>
export default {

  name: 'knocksphotocomments',
  props : {
  	token :  {
  		type : Number , 
  		required : true
  	} , 
  	gid : {
  		type : String , 
  		required : true ,
  	}
  },
  data () {
    return {
    	comments : [] , 
    	retriver : { loading : false } , 
    	current_user : parseInt(UserId) , 
    	showKey : 3 , 
    	max : -1 ,
    }
  },
  computed :  {
  	showKeyMin(){
  		return Math.min(this.comments.length , this.showKey);
  	}
  },
  methods : {
  	showRange(){
      return this.comments.length - this.showKey -1;
    },
    inRange(index){
      return index > this.showRange() ? true : false;
    },
    increaseRang(){
      if(this.comments.length - this.showKey > 5 ) {
        this.showKey += 5;
      }else{
         this.showKey += this.comments.length - this.showKey;
        } 
    },
    reduceRang(){
      if( this.showKey -  5 < 1) {
        this.showKey = 1;
      }else{
         this.showKey -= 5 ;
        } 
    },
    handle(e){
    	let temp = e.response;
    	let i ;
    	for(i = 0 ; i < temp.length; i++)
    		this.comments.push(temp[i])
    	if(this.comments.length > 0){
    		this.max = Math.max(...this.comments);
    	}
    }
  }
}
</script>

<style lang="css" scoped>
</style>