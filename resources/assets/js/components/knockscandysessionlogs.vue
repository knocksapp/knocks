<template lang="html">
<div>
   <knocksretriver
  url = "get/my_kids"
  v-model="myKids"
  @success="myKidsNow()"
  >
  </knocksretriver>
  <ul class="collapsible">
    <li v-for="(kid,index) in kids">
      <div class="collapsible-header"><i class="knocks-child"></i><knocksuser main_container="col s12" :user="kid"></knocksuser></div>
      <div class="collapsible-body col s12 knocks_fair_bounds"><knockscandysessionkidslog :kid_id="kid"></knockscandysessionkidslog></div>
    </li>
  </ul>
      <div >
     
     
   </div>
</div>

</template>

<script>
export default {
  name: 'knockscandysessionlogs',
  data () {
    return {
      myKids : null,
      kids : null
    }
  },
  methods : {
      myKidsNow(){
        const vm = this;
        vm.kids = vm.myKids.response;
      }
  }

}
</script>

<style lang="css">
</style>
