<template lang="html">
  <div>
<div style="min-height : 500px">
<div :class = "{ 'knocks_hidden':stageNumber != 1 }">
<img :src="asset('snaps/privacyhelper/kcp1.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div :class = "{ 'knocks_hidden':stageNumber != 2 }">
<img :src="asset('snaps/privacyhelper/kcp2.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div :class = "{ 'knocks_hidden':stageNumber != 3 }">
  <div class = "row">
<img :src="asset('snaps/privacyhelper/kcp3.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div class = "knocks_fair_padding">
  <h4>
      <i class="knocks-cog9 knocks_text_md pink-text text-darken-1"></i>
<static_message msg = "Custom" classes = "knocks_text_ms"  ></static_message>

</h4>
<static_message msg = "While clicking on custom, it will take you directly to CIRCLES tab and USERS tab will be available." classes = "knocks_text_ms"  ></static_message>
</div>
</div>
<div :class = "{ 'knocks_hidden':stageNumber != 4 }">
  <div class = "row">
<img :src="asset('snaps/privacyhelper/kcp4.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div class = "knocks_fair_padding">
  <h4>
      <i class="knocks-eye-slash animated tada knocks_text_md red-text darken-4"></i>
<static_message msg = " Invalid For All" classes = "knocks_text_ms red-text darken-4"  ></static_message>

</h4>
<static_message msg = "Invalid For All button will make all the users in the circle invalid and can't see the knock even." classes = "knocks_text_ms"  ></static_message>
</div>
<div class = "knocks_fair_padding">
  <h4>
      <i class="knocks-eye6 animated rubberBand knocks_text_md green-text" ></i>
<static_message msg = " Valid" classes = "knocks_text_ms green-text"  ></static_message>

</h4>
<static_message msg = "While clicking on Valid button, it will make the knock available to all the usres that are in circle that you chose except users who belongs to `Invalid For All` circles." classes = "knocks_text_ms"  ></static_message>
</div>
<div class = "knocks_fair_padding">
  <h4>
      <i class="knocks-eye-off animated jello knocks_text_md orange-text"></i>
<static_message msg = " Invalid" classes = "knocks_text_ms orange-text"  ></static_message>

</h4>
<static_message msg = "invalid button will make all the users in the circle invalid and can't see the knock but if the user were in another circle and he was valid then he will be able to see the knock." classes = "knocks_text_ms"  ></static_message>
</div>
</div>
<div :class = "{ 'knocks_hidden':stageNumber != 5 }">
  <div class = "row">
<img :src="asset('snaps/privacyhelper/kcp6.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div class = "knocks_fair_padding">
  <h4>
      <i class="knocks-user-outline knocks_text_md " ></i>
<static_message msg = " Users" classes = "knocks_text_ms "  ></static_message>

</h4>
<div>
    <span class = "knocks-eye-off animated rotateIn red-text knocks_circular_border"></span>
    <static_message msg = " Switching on invalid button means that user won't be able to see the knock." classes = "knocks_text_ms "  ></static_message>
  </div>
  <div>
    <span class = "knocks-eye6 animated rubberBand green-text knocks_circular_border"></span>
    <static_message msg = " Switching on valid button means that user will be able to see the knock." classes = "knocks_text_ms "  ></static_message>
  </div>
</div>
</div>
<div :class = "{ 'knocks_hidden':stageNumber != 6 }">
  <div class = "row">
<img :src="asset('snaps/privacyhelper/kcp5.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div class = "knocks_fair_padding">
<h4>
    <i style = "color : #42a5f5;" class="knocks-save knocks_text_md " ></i>
<static_message style = "color : #42a5f5;" msg = " Save Preset" classes = "knocks_text_ms "  ></static_message>
</h4>
<static_message msg = "It will open new page as it showen at Step 7 to start saving your preset. " classes = "knocks_text_ms"  ></static_message>
</div>
<div class = "knocks_fair_padding">
<h4>
    <i  class="knocks-star12 knocks_text_md orange-text" ></i>
<static_message msg = " Set As Default" classes = "knocks_text_ms orange-text"  ></static_message>
</h4>
<static_message msg = "It will open new page as it showen at Step 7 to start saving your preset and also it will make it default." classes = "knocks_text_ms"  ></static_message>
</div>
</div>
<div :class = "{ 'knocks_hidden':stageNumber != 7 }">
  <div class = "row">
<img :src="asset('snaps/privacyhelper/kcp7.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div class = "knocks_fair_padding">
<h4>
<static_message style = "color : #90a4ae;" msg = " Preset Name" classes = "knocks_text_ms "  ></static_message>
</h4>
<static_message msg = "You can type the name of your preset and save it." classes = "knocks_text_ms"  ></static_message>
</div>
</div>
<div :class = "{ 'knocks_hidden':stageNumber != 8 }">
<img :src="asset('snaps/privacyhelper/kcp8.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div :class = "{ 'knocks_hidden':stageNumber != 9 }">
  <div class = "row">
<img :src="asset('snaps/privacyhelper/kcp9.png')" alt="tips" class = " push-s2 l6 push-l3 z-depth-3 knocks_standard_border_radius">
</div>
<div class = "knocks_fair_padding">
<h4>
    <i  class="knocks-heart red-text knocks_text_md" ></i>
<static_message msg = " Choose From My Presets" classes = "knocks_text_ms"  ></static_message>
</h4>
<static_message msg = "You can customize and choose which preset you want to use also you can delete one of your prsests or make one of them as default." classes = "knocks_text_ms"  ></static_message>
</div>
</div>
</div >
<div v-if = "stageNumber == 9" class = "center row ">
  <el-button
  class="knocks_color_kit"
@click = "previous"
  >
  Previous step
</el-button>
<el-button
 class="knocks_color_kit"
@click = "goHome()">
 Finish
</el-button>
</div>
<div v-else  class = "center row ">
  <el-button
  v-if = "stageNumber != 1"
  class="knocks_color_kit"
@click = "previous"
  >
  Previous step
</el-button>
<el-button
class="knocks_color_kit"
@click = "next"
>
Next step
</el-button>
</div>
    <div class = "row knocks_fair_padding">
      <el-steps :space="100" :active="stageNumber" finish-status="success">
    <el-step title="Step 1"></el-step>
    <el-step title="Step 2"></el-step>
    <el-step title="Step 3"></el-step>
    <el-step title="Step 4"></el-step>
    <el-step title="Step 5"></el-step>
    <el-step title="Step 6"></el-step>
    <el-step title="Step 7"></el-step>
    <el-step title="Step 8"></el-step>
    <el-step title="Step 9"></el-step>
  </el-steps>
  </div>
</div>

</template>

<script>
export default {
  name : 'knocksprivacytips',
  data() {
     return {
       stageNumber: 1
     };
   },

   methods: {
     next() {
       if (this.stageNumber++ > 8) this.stageNumber = 0;
     },
     previous() {
       this.stageNumber--;
     },
     asset(url){
       return LaravelOrgin + url
     },
     goHome(){
       window.location.href = this.asset('')
     }
   }
}
</script>

<style lang="css">
.el-step{
  z-index: 2 !important
}

.el-step__title.is-process {
    font-weight: 700;
    color: #ccc !important;
}
.el-step__head.is-process, .el-step__head.is-wait {
    color: #ccc !important;
    border-color: #ccc !important;
}
.el-step__icon.is-icon{
  background-color :  $knocksPrimaryColor ;
  font-size : 250%;
}
</style>
