<template>
	<div>
		 <knocksretriver
    v-model=  "group_pictures"
    url = "get_group_pictures"
    :xdata="{group_id : group_id}"
    >
    </knocksretriver>
    <div class="row" v-if="group_pictures != null">
    	<ul class="uk-thumbnav" uk-margin>
       <li class="col s4" v-for="pic in group_pictures.response"><knocksimg :src = "asset('media/image/retrive/'+pic)" ></knocksimg></li>
       </ul>   
    </div>
	</div>
</template>

<script>
export default {

  name: 'knocksgrouppictures',
  props : {
    group_id : {
    	type : Number,
    	required : true
    }
  },
  data () {
    return {
     group_pictures : null,
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