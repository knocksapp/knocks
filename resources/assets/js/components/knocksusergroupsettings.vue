<template lang="html">
<div>
  <knockselinput
  icon = "knocks-search-2"
  autocomplete
  :autocomplete_start="0"
  placeholder="Search"
  autocomplete_from = "group/search"
  @input = "refreshGroupContent()"
  @autocomplete="searchUsers = $event; userShowKey = 3" >
  </knockselinput>
      <div class = " center row knocks_house_keeper"  :class = "[{'animated zoomOut' : groupSearchResult != null} ,{'animated zoomIn' : groupSearchResult == null} ]">
        <h1 class = "grey-text">
          <span class = "knocks-search6 animated swing infinite"></span>
          <static_message msg = "Start searching!"></static_message>
        </h1>
      </div>
</div>

</template>

<script>
export default {
  data() {
      return {
       groupSearch : '',
       groupSearchResult : null ,
     };
   },
   methods:{

   	refreshGroupContent(){
   		App.$emit('KnocksContentChanged')
   	},
}
}
</script>

<style lang="css">
</style>
