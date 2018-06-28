<template lang="html">

<div>
  <knocksretriver
  url = "getlog"
  v-model="log_request"
  :xdata = "{id : log_id}"
  @success="retLog()"
  >
  </knocksretriver>
</div>

</template>

<script>
export default {
  name: 'knockscandysessionlogs',
  props:{
    log_id :{
      type : Number,
      required : true
    }
  },
  data () {
    return {
      log_info : null,
      log_request : null,

    }
  },
  methods:{
    retLog(){
      const vm = this;
      vm.log_info = JSON.parse(vm.log_request.response);
    }
  }
}

</script>

<style lang="css">
</style>
