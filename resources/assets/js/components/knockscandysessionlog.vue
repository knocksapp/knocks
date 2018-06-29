<template lang="html">

<div>
  <knocksretriver
  url = "getlog"
  v-model="log_request"
  :xdata = "{id : log_id}"
  @success="retLog()"
  >
  </knocksretriver>
  <div class="col s12" v-if="log_info != null">
    <h4 class="ui horizontal divider header" style="background-color : transparent !important;" v-if="log_info.type == 'group'">
                <i class="knocks-group2 icon"></i>
                Group
              </h4>
          <div class="ui list knocks_fair_bound" v-if="log_info != null">
            <div class="item knocks_fair_bound" v-if="log_info.type == 'group'">
              
              <div class="content col s12">
                <a class="header"><knocksuser :user="kid_id" as_name></knocksuser></a>
                <div class="description col s12" v-if="log_info != null">
                  <div style="margin-left : 5% !important;">
                   <h6 class="grey-text"> Has joined this Group</h6>
                 </div>
                  <knocksgroupshortcut style="margin-left : 10% !important;" :group_id="log_info.type_id" as_chip></knocksgroupshortcut>
                </div>
              </div>

            </div>
            
            <h4 class="ui horizontal divider header" style="background-color : transparent !important;" v-if="log_info.type == 'knock'">
                <i class="knocks-knocks icon"></i>
                Knock
              </h4>
            <div class="item row knocks_fair_bound" v-if="log_info.type == 'knock'">
              
              <div class="content col s12">
                <a class="header"><knocksuser :user="kid_id" as_name></knocksuser></a>
                <div class="description col s12 knocks_fair_bound" v-if="log_info != null">
                  <div style="margin-left : 5% !important;">
                   <h6 class="grey-text">Wrote this Knock </h6>
                 </div>
                  <knocksknock
                   :knock = "log_info.type_id" 
                   :gid="'log'+log_id"
                   class="col s12"
                   :current_user = "auth"
                    replier_message = "Leave a comment"> 
                    </knocksknock>
                </div>
              </div>
            </div>
            <h4 class="ui horizontal divider header" style="background-color : transparent !important;" v-if="log_info.type == 'comment'">
                <i class="knocks-knocks icon"></i>
                Comment
              </h4>
            <div class="item row knocks_fair_bound" v-if="log_info.type == 'comment'">
              
              <div class="content col s12">
                <a class="header"><knocksuser :user="kid_id" as_name></knocksuser></a>
                <div class="description col s12 knocks_fair_bound" v-if="log_info != null">
                  <div style="margin-left : 5% !important;">
                   <h6 class="grey-text">Wrote this Comment </h6>
                 </div>
                  <knocksknock
                    :knock = "log_info.knockid" 
                    :gid="'log'+log_id"
                    class="col s12"
                    :comments_to_show = "[log_info.commentid]" :show_reply_on_mount = "false"
                    :show_comment_reply_on_mout = "true"
                    :current_user = "auth"
                    replier_message = "Leave a comment"> 
                    </knocksknock>
                </div>
              </div>
            </div>
               <h4 class="ui horizontal divider header" style="background-color : transparent !important;" v-if="log_info.type == 'friendRequest'">
                <i class="knocks-plus icon"></i>
                Friend Request
              </h4>
            <div class="item row knocks_fair_bound" v-if="log_info.type == 'friendRequest'">
              
              <div class="content col s12">
                <a class="header"><knocksuser :user="kid_id" as_name></knocksuser></a>
                <div class="description col s12 knocks_fair_bound" v-if="log_info != null">
                  <div style="margin-left : 5% !important;">
                   <h6 class="grey-text">Send a Friend Request to  </h6>
                   <knocksuser as_result :user="log_info.type_id"></knocksuser>
                 </div>
                </div>
              </div>
            </div>
                  <h4 class="ui horizontal divider header" style="background-color : transparent !important;" v-if="log_info.type == 'reply'">
                <i class="knocks-knocks icon"></i>
                Reply
              </h4>
            <div class="item row knocks_fair_bound" v-if="log_info.type == 'reply'">
              
              <div class="content col s12">
                <a class="header"><knocksuser :user="kid_id" as_name></knocksuser></a>
                <div class="description col s12 knocks_fair_bound" v-if="log_info != null">
                  <div style="margin-left : 5% !important;">
                   <h6 class="grey-text">Wrote this Reply </h6>
                 </div>
                  <knocksknock
                    :knock = "log_info.knockid" 
                    :gid="'log'+log_id"
                    class="col s12"
                    :comments_to_show = "[log_info.commentid]" 
                    :replies_to_show = "[log_info.type_id]"
                    :show_reply_on_mount = "false"
                    :show_comment_reply_on_mout = "false"
                    :current_user = "auth"
                    replier_message = "Leave a comment"> 
                    </knocksknock>
                </div>
              </div>
            </div>
            <h4 class="ui horizontal divider header" style="background-color : transparent !important;" v-if="log_info.type == 'friendRequest'">
                <i class="knocks-tick icon"></i>
                 Friends
              </h4>
            <div class="item row knocks_fair_bound" v-if="log_info.type == 'friendRequest'">
              
              <div class="content col s12">
                <a class="header"><knocksuser :user="kid_id" as_name></knocksuser></a>
                <div class="description col s12 knocks_fair_bound" v-if="log_info != null">
                  <div style="margin-left : 5% !important;">
                   <h6 class="grey-text"> is Friend with </h6>
                   <knocksuser as_result :user="log_info.type_id"></knocksuser>
                 </div>
                </div>
              </div>
            </div>
          </div>
  </div>
</div>

</template>

<script>
export default {
  name: 'knockscandysessionlog',
  props:{
    log_id :{
      type : Number,
      required : true
    },
    kid_id:{
      type : Number,
      required : true
    }
  },
  data () {
    return {
      log_info : null,
      log_request : null,
      auth : window.AuthId

    }
  },
  methods:{
    retLog(){
      const vm = this;
      if(vm.log_request.response != null)
      vm.log_info = JSON.parse(vm.log_request.response[0].log);
    }
  }
}

</script>

<style lang="css">
</style>
