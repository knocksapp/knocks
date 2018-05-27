<template>
<div >
  <knockspopover v-if = "!as_list">
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
    <div v-if = "as_list" v-loading = "isLoading" >
      <knockscollapse
      :toggle_on_mount ="toggled"
      regular_class = "blue-grey-text text-darken-3 knocks_text_ms"
      toggler_container = " grey lighten-4 row knocks_gray_hover knocks_margin_keeper knocks_gray_border knocks_fair_padding"
      class = "blue-grey lighten-5 knocks_house_keeper"
      title = "Show" active_title = "Hide" dual_title  v-if = "circleObject != null" :icon = "firstIcon()">
      <div slot = "content">
        <div class = "row knocks_fair_bounds">
          <knockselinput
          icon = "knocks-search-2"
          autocomplete
          :autocomplete_start="1"
          show_autocomplete_progress
          placeholder = "Search.."
          inner_placeholder
          v-model = "searchInput"
          autocomplete_from = "user/search"
          @autocomplete="handleSearch($event)" ></knockselinput>
        </div>
        <knocksshowkeys
        :show_key = "show_key"
        v-if = "circleObject != null && searchInput.length == 0" :as_label = "false"
        as_result extended
        :show_input = "circleObject.members"></knocksshowkeys>
        <knocksshowkeys
        :show_key = "show_key"
        v-if = "circleObject != null && searchInput.length > 0"
        :as_label = "false"
        as_result extended :show_input = "searchResult"></knocksshowkeys>
      </div>
      </knockscollapse>
    </div>
  </div>
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
    },
    as_list : {
      type : Boolean , 
      default : false 
    },
    toggled : {
      type : Boolean , 
      default : false
    },
    show_key : {
      type : Number , 
      default : 3
    },
  },
  data () {
    return {
      circleObject : null ,
      isLoading : false ,
      searchInput : '' , 
      searchResult : [] ,
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
         else if (vm.circleObject.members.indexOf(payloads.member) != -1){
          vm.circleObject.members.splice(vm.circleObject.members.indexOf(payloads.member) , 1)
          vm.bindCircle(vm.circleObject);
         }
      }
    })
    App.$on('knocksCircleGlobalRemoveMember' , (payloads)=>{
      
        if(vm.circleObject == null) vm.loadCircleData();
        else if (vm.circleObject.members.indexOf(payloads.member) != -1){
          vm.circleObject.members.splice(vm.circleObject.members.indexOf(payloads.member) , 1)
          vm.bindCircle(vm.circleObject);
         }
      
    })
    App.$on('knocksMemberRemoved' , (payloads)=>{
      vm.removeMember(payloads.user)
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
          data : { circle : vm.circle } , 
          onDownloadProgress : ()=>{ vm.isLoading = true }
        }).then( (response)=>{
          vm.isLoading = false
          vm.bindCircle(response.data)
        }).catch((err)=>{ console.log(err); vm.$emit('error' , err) });
      }
    },
    bindCircle(object){
      this.circleObject = object;
      
      if(this.circleObject.icon != null && typeof(this.circleObject.icon) == "string")
      this.circleObject.icon = (JSON.parse(this.circleObject.icon));
      window.UserCircles[this.circle] = this.circleObject;
      App.$emit('circleLoaded' , [ window.UserCircles , window.UserCirclesLength() ]);
      this.$emit('input' , this.circleObject);
    },
    reboundCirlce(){
      this.circleObject = null ;
      this.circleObject = window.UserCircles[this.circle];
    },
    removeMember(mem){
      if(this.circleObject == null) return;
      if(this.circleObject.members.indexOf(mem) != -1){
        this.circleObject.members.splice(this.circleObject.members.indexOf(mem) , 1);
        this.bindCircle(this.circleObject);
      }
    },
    firstIcon(){
      if(this.circleObject.icon != null){
        return 'knocks-'+this.circleObject.icon[0].class
      }else return ''
    },handleSearch(e){
      if(this.circleObject == null) {return;}
      let i ; this.searchResult = []
      for(i = 0; i < e.length; i++)
        if(this.circleObject.members.indexOf(e[i]) != -1) this.searchResult.push(e[i])
      App.$emit('KnocksContentChanged')
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