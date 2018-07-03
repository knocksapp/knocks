<template lang="html">
<div>
  <knockscollapse 
  title= "My Kids" 

  icon = "knocks-child"
  comment = "See your kids activities"
  @control = "collapse = $event" 
  toggle_on_mount
  regular_class = "knocks_text_md amber-text text-darken-2"
  active_class = "knocks_text_md amber-text text-darken-2"
  side_count_classes = "right blue knocks_standard_border_radius knocks_fair_bounds white-text" >

  <div slot = "content" class = "knocks_gray_border knocks_xs_padding knocks_tinny_border_radius knocks_mp_margin_top" v-loading = "myKids.loading" element-loading-spinner="el-icon-loading ">
    <knocksretriver
    url = "get/my_kids"
    v-model="myKids"
    @success="myKidsNow()"
    >
    </knocksretriver>
    <knocksshowkeys 
      list_classes = "row knocks_content_padding uk-list uk-list-divider"
      list_item_class = ""
    :show_input = "kids" show_scope = "kidlog" v-if = "kids"></knocksshowkeys>
  </div>
  </knockscollapse>
</div>
</div>
</template>

<script>
export default {
  name: 'knockscandysessionlogs',
  data () {
    return {
      myKids : { loading : false },
      kids : null , 
      myCount : null ,
      collapse : null ,
    }
  },
  methods : {
      myKidsNow(){
        const vm = this;
        vm.kids = vm.myKids.response;
        vm.myCount = vm.myKids.response.length
        vm.collapse.changeCount(vm.myCount)
      }
  }

}
</script>

<style lang="css">
</style>
