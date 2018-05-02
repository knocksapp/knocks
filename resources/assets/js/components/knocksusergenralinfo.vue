<template lang="html">
  <div>
  <knocksuser main_container = "row knocks_house_keeper" v-model = "userObject" :user="user" class="knocks_hidden"></knocksuser>
  <div v-if="userObject != null">
  <div v-if=" count == 0">

      <a
         v-if ="info_exist() "
         @click = "see_more_info()"
         class = "left knocks_side_padding knocks_text_ms knocks_text_anchor knocks_pointer" >
        <span class = "knocksapp-sort-down"></span> <static_message msg = "See More"></static_message>
      </a>

</div>
</div>

      <div class="row knocks_house_keeper knocks_text_dark animated fadeInDown " v-if ="userObject != null && count == 1" >
<div class = "col s12">
          <ul >
      <li v-if="userObject.phone !== undefined && (userObject.phone !='' && userObject.phone != null )" > <span class="knocks-mobile6"></span>  <static_message msg= "Phone"></static_message>  :  {{userObject.phone}} </li>
       <li v-if="userObject.marital_status != undefined && (userObject.marital_status != null) "> <span class="knocks-diamond3"></span>   <static_message msg = "Martial status"></static_message>  :  {{userObject.marital_status}} </li>
       <li v-if="userObject.orientation != undefined && (userObject.orientation != null) ">  <span class="knocks-venus-mars"></span>  <static_message msg= "Orientation"></static_message>  :  {{userObject.orientation }}</li>
       <li v-if="userObject.religon != undefined && (userObject.religon != null) "> <span class="knocks-book11"></span>   <static_message msg= "Religon"></static_message>  :  {{userObject.religon}} </li>
       <li v-if="userObject.bio != undefined && (userObject.bio != null) "> <span class="knocks-profile"></span>
         <static_message msg= "Bio"></static_message> : {{bio}}  </li>
       <div class="row knocks_house_keeper" v-if=" userObject.bio != null && userObject.bio.length > 350 " >
         <div v-if="bodyLen > 350, userObject.bio != null" class="top">
           <a v-if="bioCount == 0" class=" right" @click = "seeMore = true, see_more_bio()">
           See more
         </a>
         <a v-if="bioCount == 1" class=" right" @click = "seeMore = false,see_less_bio() ">See Less</a>
         </div>
     </div>

     </ul>
 </div>
    </div>

      <div v-if="userObject != null">
      <div v-if=" count == 1">
          <a
             v-if ="info_exist() "
             @click = "see_less_info()"
             class = "left knocks_side_padding knocks_text_ms knocks_text_anchor knocks_pointer" >
            <span class = "knocksapp-sort-up"></span> <static_message msg = "See Less"></static_message>
          </a>
      </div>
    </div>
</div>
</template>

<script>

export default {
  name: 'knocksusergenralinfo',
  mounted () {
this.bodylen = this.bodylenn;
  },
  props : {
    user : {
      type : Number ,
      required : true
    }
  },
  computed :{
    bodylenn(){
      if(this.userObject == null) return 0 ;
      return this.userObject.bio.length;
    },
    bio(){
      if(this.bodylenn < 350){
        this.seeMore = false ;
        return this.userObject.bio
      }
      if(this.seeMore && this.bodylenn > 350)
      return this.userObject.bio

      return this.trimBio();

    },
  },
  data(){
    return{
      userObject : null,
      dialogVisible: false,
      count : 0,
      bioCount :0,
      counters : 0,
      counter : 0,
      bodyLen : 0,
      seeMore : false ,
    }
  },
  methods:{
dialogbtn(){
  this.dialogVisible = true;
},
info_exist(){
  if((this.userObject.phone !== undefined && (this.userObject.phone !='' && this.userObject.phone != null )) || (this.userObject.marital_status !== undefined && (this.userObject.marital_status !='' && this.userObject.marital_status != null )) || (this.userObject.orientation !== undefined &&
      (this.userObject.orientation !='' && this.userObject.orientation != null )) || (this.userObject.religon !== undefined && (this.userObject.religon !='' && this.userObject.religon != null )) || (this.userObject.bio !== undefined && (this.userObject.bio !='' && this.userObject.bio != null )) )
            return true ;
  else {
    return false;
  }
},
trimBio(){
  return this.userObject.bio.substr(0,350)+'..';
},
see_more_info(){
  this.count = 1;
},
see_less_info(){
  this.count = 0;
},
see_more_bio(){
  this.bioCount = 1;
},
see_less_bio(){
  this.bioCount = 0;
},
rd(){
const vm = this

var readmore = $('.rdmore').text();
console.log(readmore);
if(!$('#'+vm.user).hasClass('knock_readmore_clicked')){
$('#'+vm.user).css({
'height': 'auto'
});
$('#'+vm.user).removeClass('animated jello');
$('#'+vm.user).addClass('knock_readmore_clicked');
$('#'+vm.user).removeClass('animated pulse');
$('#'+vm.user).removeClass('animated shake');
$('#'+vm.user).removeClass('animated rubberBand');
$('#'+vm.user).addClass('animated fadeInDown');
$('#'+vm.user+'_readmore').text('See less');
vm.counters = 1;
}else
{
$('#'+vm.user).css({
'height': '7.4em'
});
$('#'+vm.user+'_readmore').text('See More');
$('#'+vm.user).removeClass('animated pulse');
$('#'+vm.user).removeClass('knock_readmore_clicked');
$('#'+vm.user).removeClass('animated rubberBand');
$('#'+vm.user).removeClass('animated jello');
$('#'+vm.user).removeClass('animated fadeInDown');
$('#'+vm.user).addClass('animated shake');
vm.counters = 0;
}



},

  },
}
</script>

<style lang="css">

</style>
