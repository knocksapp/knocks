<template>
	<div>
		 <knocksretriver
    v-model=  "group_files"
    url = "get_group_files"
    :xdata="{group_id : group_id}"
    >
    </knocksretriver>
    <div class="row" v-if="group_files != null">
    	<ul class="uk-list uk-list-divider" uk-margin>
       <li v-for = "file in group_files.response"><knocksfileviewer :file="file"></knocksfileviewer></li>
       </ul>   
    </div>
	</div>
</template>

<script>
export default {

  name: 'knocksgroupfiles',
  props : {
    group_id : {
    	type : Number,
    	required : true
    }
  },
  data () {
    return {
      group_files : null,
    }
  },
  methods : {
  	asset(url){
        return window.Asset(url);
       },
  }
}
</script>

<style lang="css" scoped>
</style>