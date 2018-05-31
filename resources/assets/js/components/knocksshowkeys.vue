<template>
<div>
	<ul :class = "list_classes" uk-sortable="cls-custom: uk-box-shadow-small uk-flex uk-flex-middle uk-background" v-if ="show_input.length > 0">
		<li
			v-for = "(item , index) in show_input"
			v-if = "show_input.length != 0"
			:key = "index"
			:class = "[{'animated slideOutUp knocks_hidden' : index >= showKey} , {'animated slideInUp' : index < showKey}]">
			<knocksuser
			class = "animated slideInLeft"
			v-if = "index < showKey && show_scope == 'user'"
			:user = "item"
      :as_label = "as_label"
      :as_chip = "as_chip"
      :extended = "extended"
      :as_result = "as_result"
			:blocker = "blocker"
			:show_accept_shortcut = "show_accept_shortcut"
			  ></knocksuser>
        <knocksblockuser :blocked_user_id = "item" v-if = "index < showKey && show_scope == 'block'"></knocksblockuser>
      <knocksgroupshortcut as_chip :group_id = "item" v-if = "index < showKey && show_scope == 'group'"></knocksgroupshortcut>
		</li>
	</ul>
  <center  v-else>
  <span :class = "empty_classes" class = "animated slideInUp">
    <span :class = "empty_icon"></span>
    <static_message :msg = "empty_message"></static_message>
  </span>
</center>
  <p class = "grey-text text-lighten-22">{{showKeyMin+'/'+show_input.length}}</p>
	<div class = "row">
		<a :class ="[{'knocks_hidden':!(show_input.length > showKey)}]" @click = "showKey += show_key">
			<static_message msg = "See More"></static_message>
		</a>
		<a :class ="[{'knocks_hidden':!(showKey > show_key && show_input.length > show_key)}]" class = "right" @click = "showKey -= show_key">
			<static_message msg = "See Less"></static_message>
		</a>
	</div>
</div>
</template>

<script>
export default {

  name: 'knocksshowkeys',
  props : {
  	show_key : {
  		type : Number ,
  		default : 3 ,
  	},
  	show_scope : {
  		type : String ,
  		default : 'user'
  	},
  	show_input : {
  		type : Array ,
  		default : null ,
  	},
  	list_classes : {
  		type : String ,
  		default : 'uk-list uk-list-striped knocks_gray_border knocks_tinny_border_radius'
  	},
		show_accept_shortcut: {
      type : Boolean ,
      default : false
    },
    as_result : {
      type : Boolean ,
      default : false
    },
    as_label : {
      type : Boolean ,
      default : true ,
    },
		blocker : {
      type : Boolean ,
      default : false
    },
    as_chip : {
      type : Boolean ,
      default : false
    },
    extended : {
      type : Boolean ,
      default : false
    },
    empty_message : {
      type : String ,
      default : 'Empty..'
    },
    empty_icon : {
      type : String ,
      default : 'knocksapp-prick2'
    },
    empty_classes : {
      type : String ,
      default : 'grey-text text-darekn-1 knocks_text_md center'
    }
  },
  data () {
    return {
    	showKey : 0 ,
    }
  },
  mounted(){
  	this.showKey = this.show_key
		const vm = this
		//Events
	
  },
  computed : {
    showKeyMin(){
      return Math.min(this.showKey , this.show_input.length)
    },
  },
  methods : {

  }
}
</script>

<style lang="css" scoped>
</style>
