<template>
    <div class = "row">
    <div class="col s12 l4">
        <knockselinput
        el_follower
        :mat_follower=  "false"
        placeholder = "Hobby ?"
                is_required
        gid = "q"
        :max_len = "15"
        v-model = "name"
        :scope = "[ 'hobby_adder']"
        ></knockselinput>
    </div>
    <knockselbutton
    placeholder = "Done!"
    :error_at = []
    :scope = "['hobby_adder']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "hobby"
    computed_response
    success_msg = "Hobby Added"
    gid = "stage_one_net"
    :submit_data = " { name : name} "
    computed_response
    @knocks_submit_accepted = "passToParent($event)">
    >
    </knockselbutton>
</div>
     </div>
</template>
<script>
export default {
  name: 'knocksuserhobby',
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
