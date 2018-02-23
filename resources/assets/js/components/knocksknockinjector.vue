<template>
<div id = "knocks_injector" class = "knocks_house_keeper">
	   <div class= "row " style="padding : 0.1rem">
       <center>
      <el-button type="warning" @click = "retriveNewerPosts" :loading="loadingKnocks" class = "knocks_el_round_btn" id="knocks_load_more_knocks_btn">
        <span class = "knocks-refresh8"></span>
        <static_message msg="Load new knocks"></static_message>
      </el-button>
    </center>
     </div>
	<div class = "row" v-for="(knock , index) in currentKnocks" v-if = "currentKnocks != null && !as_atimeline">  
<!--     <a v-if = "k[index] != undefined && !isMentioned(k[index].disDate , index)" >
      {{k[index].disDate}}    </a> -->
    <transition    name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
    <knocksknock  :knock = "knock" :gid="'knock_'+index" v-model = "k[index]"
   :current_user = "current_user" replier_message = "Leave a comment" ></knocksknock> 
    </transition>

   </div>
   <div v-if = "as_atimeline &&  currentKnocks != null">
    <div class = "col l9 m12">
        <div class = "row" v-for="(knock , index) in currentKnocks" v-if = "currentKnocks != null && as_atimeline">  
  <!--   <span v-if = "k[index] != undefined && !isMentioned(k[index].disDate , index)" >
      {{k[index].disDate}}    </span> -->
    <transition    name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
    
      <knocksknock  :knock = "knock" :gid="'knock_'+index" v-model = "k[index]"
   :current_user = "current_user" replier_message = "Leave a comment" ></knocksknock> 
    
    </transition>

   </div>
    </div>
    <div class = "col l3 show-on-large hide-on-med-and-down knocks_second_sidebar" id = "knocks_profile_fixed" >
       <ul class="section table-of-contents right"  >
        <li v-for = "(d , index) in knocksDates"><a :href="'#knocks_date'+knocksNumericDates[index]">{{d}}</a></li>
      </ul>
    </div>
     
   </div>


      <transition    name="custom-classes-transition" enter-active-class="animated zoomIn" leave-active-class="animated zoomOut">
    <center><knocksloader gid= "knocks_loading_span" v-if = "loadingKnocks"></knocksloader></center>
   </transition>
</div>
</template>

<script>
export default {

  name: 'knocksknockinjector',
  props : {
  	older_retrive : {
  		type : String , 
  		default : 'user/posts/older'
  	},
  	newer_retrive : {
  		type : String , 
  		default : 'user/posts/newer'
  	},
  	basic_retrive : {
  		type : String , 
  		default : 'user/posts'
  	},
  	retirve_from_scratch : {
  		type :String , 
  		default : 'user/posts'
  	},
  	current_user : {
  		type : Number , 
  		default : null,
  	},
  	requsted : {
  		type : Number , 
  		default : null
  	},
    as_atimeline : {
      type : Boolean , 
      default : false 
    }

  },
  data () {
    return {

 currentIndex : null ,

    currentKnocks : null ,

    maxRetrived : null , 
    minRetrived : null ,
    lastIndex  : null ,
    loadingKnocks : false ,
    k : [] ,
    mentionedDates : [] , 
    mentionedDatesIndex : [] , 
    mentionedKnocks : [] , 



    }

  },
  computed :  {
    knocksDates(){
      if(this.k.length == 0) return [] ;
      let i , array;
      array = [];
      for(i in this.k){
        if(array.indexOf(this.k[i].disDate) == -1)
          array.push(this.k[i].disDate);
      }

      return array;
    },
    knocksNumericDates(){
      if(this.k.length == 0) return [] ;
      let i , array;
      array = [];
      for(i in this.k){
        if(array.indexOf(this.k[i].numericDate) == -1)
          array.push(this.k[i].numericDate);
      }
      return array;
    }
  },
  mounted(){

     $(document).ready(function(){
    $('.scrollspy').scrollSpy();

    $(window).scroll(function(){
      
      if(window.scrollY > $('#knocks_injector').position().top - 100 ){
        var l = $('#knocks_injector').position().top - 100 ;
        $('#knocks_profile_fixed').css({'top' : '70px'})
      }else{
         $('#knocks_profile_fixed').css({'top' : 'unset'})
      }
    })
  });
        
  	const vm = this;
  this.retrivePosts();
  App.$on('knocks_refresh_posts' , ()=> { vm.retriveNewerPosts();  });

  window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight ) {
      if(!vm.loadingKnocks)
        vm.retriveOlderPosts();
    }
  };
  },
  methods :{
    isMentioned(date , index){
      if(this.mentionedDates.indexOf(date) == -1 ){
        let flag = false ;
        this.mentionedDates.push(date);
        this.mentionedDatesIndex.push(index);
             $(document).ready(function(){
                $('.scrollspy').scrollSpy();
              });
        return false ;
      }else
      if(index == this.mentionedDates.indexOf(date)){
             $(document).ready(function(){
    $('.scrollspy').scrollSpy();
  });
       return false;
      }
     else return true
    },
  compDatesIndex(date){
    return this.knocksDates.indexOf(date);
  },
  	retrivePosts(){
      if(this.sessionType == 'guest' || this.sessionType == 'dev' || parseInt(this.UserId)==-1) return;
      // this.currentKnocks = [];
      // let key;
      // for(key in window.UserKnocks){
      //   this.currentKnocks.push(parseInt(key));
      //   this.currentKnocks.sort().reverse();  
      // }
      const vm = this;
      axios({
        method : 'post',
        data : { limits : {max : vm.maxRetrived , min : vm.minRetrived , last_index : vm.lastIndex} , user : vm.requsted },
        url : LaravelOrgin + vm.basic_retrive ,
         onDownloadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
        onUploadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
      }).then((response)=>{

        let assign = response.data.knocks;
        // if(assign.length > 10){
        //   assign.splice(10,assign.length-11);
        // }
        let i;
        if(vm.currentKnocks == null) vm.currentKnocks = [];
        for(i = 0; i < assign.length; i++){
          if(vm.currentKnocks.indexOf(assign[i]) == -1){
            vm.currentKnocks.push(assign[i])
            vm.currentKnocks = vm.currentKnocks.sort().reverse();
          }
        }
        vm.lastIndex = response.data.last_index;
        vm.minRetrived = Math.min.apply(null,vm.currentKnocks);
        vm.maxRetrived = Math.max.apply(null,vm.currentKnocks );
        vm.loadingKnocks = false;
        App.$emit('knocks_refresh_posts_done');
        vm.currentKnocks = vm.currentKnocks.sort().reverse();
        console.log(vm.currentKnocks);
        console.log (vm.currentKnocks[vm.currentKnocks.length-1]);
         $('.scrollspy').scrollSpy();
        // setTimeout( ()=>{
        //   vm.retriveNewerPosts();
        // } , 5000);
        //console.log(assign);
        //setTimeout( ()=>{ this.retrivePosts()}, 5000);  

      }).catch(()=>{
        vm.loadingKnocks = false ;
      });
    },
      retriveOlderPosts(){
      if(this.sessionType == 'guest' || parseInt(this.UserId)==-1) return;
      // this.currentKnocks = [];
      // let key;
      // for(key in window.UserKnocks){
      //   this.currentKnocks.push(parseInt(key));
      //   this.currentKnocks.sort().reverse();  
      // }
      const vm = this;
      axios({
        method : 'post',
        data : {  min : vm.minRetrived  , user : vm.requsted},
        url : LaravelOrgin + vm.older_retrive ,
         onDownloadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
        onUploadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
      }).then((response)=>{
        let assign = response.data.knocks;
        // if(assign.length > 10){
        //   assign.splice(10,assign.length-11);
        // }
        let i;
        if(vm.currentKnocks == null) vm.currentKnocks = [];
        for(i = 0; i < assign.length; i++){
          if(vm.currentKnocks.indexOf(assign[i]) == -1){
            vm.currentKnocks.push(assign[i])
           // vm.currentKnocks = vm.currentKnocks.sort().reverse();
          }
        }
        vm.minRetrived = Math.min.apply(null,vm.currentKnocks);
        vm.loadingKnocks = false;
        App.$emit('knocks_refresh_posts_done');
        //vm.currentKnocks = vm.currentKnocks.sort().reverse();
        console.log(vm.currentKnocks);
        console.log (vm.currentKnocks[vm.currentKnocks.length-1]);
        //console.log(assign);
        //setTimeout( ()=>{ this.retrivePosts()}, 5000);  
         $('.scrollspy').scrollSpy();

      }).catch(()=>{
        vm.loadingKnocks = false ;
      });
    },
      retriveNewerPosts(){
      if(this.sessionType == 'guest' || parseInt(this.UserId)==-1) return;
      // this.currentKnocks = [];
      // let key;
      // for(key in window.UserKnocks){
      //   this.currentKnocks.push(parseInt(key));
      //   this.currentKnocks.sort().reverse();  
      // }
      const vm = this;
      axios({
        method : 'post',
        data : {  max : vm.maxRetrived , user : vm.requsted },
        url : LaravelOrgin + vm.newer_retrive ,
         onDownloadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
        onUploadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
      }).then((response)=>{
        let assign = response.data.knocks;
        // if(assign.length > 10){
        //   assign.splice(10,assign.length-11);
        // }
        let i;
        if(vm.currentKnocks == null) vm.currentKnocks = [];
        for(i = 0; i < assign.length; i++){
          if(vm.currentKnocks.indexOf(assign[i]) == -1){
            vm.currentKnocks.splice(0,0,assign[i]);
            //vm.currentKnocks.push(assign[i])

            //vm.currentKnocks = vm.currentKnocks.sort().reverse();
          }
        }
        vm.maxRetrived = Math.max.apply(null,vm.currentKnocks);
        vm.loadingKnocks = false;
        App.$emit('knocks_refresh_posts_done');
        //vm.currentKnocks = vm.currentKnocks.sort().reverse();
        console.log(vm.currentKnocks);
        console.log (vm.currentKnocks[vm.currentKnocks.length-1]);
         $('.scrollspy').scrollSpy();
        //console.log(assign);
        //setTimeout( ()=>{ this.retriveNewerPosts()}, 5000);  

      }).catch(()=>{
        vm.loadingKnocks = false ;
      });
    },
       retrivePostsFromScratch(){
      // this.currentKnocks = [];
      // let key;
      // for(key in window.UserKnocks){
      //   this.currentKnocks.push(parseInt(key));
      //   this.currentKnocks.sort().reverse();  
      // }
      const vm = this;
      axios({
        method : 'post',
        data : { limits : {max : null , min : null , last_index : null}  , user : vm.requsted},
        url : LaravelOrgin + retirve_from_scratch ,
         onDownloadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
        onUploadProgress: function (progressEvent) {
          vm.loadingKnocks = true;
        },
      }).then((response)=>{
        let assign = response.data.knocks;
        // if(assign.length > 10){
        //   assign.splice(10,assign.length-11);
        // }
        let i;
        if(vm.currentKnocks == null) vm.currentKnocks = [];
        for(i = 0; i < assign.length; i++){
          if(vm.currentKnocks.indexOf(assign[i]) == -1){
            vm.currentKnocks.push(assign[i])
            vm.currentKnocks = vm.currentKnocks.sort().reverse();
          }
        }
        vm.lastIndex = response.data.last_index;
        vm.minRetrived = Math.min.apply(null,vm.currentKnocks);
        vm.maxRetrived = Math.max.apply(null,vm.currentKnocks );
        vm.loadingKnocks = false;
        App.$emit('knocks_refresh_posts_done');
        vm.currentKnocks = vm.currentKnocks.sort().reverse();
        console.log(vm.currentKnocks);
        console.log (vm.currentKnocks[vm.currentKnocks.length-1]);
        //console.log(assign);
        //setTimeout( ()=>{ this.retrivePosts()}, 5000);  

      }).catch(()=>{
        vm.loadingKnocks = false ;
      });
    },
  }
}
</script>

<style lang="css" scoped>
</style>