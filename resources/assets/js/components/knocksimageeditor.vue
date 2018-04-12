<template>
<div class="row knocks_xs_side_padding">
  
  <div class="col s12 grid modal-trigger" @click="crop()" :id="gid+'_container'" :href="'#'+gid+'_image_editor_modal'"  >
  <div class="column">
    <div class="ui fluid card">
      <div class="ui  middle aligned  image" style=" " :id="gid+'_img_editor_toggler'">
        <img :src = "currentSource"  v-if = "currentSource != null" :id="gid+'_img_editor_el'"  @load = "setHeight()"/>
      </div>
      <div class="content">
        <a class="header center" @click = "crop()">
          <span class = "knocksapp-edit"></span>
          <static_message msg = "Edit" v-if = "windowWidth > 900"></static_message>
        </a>
      </div>
    </div>
  </div>
</div>
  <div :id="gid+'_image_editor_modal'" class="modal" style = "width : 100% !important; top: 10px !important; min-height: 83vh;">
    <div class="modal-content" style="">
      <el-input placeholder="Quote Your Image.." v-model="quote" class = "knocks_fair_bounds" @input = "assign()">
        <template slot="prepend"><span class = "knocks-pencil9"></span></template>
      </el-input>
      <div class = " col s12 knocks_house_keeper " style= "z-index : 30000000000" :id = "`knocks_upload_port_`+gid" >
      </div>
    </div>
    <div class="modal-footer" style="">
      <center>
        <knockspopover>
      <template slot = "container">
      <button class = "knocks_color_kit knocks_btn_color_kit knocks_color_kit  btn-floating" @click = "cropDone()">
      <span class = "knocks-checkmark6"></span>
      </button>
      </template>
      <span slot = "content"  class = "knocks_tooltip animated flipInX" >
        <span class = "knocks-checkmark6"></span>
        <static_message msg = "Done"></static_message> 
      </span>
      </knockspopover>
      <knockspopover>
      <template slot = "container">
      <button class = " knocks_color_kit knocks_btn_color_kit btn-floating" :class = "gid+'_rotate'" data-deg = "-90"  >
      <span class = "knocks-rotate-ccw"></span>
      </button>
      </template>
      <span slot = "content"  class = "knocks_tooltip animated flipInX" >
        <span class = "knocks-rotate-ccw"></span>
        <static_message msg = "Rotate Left"></static_message>
      </span>
      </knockspopover>
      <knockspopover>
      <template slot = "container">
      <button class = " knocks_color_kit knocks_btn_color_kit btn-floating" :class = "gid+'_rotate'" data-deg = "90">
      <span class = "knocks-rotate-cw"></span> 
      </button>
      </template>
      <span slot = "content"  class = "knocks_tooltip animated flipInX" >
        <span class = "knocks-rotate-cw"></span>
        <static_message msg = "Rotate Right"></static_message>
      </span>
      </knockspopover>
      <knockspopover>
      <template slot = "container" >
      </button>
      <button class = " knocks_color_kit knocks_btn_color_kit btn-floating" @click="cancelEditing()"  >
      <span class = "knocks-x-circle"></span>
      </button>
      </template>
      <span slot = "content"  class = "knocks_tooltip animated flipInX" >
        <span class = "knocks-x-circle"></span>
        <static_message msg = "Cancel"></static_message>
      </span>
      </knockspopover>
      </center>
    </div>
  </div>
</div>
</template>

<script>
export default {

  name: 'knocksimageeditor',
  props : {
  	source : {
  		type : String , 
  		default : ''
  	},
  	gid : {
  		type : String , 
  		default : ''
  	}
  },

  data () {
    return {
      currentSource : null , 
      basic : null ,
      quote : '', 
      windowWidth : $(window).width() ,
      windowHeight : $(window).height() ,
      minOrigin : 0 ,
    }
  }
  , mounted(){
    $('#'+this.gid+'_image_editor_modal').modal();
    this.minOrigin = Math.min(this.windowWidth , this.windowHeight)
    this.assign();
  	setTimeout( ()=>{ this.assignToModel(this.source);} , 200);
    const vm = this;
    $(window).resize(function(){
      vm.windowWidth =  $(window).width()
      vm.windowHeight = $(window).height()
      vm.minOrigin = Math.min(vm.windowWidth , vm.windowHeight)
      vm.setHeight();
    })
    //this.setHeight();
  },
  methods: {
  represent(){
    
  } ,
  setHeight(){
    setTimeout( ()=>{
    let imgWidth = $('#'+this.gid+'_img_editor_toggler').width();
    console.log(imgWidth)
    $('#'+this.gid+'_img_editor_toggler').css({'height' : imgWidth })
    $('#'+this.gid+'_img_editor_el').css({'max-height' : imgWidth })
  }, 200)
  },
  assignToModel(source){
    this.currentSource = source;
    this.$emit('input' , {blob : this.currentSource , quote : this.quote});
    this.setHeight();

  },
  crop(){
    const vm = this;
    $('#knocks_upload_port_'+vm.gid).empty();
    let targetElement = document.getElementById('knocks_upload_port_'+vm.gid );
    vm.basic = new Croppie( targetElement , {
                   boundary: {
                    width: vm.minOrigin * 80 / 100,
                    height: vm.minOrigin * 80 / 100,
                  },
                    viewport: { 
                      width: vm.minOrigin * 50 / 100, 
                      height: vm.minOrigin * 50 / 100 
                    },
                    showZoomer: false,
                    enableResize: true,
                    enableOrientation: true
                });
                vm.basic.bind({
                  url : vm.source , 
                });
               $('.'+vm.gid+'_rotate').on('click', function(ev) {
                  vm.basic.rotate(parseInt($(this).data('deg')));
                });
  } , 
  cropDone(){
    const vm = this ;
         let options = {
         type: 'canvas',
         size: 'viewport',
         format: 'jpeg',
         circle: false
     }
        this.basic.result(options ).then(function(blob) {
          vm.currentSource = blob;
           $('#'+vm.gid+'_image_editor_modal').modal('close');
           vm.assign();
        });
  }, assign(){
    this.$emit('input' , {blob : this.currentSource , quote : this.quote});
  },
  cancelEditing(){
    $('#'+this.gid+'_image_editor_modal').modal('close');
  }
}
}
</script>

<style lang="css" scoped>

.modal-content{
  height: 70% !important;
}
</style>