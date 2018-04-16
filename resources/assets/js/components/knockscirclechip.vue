<template>
<knockspopover>
<template slot = "container">
<a :href="circle_url" data-position="bottom" >
  <div class="chip ":class="chip_bg_color"v-if = "circleObject != null" >
    <i v-if = "circleObject.icon != null && circleObject.icon.length > 0 && circleObject.icon != ''" :class="['knocks-'+icn.class , chip_text_color]" v-for = "icn in circleObject.icon"></i>
    <span v-if="circleObject.icon == null || circleObject.icon =='' "  :class="['knocks_chip_icon' , chip_text_color]">{{circleObject.name[0].toUpperCase()}}</span>
    <span :class="chip_text_color" v-if = "!only_icon">  {{circleObject.name}}</span>
  </div></a>
  </template>
  <span slot = "content" class = "knocks_tooltip animated flipInX" v-if = "circleObject != null && popover">
    <i :class="['knocks-'+icn.class , chip_text_color]" v-for = "icn in circleObject.icon"></i> 
   {{circleObject.name}} <static_message msg="Circle"></static_message>
 </span>
  </knockspopover>
  </template>
<script>
export default {
  name: 'knockscirclechip',
  props : {
    circle : {
      type :Number , 
      required : true 
    } , 
    main_container : {
      type :String , 
      default : ''
    },
    circle_url:{
      type : String,
      default : '#'
    },
    chip_bg_color : {
      type : String,
      default : 'chip_hover'
    },
    chip_text_color : {
      type : String,
      default : 'knocks_text_light'
    },
    only_icon : {
      type : Boolean , 
      default : false
    },
    popover : {
      type : Boolean , 
      default : true 
    },
    no_rebound : {
      type : Boolean , 
      default : false  
    }
  },
  data () {
    return {
      circleObject : null ,
    }
  }, 
  mounted(){
    this.loadCircleData(); 
    $('.tooltipped').tooltip({delay: 50});
    const vm = this;
    App.$on('knocksRebindCircle' , (payloads)=>{
      if(payloads.circle == vm.circle){
        vm.bindCircle(payloads.object)
      }
    })
    App.$on('knocksCircleAddMember' , (payloads)=>{
      if(payloads.circle == vm.circle){
        if(vm.circleObject == null) vm.loadCircleData();
        else {
          vm.circleObject.members.push(payloads.member)
          vm.bindCircle(vm.circleObject);
         }
      }
    })
    App.$on('knocksCircleRemoveMember' , (payloads)=>{
      if(payloads.circle == vm.circle){
        if(vm.circleObject == null) vm.loadCircleData();
        else {
          vm.circleObject.members.splice(vm.circleObject.members.indexOf(payloads.member) , 1)
          vm.bindCircle(vm.circleObject);
         }
      }
    })
    App.$on('knocksCircleGlobalRemoveMember' , (payloads)=>{
      
        if(vm.circleObject == null) vm.loadCircleData();
        else {
          vm.circleObject.members.splice(vm.circleObject.members.indexOf(payloads.member) , 1)
          vm.bindCircle(vm.circleObject);
         }
      
    })
    App.$on('KnocksContentChanged' , ()=>{
    if(vm.circleObject == null) return;
    if(vm.circleObject.id != vm.circle){
      if(UserCircles[vm.circle] != undefined){
        vm.reboundCirlce(); 
      }
    }
    setTimeout(()=>{
      if(vm.circleObject.id != vm.circle){   
        if(UserCircles[vm.circle] != undefined){
          vm.reboundCirlce(); 
        }
      }
    },300);
  })
  }, 
  methods: {
    loadCircleData(){
      if(window.UserCircles[this.circle] != undefined && !this.no_rebound){
        this.bindCircle(window.UserCircles[this.circle]);

      }else if (window.UserCircles[this.circle] == undefined || this.no_rebound){
        
        const vm = this;
        axios({
          method : 'post' ,
          url : LaravelOrgin + 'retrive_circle' , 
          data : { circle : vm.circle }
        }).then( (response)=>{
          vm.bindCircle(response.data)
        }).catch((err)=>{ console.log(err); });
      }
    },
    bindCircle(object){
      this.circleObject = object;
      this.circleObject.icon = (JSON.parse(this.circleObject.icon));
      window.UserCircles[this.circle] = this.circleObject;
      App.$emit('circleLoaded' , [ window.UserCircles , window.UserCirclesLength() ]);
      this.$emit('input' , this.circleObject);
    },
    reboundCirlce(){
      this.circleObject = null ;
      this.circleObject = window.UserCircles[this.circle];
    }
  }
}
</script>
<style lang="css" scoped>
  
  
  .chip_hover{
    background-color: #691a40;
  }  
  .chip_hover:hover{
    background-color: #91124f;
  }  
</style>