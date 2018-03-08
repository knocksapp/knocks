<transition enter-active-class = "animated slideInRight" leave-active-class = "animated slideOutRight">
<ul id = "knocks_rightbar" class = "knocks_house_keeper fixed  grey lighten-5" v-if = "showRightSideBar" >
  
  <div class="force-overflow"></div>




    <el-tabs v-model = "rightSideBarMainTabs" class = "knocks_house_keeper">
    <el-tab-pane name="chat" class = "knocks_house_keeper">
    	 <span slot = "label">
    	 	<el-tooltip class="knocks_tabs_item" effect="dark"  placement="bottom-end">
    	 		<span slot = "content">
	 			  <span class = "knocks-chat"></span>
				  <static_message msg = "Chatting"></static_message>
    	 		</span>
    		   <span class = "knocks-chat"></span>
    	   </el-tooltip>
    	</span>
      <knockschattingzone></knockschattingzone>
    </el-tab-pane>
    <el-tab-pane  name="balloons">
      <span slot = "label">
	   <el-tooltip class="knocks_tabs_item" effect="dark"  placement="bottom-end">
	 		<span slot = "content">
 			  <span class = "knocks-balloon"></span>
			  <static_message msg = "Balloons"></static_message>
	 		</span>
		   <span class = "knocks-balloon"></span>
	   </el-tooltip>
	 </span>
    </el-tab-pane>
    <el-tab-pane label="Config" name="friendreq">
     <span slot = "label">
	   <el-tooltip class="knocks_tabs_item" effect="dark"  placement="bottom-end">
	 		<span slot = "content">
 			  <span class = "knocks-user-add-outline"></span>
			  <static_message msg = "Friendship Requests"></static_message>
	 		</span>
		   <span class = "knocks-user-add-outline"></span>
	   </el-tooltip>
	  </span>  	
    </el-tab-pane>
  </el-tabs>
  </div>
</ul>
</transition>