<template>
<div :class = "[{'row' : !tiny } , {'row white knocks_gray_border knocks_tinny_border_radius ' : tiny}] ">
    <div class="col s12">
         <p class = "knocks_text_ms center knocks_text_dark" v-if = "tiny">
      <span class = "knocks-puzzle"></span>
      <static_message msg = "Add a hobby"></static_message>
    </p>
        <knockselselect
        :feeds = "[
        { label : 'Writing' , icon : 'knocks-feather3' , value : 'Writing'} ,
        { label : 'Drawing' , icon : 'knocksapp-brush' , value : 'Painting'} ,  
        { label : 'Reading' , icon : 'knocksapp-bookmark4' , value : 'Reading'} ,     
        { label : 'Chess' , icon : 'knocks-strategy' , value : 'Chess'} ,  
        { label : 'Quotes' , icon : 'knocks-quote' , value : 'Quotes'} ,
        { label : 'Articles' , icon : 'knocks-newspaper-o' , value : 'Darts'} ,
        { label : 'Poetry' , icon : 'knocks-pen3' , value : 'Poetry'} ,
        { label : 'Stories' , icon : 'knocks-book10' , value : 'Stories'} , 
        { label : 'Coding' , icon : 'knocks-develop' , value : 'Coding'} , 
        { label : 'Science' , icon : 'knocks-lab4' , value : 'Science'} , 
        { label : 'Cooking' , icon : 'knocksapp-chop' , value : 'Cooking'} , 
        { label : 'Photography' , icon : 'knocksapp-photograph2' , value : 'Photography'} ,
        { label : 'Singing' , icon : 'knocksapp-microphone' , value : 'Singing'} ,
        { label : 'Piano' , icon : 'knocks-piano' , value : 'Piano'} , 
        { label : 'Music' , icon : 'knocks-music6' , value : 'Music'} , 
        { label : 'Fashion' , icon : 'knocks-t-shirt' , value : 'Fashion'} ,
        { label : 'Shopping' , icon : 'knocks-shop3' , value : 'Shopping'} ,
        { label : 'Antiques' , icon : 'knocks-diamond4' , value : 'Antiques'} ,    
        { label : 'Travilling' , icon : 'knocks-navigation3' , value : 'Travilling'} ,
        
        ]"
        allow_create
        fill_from = "hobby/all"
        v-model = "name"
        is_required
        icon = "knocks-puzzle"
        :error_mixins = "[{ key : 'is_required' , mixin : { msg : 'You need to write the hobby name.' , icon : 'knocks-alert-circle' } }]"
        :max_len = "70"
        :min_len = "2"
        general_icon = "knocks-tag-add"
        placeholder = "Hobby's name"
        :scope = "['hobby_adder'+_uid]"></knockselselect>
    </div>
    <div class = "col s12 knocks_mp_top_margin">
        <knockselbutton
        placeholder = "Add"
        type = "primary"
        class = "right"
        :error_at = []
        :scope = "['hobby_adder'+_uid]"
        validation_error = "You need to complete some fields"
        reset_on_success
        submit_at = "hobby"
        computed_response
        success_msg = "Hobby Added"
        gid = "stage_one_net"
        :submit_data = " { name : name} "
        computed_response
        @knocks_submit_accepted = "passToParent($event)">
        </knockselbutton>
    </div>
</div>
</div>
</template>
<script>
export default {
  name: 'knocksuserhobby',
  props : {
    tiny : {
        type : Boolean , 
        default : false 
    }
  },
  methods:{
        passToParent(e){
            let ob = e.submit_data ;
            ob.id = e.response;
            this.$emit('knocks_hobby_submited' , ob );
        }
  },
  mounted(){
  },
  data() {
      return {
        name : ''
      };
    },
    computed : {
        }
    }
</script>
<style lang="css" scoped>
</style>
