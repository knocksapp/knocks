<template>
<div :class = "[{'row' : !tiny } , {'row white knocks_gray_border knocks_tinny_border_radius ' : tiny}] ">
    <div class="col s12">
         <p class = "knocks_text_ms center knocks_text_dark" v-if = "tiny">
      <span class = "knocks-checkered-flag"></span>
      <static_message msg = "Add a sport"></static_message>
    </p>
        <knockselselect
        :feeds = "[
        { label : 'Football' , icon : 'knocks-soccer-ball2' , value : 'Football'} ,
        { label : 'Basketball' , icon : 'knocks-basketball3' , value : 'Basketball'} ,
        { label : 'Baseball' , icon : 'knocks-baseball-set' , value : 'Baseball'} ,
        { label : 'Tennis' , icon : 'knocks-tennis-ball3' , value : 'Tennis'} ,
        { label : 'Billiard' , icon : 'knocks-billiard-ball2' , value : 'Billiard'} ,      
        { label : 'Volleyball' , icon : 'knocks-volleyball' , value : 'Volleyball'} ,
        { label : 'American Football' , icon : 'knocks-football' , value : 'American Football'} ,
        { label : 'Weights Lifting' , icon : 'knocks-weights2' , value : 'Weights Lifting'} ,
        { label : 'Table Tennis' , icon : 'knocks-table-tennis' , value : 'Table Tennis'} ,
        { label : 'Hockey' , icon : 'knocks-hockey-stick' , value : 'Hockey'} ,
        { label : 'Golf' , icon : 'knocks-golf' , value : 'Golf'} ,
        { label : 'Boxing' , icon : 'knocks-boxing-glove' , value : 'Boxing'} ,
        { label : 'Water Volley' , icon : 'knocks-volleyball-water' , value : 'Water Volley'} ,
        { label : 'Racing' , icon : 'knocks-checkered-flag' , value : 'Racing'} ,
        { label : 'Sailing' , icon : 'knocks-sailing-boat-water' , value : 'Sailing'} ,
        { label : 'Darts' , icon : 'knocks-target-arrow' , value : 'Darts'} ,
        { label : 'Ice Skating' , icon : 'knocks-ice-skate' , value : 'Ice Skating'} ,
        { label : 'Bowling' , icon : 'knocks-bowling-ball' , value : 'Bowling'} ,
        ]"
        allow_create
        fill_from = "sport/all"
        v-model = "name"
        is_required
        icon = "knocks-document-edit"
        :error_mixins = "[{ key : 'is_required' , mixin : { msg : 'You need to write the sport name.' , icon : 'knocks-alert-circle' } }]"
        :max_len = "70"
        :min_len = "2"
        general_icon = "knocks-tag-add"
        placeholder = "Sport's name"
        :scope = "['sport_adder'+_uid]"></knockselselect>
    </div>
    <div class = 'col s12 knocks_mp_top_margin'>
        <knockselbutton
        placeholder = "Add"
        type = "primary"
        class = "right"
        :error_at = []
        :scope = "['sport_adder'+_uid]"
        validation_error = "You need to complete some fields"
        reset_on_success
        submit_at = "sport"
        computed_response
        success_msg = "Sport added successfully."
        gid = "stage_one_net"
        :submit_data = " { name : name} "
        @knocks_submit_accepted = "passToParent($event)">
        </knockselbutton>
    </div>
</div>
</div>
</template>
<script>
export default {
  name: 'knocksusersport',
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
            this.$emit('knocks_sport_submited' , ob );
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
