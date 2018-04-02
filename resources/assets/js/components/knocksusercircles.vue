<template>
<div>
  <knocksretriver
  v-model=  "circlesRetriver"
  url = "circle/search"
  @success="circles = $event.response; refreshContent()"
  :xdata = "{ q : search }"
  :scope = "['sidebar_circle_search']"
  >
  </knocksretriver>
  <static_message msg = "search for circles .." v-model = "searchPlaceHolder" class = "knocks_hidden"></static_message>
  
  <div class="row">
    <div class="row knocks_fair_bounds">
      <div class="ui icon input fluid">
        <input type="text" :placeholder="searchPlaceHolder" @input = "searchForCircles()" v-model = "search">
        <i class="search icon"></i>
      </div>
    </div>
    <div class = "row">
      <ul class= "uk-list uk-list-divider">
        <li v-for="(circle,index) in circles" class="knocks_text_dark knocks_fair_bounds" v-if = "index < userShowKey">
          <knockscirclechip :circle = "circle" v-model = "circlesModels[index]"></knockscirclechip>
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
      	<knocksquickcircleadder v-model="circleAdder" :scope = "['sidebar_cirlce_adder']"></knocksquickcircleadder>
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
    }
  },
  methods : {
  	searchForCircles(){
  		App.$emit('knocksRetriver' , { scope : ['sidebar_circle_search'] })
  	},
  	refreshContent(){
  		App.$emit('KnocksContentChanged')
  	}
  }
}
</script>

<style lang="css" scoped>
</style>