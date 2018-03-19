<template>
	  <el-dropdown trigger="click" class = "right">
      <span class="el-dropdown-link">
        <knockspopover>
      <template slot = "container">
        <i class=" knocks_icon knocks-more-horizontal knocks_text_anchor knocks_text_dark knocks_text_lmd"></i>
      </template>
       <span slot = "content"  class = "knocks_tooltip animated flipInX left" >
        <span class = "knocks-more-horizontal "></span>
        <static_message msg = "More Options"></static_message> 
      </span>
      </knockspopover>
      </span>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item v-if="userId == knockObject.user_id">
         <div>
          <span class = "knocks-trashcan4 knocks_icon_border blue-text"></span>
          <static_message msg = "Edit" classes="blue-text"></static_message>
        </div>
        </el-dropdown-item>
         <el-dropdown-item v-if="userId == knockObject.user_id">
         <div>
          <span class = "knocks-pencil9 knocks_icon_border red-text"></span>
          <static_message msg = "Delete" classes="red-text"></static_message>
        </div>
        </el-dropdown-item>
        <el-dropdown-item v-if = "ownerObject != null && !ownerObject.thatsMe" >
         <div class ="teal-text text-accent-4">
          <span class = "knocks-star3 knocks_icon_border  teal-text text-accent-4"></span>
          <static_message msg = "See" classes="teal-text text-accent-4"></static_message> {{ownerObject.name}} 
          <static_message msg = "first" classes="teal-text text-accent-4"></static_message>
        </div>
        </el-dropdown-item>
        <el-dropdown-item>
         <div>
          <span class = "knocks-minus-circle2 knocks_icon_border orange-text text-lighten-1"></span>
          <static_message msg = "Hide this time" classes= "orange-text text-lighten-1"></static_message>
        </div>
        </el-dropdown-item>
        <el-dropdown-item>
         <div>
          <span class = "knocks-trash5 red-text text-accent-2 knocks_icon_border"></span>
          <static_message msg = "Hide always" classes="red-text text-accent-2"></static_message>
        </div>
        </el-dropdown-item>
        <el-dropdown-item>
         <div>
          <span class = "knocks-shield4 knocks_icon_border  deep-orange-text text-accent-3"></span>
          <static_message msg = "Report" classes="deep-orange-text text-accent-3"></static_message>
        </div>
        </el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
</template>

<script>
export default {

  name: 'knocksknockoptions',

  data () {
    return {

    }
  }
}
</script>

<style lang="css" scoped>
</style>