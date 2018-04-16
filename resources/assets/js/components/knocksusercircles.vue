<template>
<div>
  <knocksretriver
  v-model=  "circlesRetriver"
  url = "circle/search"
  @success="circles = $event.response; refreshContent()"
  :xdata = "{ q : search }"
  :scope = "['sidebar_circle_search_special']"
  :precondition = "search.length > 0 && !isFiredSearch"
  >
  </knocksretriver>
  <static_message msg = "search for circles .." v-model = "searchPlaceHolder" class = "knocks_hidden"></static_message>
  
  <div class="row">
    <div class="row knocks_fair_bounds">
      <div class="ui icon input fluid">
        <input type="text" :placeholder="searchPlaceHolder" @input = "" v-model = "search">
        <i class="search icon"></i>
      </div>
    </div>
    <div class = "row">
      <ul class= "uk-list uk-list-divider">
        <li v-for="(circle,index) in circles" class="knocks_text_dark knocks_fair_bounds knocks_blue_gray_hover knocks_tinny_border_radius" v-if = "index < userShowKey" v-loading = "circlesListLoaders[index]">
          <knockscirclechip :circle = "circle" v-model = "circlesModels[index]"></knockscirclechip>
          <el-button type="button" class = "right  uk-button-small uk-button uk-button-default knocks_borderless" v-if = "circle != mainCircle">
          <span class = "knocks-more-vertical"></span>
          </el-button>
          <div uk-dropdown = "pos: bottom-right; mode: click" :id = "'knocks_sidebar_circles_dd_c_'+circle" class = "knocks_house_keeper" v-if = "circle != mainCircle">
            <ul class="uk-nav uk-dropdown-nav knocks_house_keeper">
              <li class = "knocks_xs_padding">
                <knockselbutton
                placeholder = "Delete Circle"
                icon = "knocksapp-trash knocks_icon_border red-text "
                submit_at = "circle/delete"
                :submit_data = "{ circle : circle }"
                type = "default"
                success_at = "done"
                :scope = "['sidebar_circle_delete_'+circle]"
                :error_at = "[
                { res : 'invalid' , msg : 'This process can\'t be done, please try again.' } ,
                { res : 'main' , msg : 'You can\'t delete your main circle.' }
                ]"
                @knocks_button_clicked = "triggerAction( circle , index , true )"
                @knocks_submit_accepted = "deleteCircle(index)"
                label_classes  = "red-text left"
                class = "col s12"
                button_classes = "knocks_borderless  uk-button-small uk-button uk-button-default knocks_gray_hover knocks_tinny_border_radius knocks_xs_padding"
                ></knockselbutton>
              </li>
              <li class = "knocks_xs_padding">
                <knockselbutton
                placeholder = "Edit Members"
                icon = "knocksapp-edit knocks_icon_border "
                :submit_flag = "false"
                label_classes = "left"
                @knocks_button_clicked = "membersEditor = circle; triggerAction(circle , index , false)"
                type = "default"
                class = "col s12"
                button_classes = "knocks_borderless  uk-button-small uk-button uk-button-default knocks_gray_hover knocks_tinny_border_radius knocks_xs_padding"
                ></knockselbutton>
              </li>
              
            </ul>
          </div>
           <el-button type="button" class = "right  uk-button-small uk-button uk-button-default animated fadeIn knocks_borderless" v-if = "membersEditor == circle" 
          @click ="membersEditor = null" >
          <span class = "knocksapp-chevron-up"></span>
          </el-button>
          <knockscirclemembers :circle = "circle" v-if = "membersEditor == circle"></knockscirclemembers>
        </li>
        <li v-if = "circles != null && circles.length == 0">
          <span class = "knocks-alert"></span>
          <static_message msg=  "You have no circle that matches your search"></static_message>
        </li>
      </ul>

      <div class = "row">
        <a :class ="[{'knocks_hidden':!(circles.length > userShowKey)}]" @click = "userShowKey += 3">
          <static_message msg = "See More"></static_message>
        </a>
        <a :class ="[{'knocks_hidden':!(userShowKey > 3 && circles.length > 3)}]" class = "right" @click = "userShowKey -= 3">
          <static_message msg = "See Less"></static_message>
        </a>
      </div>
    </div>
    <div class = "row knocks_fair_bounds">
      <knocksquickcircleadder v-model="circleAdder" :scope = "['sidebar_cirlce_adder']" @knocks_circle_added = "pushCircle($event)"></knocksquickcircleadder>
    </div>
  </div>
</div>
</template>

<script>
export default {

  name: 'knocksusercircles',

  data () {
    return {
    	circles : [] , 
    	circlesModels : [] ,
    	circlesRetriver : { loading : false  } ,
    	searchPlaceHolder : '',
    	search : '' ,
    	userShowKey : 3 ,
    	circleAdder : null ,
      mainCircle : window.UserMainCircle , 
      membersEditor : null ,
      circlesListLoaders : [] ,
      isFiredSearch : false ,
    }
  },
  methods : {
  	searchForCircles(){
      this.isFiredSearch = true
      setTimeout(()=>{
       App.$emit('knocksRetriver' , { scope : ['sidebar_circle_search_special'] }) 
      },200)		
  	},
  	refreshContent(){
      let i ;
      this.circlesListLoaders = [];
      for(i = 0 ; i < this.circles.length; i++){
        this.circlesListLoaders.push(false);
      }
  		App.$emit('KnocksContentChanged')
  	},
    deleteCircle(index){

      this.circles.splice( index , 1);
      this.searchForCircles();
      this.circlesListLoaders[index] = false
      App.$emit('KnocksContentChanged')

    },
    pushCircle(e){
      let temp = this.circles;
      this.circles = [] ;
      temp.splice(0 , 0 , e)
      setTimeout(()=>{
              this.circles = temp;
      App.$emit('KnocksContentChanged')
      },200)

    },
    triggerAction(circle , index , loader){
      UIkit.dropdown(document.getElementById('knocks_sidebar_circles_dd_c_'+circle)).hide();
      this.circlesListLoaders[index] = loader ;
    }
  }
}
</script>

<style lang="css" scoped>
</style>