<template>
<div>
	<ul :class = "list_classes"  v-if ="show_input.length > 0">
		<li
			v-for = "(item , index) in show_input"
			v-if = "show_input.length != 0"
			:key = "index"
			:class = "[ list_item_class , {'animated slideOutUp knocks_hidden' : index >= showKey} , {'animated slideInUp' : index < showKey}]">
      <slot :name = "'append_'+index"></slot>
			<knocksuser
			class = "animated slideInLeft"
			v-if = "index < showKey && show_scope == 'user'"
			:user = "item"
      :as_label = "as_label"
      :as_chip = "as_chip"
      :extended = "extended"
      :as_result = "as_result"
			:blocker = "blocker"
      :main_container = "main_container"
			:show_accept_shortcut = "show_accept_shortcut"
			>
        <div slot = "append_to_name" v-if = "inners">
          <slot :name = "'inner_'+index"></slot>
        </div>   
      </knocksuser>
        <knocksblockuser :blocked_user_id = "item" v-if = "index < showKey && show_scope == 'block'"></knocksblockuser>
      <knocksgroupshortcut as_chip :group_id = "item" v-if = "index < showKey && show_scope == 'group'"></knocksgroupshortcut>
      <knocksshowdevice :device = "item" v-if = "index < showKey && show_scope == 'device'"></knocksshowdevice>
      <knocksdateviewer :date = "item.date" v-if = "index < showKey && show_scope == 'datefilter'"></knocksdateviewer>
      <knocksdateviewer :date = "item" v-if = "index < showKey && show_scope == 'date'"></knocksdateviewer>
      <knockshashtagchip :hashtag = "item" v-if = "index < showKey && show_scope == 'hashtag'"></knockshashtagchip>
      <knocksaddressviewer :address = "item" v-if = "index < showKey && show_scope == 'address'"></knocksaddressviewer>
      <knockscandysessionkidslog :kid_id="item" v-if = "index < showKey && show_scope == 'kidlog'"></knockscandysessionkidslog>
      <knockscandysessionlog :log = "item" v-if = "index < showKey && show_scope == 'candylog'"></knockscandysessionlog>
      <slot :name = "index"></slot>
		</li>
	</ul>
  <center  v-if = "show_input.length == 0 && !hide_on_empty">
  <span :class = "empty_classes" class = "animated slideInUp">
    <span :class = "empty_icon"></span>
    <static_message :msg = "empty_message"></static_message>
  </span>
</center>
  <p  v-if = "!hide_count" class = "grey-text text-lighten-22">{{showKeyMin+'/'+show_input.length}}</p>
	<div :class = "status_classes" v-if ="show_input.length >= show_key">
		<a :class ="[{'knocks_hidden':!(show_input.length > showKey)}]" @click = "showKey += show_key">
			<static_message :msg = "see_messages.more"></static_message>
		</a>
		<a :class ="[{'knocks_hidden':!(showKey > show_key && show_input.length > show_key)}]" class = "right" @click = "showKey -= show_key">
			<static_message :msg = "see_messages.less"></static_message>
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
  		type : [String, Array , Object] ,
  		default : 'uk-list uk-list-striped knocks_gray_border knocks_tinny_border_radius'
  	},
    main_container : {
      type : String , 
      default : 'row animated fadeIn'
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
    list_item_class : {
      type : [String, Array , Object] ,
      default : ''
    },
    empty_icon : {
      type : [String, Array , Object] ,
      default : 'knocksapp-prick2'
    },
    empty_classes : {
      type : [String, Array , Object] ,
      default : 'grey-text text-darekn-1 knocks_text_md center'
    },
    unsortable : {
      type : [String , Boolean]
    },
    hide_count : {
      type : Boolean , 
      default : false
    },
    see_messages : {
      type : Object , 
      default : ()=>{
        return {
          more : 'See More' , 
          less : 'See Less'
        }
      }
    },
    inners : {
      type : Boolean , 
      default : false 
    },
    status_classes : {
      type : [Array , Object , String] , 
      default : 'row'
    },
    hide_on_empty : {
      type : Boolean , 
      default : false
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
    sortable(){
      return this.unsortable ? false : 'cls-custom: uk-box-shadow-small uk-flex uk-flex-middle uk-background' 
    }
  },
  methods : {

  }
}
</script>

<style lang="css" scoped>
</style>
