<template>
    <div class = "row">
    <div class="col s12 l4">
        <knockselinput
        el_follower
        :mat_follower=  "false"
        placeholder = "sport ?"
                is_required
        gid = "q"
        :max_len = "15"
        v-model = "name"
        :scope = "[ 'sport_adder']"
        ></knockselinput>
    </div>
    <knockselbutton
    placeholder = "Done!"
    :error_at = []
    :scope = "['sport_adder']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "sport"
    computed_response
    success_msg = "sport Added"
    gid = "stage_one_net"
    :submit_data = " { name : name} "
        @knocks_submit_accepted = "passToParent($event)">
    >
    </knockselbutton>
</div>
     </div>
</template>
<script>
export default {
  name: 'knocksusersport',
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
