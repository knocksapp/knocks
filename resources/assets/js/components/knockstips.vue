<template lang="html">
<div>
  <knockscollapse
  toggler_container = "knocks_gray_background row knocks_margin_keeper knocks_tinny_padding"
  toggle_on_mount
  title="Tips" icon = "knocks-lamp4">
    <el-carousel slot = "content" :interval="5000" arrow="never" class = "knocks_car" height="300px" >
      <el-carousel-item style = "background-color :#f5f5f5 " class= "">
        <div class = "row">
        <p class = " knocks_tinny_padding ">
          <span class = "knocks-atom2 " style = "font-size : 50px; color : #00bfa5;">  </span>
          <static_message style = "font-size : 30px; color : #00bfa5;" msg = "Circles"></static_message>
        </p>
      </div>
      <div class = "row">
         <p class = "knocks_text_md knocks_tinny_padding ">
    <static_message style = " color : #00bfa5;" msg = "Knocks help you to Categorize your people into Circles,
    this could make it much easier to communicate with a lot of people at the same time. "></static_message> </p>
      </div>
     </el-carousel-item>
       <el-carousel-item class="blue-gray-text"style = "background-color : #f5f5f5" >
    <div class = "row">
         <p class = "knocks_text_ms knocks_tinny_padding ">
           <span class = "knocks-atom2 " style = "font-size : 50px; color : #ff8a80;">  </span>
           <span class = "knocks-shield blue-text text-lighten-2"style = "font-size : 40px; margin-left : -30px;"></span>
           <static_message style = "font-size : 30px; color : #ff8a80;" msg = "Privacy Settings"></static_message>
         </p>
       </div>
       <div class = "row">
          <p class = "knocks_text_ms knocks_tinny_padding ">
    <static_message style = " color : #ff8a80;" msg = "It is important to start categorizing who can see your knocks, comments and replies or not by
    customizing your presets also customize people's comments and replies if they can see each other comments and replies or not."></static_message> </p>
       </div>
      </el-carousel-item>
      <el-carousel-item style = "background-color :#f5f5f5">
        <div class = "row">
        <p class = "knocks_text_ms amber-text text-darken-2 knocks_tinny_padding">
          <button class = "btn btn-floating waves-effect pulse knocks_color_kit knocks_voice_commands_btn">
          <span class = " knocks_text_bold knocks-knocks-circle-core"></span>
          </button>
          <static_message style = "font-size : 30px; color : #922459;" msg = "Voice commands"></static_message>
        </p>
      </div>
      <div class = "row">
         <p class = "knocks_text_md knocks_tinny_padding ">
    <static_message style = " color : #922459;" msg = "Now you can post a knock, search for a friend, visit your own profile or friend profile,
    go to your settings, logout and create circles by giving orders with your voice."></static_message> </p>
      </div>
     </el-carousel-item >
     <el-carousel-item style ="background-color : #f5f5f5">
       <div class = "row">
       <p class = "knocks_text_ms amber-text text-dark knocks_tinny_padding">
         <span class = "knocks-microphone-3 " style = "font-size : 50px; color : #e91e63;">  </span>
         <static_message style = "font-size : 30px; color : #e91e63;" msg = "Record your Knocks"></static_message>
       </p>
     </div>
     <div class = "row">
        <p class = "knocks_text_md knocks_tinny_padding ">
    <static_message style = " color : #e91e63;" msg = "Using your voice would be much easier,
    that's why Knocks provide you with recording a Knock and also can transform what you said into text."></static_message> </p>
     </div>
    </el-carousel-item>

    </el-carousel>
  </knockscollapse>
</div>
</template>

<script>
export default {
}
</script>

<style lang="css">
/* .knocks_car {
  height: 200px ;
} */

.el-carousel__item h3 {
   color: #475669;
   font-size: 14px;
   opacity: 0.75;
   line-height: 200px;
   margin: 0;
 }

.knocks_voice_commands_btn{
    z-index: 700000000000000000000000001;
    width: 70px;
    height: 70px;
    line-height: 70px;
    border : 1px solid pink !important;
}
.knocks_voice_commands_btn > span {
      line-height: 68px;
      font-size : 300% !important
}
</style>
