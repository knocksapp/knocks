<template lang="html">

<div class="row white knocks_fair_bounds knocks_standard_border_radius knocks_gray_border">
  <knocksuser @input = "construct()" :user = "auth" main_container = "row knocks_house_keeper" v-model = "userObject" class="knocks_hidden" >
  </knocksuser>

   <!-- <knockselbutton
   icon = "knocks-pencil8 knocks_text_md"
       class = "right knocks_tinny_margin"
       size = "mini"
       disable_placeholder
       type=""
       button_classes = "knocks_rounded_border"
   @knocks_button_clicked="dialogVisible = true"
   :submit_flag = "false"
   ></knockselbutton> -->

  <div class=" col s12 l8  " v-if ="userObject != null" >
 <!-- <el-dialog
      :visible.sync="dialogVisible"
      center> -->
      <!-- <static_message slot ="title" msg = "User Edit"></static_message> -->

      <div class = "">
      <knockselinput
      placeholder = "First Name"
      is_required
      el_follower
      gid = "qq"
      :mat_follower=  "false"
      has_slot
      :scope = "['user_name_edit']"
      v-model = "first_name"
      :start_as="userObject.first_name"
      >
      <knockselbutton
      submit_at = "user/updatefirstname"
      disable_placeholder
      icon = "knocks-plus"
      success_at = "done"
      :error_at = "[
      { res : 'invalid' , msg : 'You already have a preset with this name.' }
      ]"
      success_msg = "First Name is Updated Successfully"
      gid = "stage_one_net"
      :submit_data = " {first_name : first_name} "
      :scope = "['user_name_edit']"
      @knocks_submit_accepted = "passToParent($event)"

      slot = "aside">
      </knockselbutton>
      </knockselinput>
  </div>
<div class = "">
          <knockselinput
          placeholder = "Middle Name"
          is_required
          el_follower
          gid = "qq"
          :mat_follower=  "false"
          has_slot
          :scope = "['user_mname_edit']"
          v-model = "middle_name"
          :start_as="userObject.middle_name"
          >
          <knockselbutton
          submit_at = "user/updatemiddlename"
          disable_placeholder
          icon = "knocks-plus"
          success_at = "done"
          :error_at = "[
          { res : 'invalid' , msg : 'You already have a preset with this name.' }
          ]"
          success_msg = "Middle Name is Updated Successfully"
          gid = "stage_one_net"
          :submit_data = " {middle_name : middle_name} "
          :scope = "['user_mname_edit']"
          @knocks_submit_accepted = "passToParent($event)"

          slot = "aside">
          </knockselbutton>
          </knockselinput>
          <knocksuserinfodelete
            :userObject="userObject"
            @knocks_info_deleted ="deleteMiddlename(userObject.middle_name)"
            route="usermiddlename"
            message="middlename"
            class="col right"
            >
          </knocksuserinfodelete>
    </div>
    <div class = "">
              <knockselinput 
              placeholder = "Last Name"
              is_required
              el_follower
              gid = "qq"
              :mat_follower=  "false"
              has_slot
              :scope = "['user_lname_edit']"
              v-model = "last_name"
              :start_as="userObject.last_name"
              >
              <knockselbutton
              submit_at = "user/updatelastname"
              disable_placeholder
              icon = "knocks-plus"
              success_at = "done"
              :error_at = "[
              { res : 'invalid' , msg : 'You already have a preset with this name.' }
              ]"
              success_msg = "Last Name is Updated Successfully"
              gid = "stage_one_net"
              :submit_data = " {last_name : last_name} "
              :scope = "['user_lname_edit']"
              @knocks_submit_accepted = "passToParent($event)"

              slot = "aside">
              </knockselbutton>
              </knockselinput>
          </div>
        <div class = "">
                  <knockselinput
                  placeholder = "Nick Name"
                  is_required
                  el_follower
                  gid = "qq"
                  :mat_follower=  "false"
                  has_slot
                  :scope = "['user_nname_edit']"
                  v-model = "nickname"
                  :start_as="userObject.nickname"
                  >
                  <knockselbutton
                  submit_at = "user/updatenickname"
                  disable_placeholder
                  icon = "knocks-plus"
                  success_at = "done"
                  :error_at = "[
                  { res : 'invalid' , msg : 'You already have a preset with this name.' }
                  ]"
                  success_msg = "Nick Name is Updated Successfully"
                  gid = "stage_one_net"
                  :submit_data = " {nickname : nickname} "
                  :scope = "['user_nname_edit']"
                  @knocks_submit_accepted = "passToParent($event)"

                  slot = "aside">
                  </knockselbutton>
                  </knockselinput>
                </div>
                <div class="row">
              <div class = "col s12 knocks_house_keeper">
                <div class = "col s11 knocks_house_keeper">
        <div class=" col knocks_house_keeper">
          <el-date-picker

            v-model="birthdate"
            type="date"
            placeholder="Birthdate"
          >
       </el-date-picker>
                  <knockselbutton
                  submit_at = "user/updatebirthdate"
                  disable_placeholder
                  icon = "knocks-plus"
                  class = "right"
                  success_at = "done"
                  :error_at = "[
                  { res : 'invalid' , msg : 'You already have a preset with this name.' }
                  ]"
                  success_msg = "Birthdate is Updated Successfully"
                  gid = "stage_one_net"
                  :submit_data = " {birthdate : birth_e} "
                  :scope = "['user_bd_edit']"
                  button_classes = "knocks_right_button"
                  style = "
                  background-color: #fbfdff;
                  color: #97a8be;
                  border: 1px solid #bfcbd9;

                   "
                  @knocks_submit_accepted = "passToParent($event)"
                  slot = "aside">
                  </knockselbutton>

                </div>
</div></div></div>
<div class="row">
  <div class =" col knocks_tinny_padding knocks_standard_border_radius knocks_gray_border" >
<span >
  <static_message msg = "Gender" ></static_message>

</span>
</div>

 <knockstaps
 main_container="col "
 :multiple = "false"
  v-model="gender"
  :scope = "['user_gender_edit']"
  anchor_active_class = "blue white-text"
  anchor_regular_class = "white blue-text knocks_sm_side_padding"
  anchor_class ="btn  knocks_noshadow_ps knocks_gray_border"
 :options = "knocksTapsDevOptionss" >
   </knockstaps>

   <knockselbutton
   placeholder = "Upgrade Gender"
   :error_at = "[
   { res : 'invalid' , msg : 'You already have a preset with this name.' }
   ]"
   :scope = "['user_gender_edit']"
   class = "right"

   validation_error = "You need to complete some fields"
   success_at = "done"
   submit_at = "user/updategender"
   success_msg = "Gender is Updated Successfully"
   gid = "stage_one_net"
   :submit_data = " {gender : gender} "
   style = "
   background-color: #fbfdff;
   color: #97a8be;
   border: 1px solid #bfcbd9;

    "
   @knocks_submit_accepted = "passToParent($event)"
   >
   </knockselbutton>

 </div>
<div class = "">

         <knockselinput
         placeholder = "Orientation"
         is_required
         el_follower
         gid = "qq"
         :mat_follower=  "false"
         has_slot
         :scope = "['user_orientation_edit']"
         v-model = "orientation"
         :start_as="userObject.orientation"
         >
         <knockselbutton
         submit_at = "user/updateorientation"
         disable_placeholder
         icon = "knocks-plus"
         success_at = "done"
         :error_at = "[
         { res : 'invalid' , msg : 'You already have a preset with this name.' }
         ]"
         success_msg = "Orientation is Updated Successfully"
         gid = "stage_one_net"
         :submit_data = " {orientation : orientation} "
         :scope = "['user_orientation_edit']"
         slot = "aside">
         </knockselbutton>
         </knockselinput>
       </div>
     <div class = "">
           <knockselinput
           placeholder = "Religon"
           is_required
           el_follower
           gid = "qq"
           :mat_follower=  "false"
           has_slot
           :scope = "['user_religon_edit']"
           v-model = "religon"
           :start_as="userObject.religon"
           >
           <knockselbutton
           submit_at = "user/updatereligon"
           disable_placeholder
           icon = "knocks-plus"
           success_at = "done"
           :error_at = "[
           { res : 'invalid' , msg : 'You already have a preset with this name.' }
           ]"
           success_msg = "Religon is Updated Successfully"
           gid = "stage_one_net"
           :submit_data = " {religon : religon} "
           :scope = "['user_religon_edit']"
           slot = "aside">
           </knockselbutton>
           </knockselinput>
       </div>
       <div class = "">
             <knockselinput
             placeholder = "Marital status"
             is_required
             el_follower
             gid = "qq"
             :mat_follower=  "false"
             has_slot
             :scope = "['user_marital_status_edit']"
             v-model = "marital_status"
             :start_as="userObject.marital_status"
             >
             <knockselbutton
             submit_at = "user/updatemaritalstatus"
             disable_placeholder
             icon = "knocks-plus"
             success_at = "done"
             :error_at = "[
             { res : 'invalid' , msg : 'You already have a preset with this name.' }
             ]"
             success_msg = "Marital status is Updated Successfully"
             gid = "stage_one_net"
             :submit_data = " {marital_status : marital_status} "
             :scope = "['user_marital_status_edit']"
             slot = "aside">
             </knockselbutton>
             </knockselinput>
           </div>
         <div class = "">
               <knockselinput
               placeholder = "Bio"
               is_required
               el_follower
               gid = "qq"
               :mat_follower=  "false"
               has_slot
               :scope = "['user_bio_edit']"
               v-model = "bio"
               :start_as="userObject.bio"
               >
               <knockselbutton
               submit_at = "user/updatebio"
               disable_placeholder
               icon = "knocks-plus"
               success_at = "done"
               :error_at = "[
               { res : 'invalid' , msg : 'You already have a preset with this name.' }
               ]"
               success_msg = "Bio is Updated Successfully"
               gid = "stage_one_net"
               :submit_data = " {bio : bio} "
               :scope = "['user_bio_edit']"
               slot = "aside">
               </knockselbutton>
               </knockselinput>
             </div>
           <div class = "">
                 <knockselinput
                 placeholder = "Phone"
                 is_required
                 el_follower
                 gid = "qq"
                 :mat_follower=  "false"
                 has_slot
                 :scope = "['user_phone_edit']"
                 v-model = "phone"
                 :start_as="userObject.phone"
                 >
                 <knockselbutton
                 submit_at = "user/updatephone"
                 disable_placeholder
                 icon = "knocks-plus"
                 success_at = "done"
                 :error_at = "[
                 { res : 'invalid' , msg : 'You already have a preset with this name.' }
                 ]"
                 success_msg = "Phone is Updated Successfully"
                 gid = "stage_one_net"
                 :submit_data = " {phone : phone} "
                 :scope = "['user_phone_edit']"
                 slot = "aside">
                 </knockselbutton>
                 </knockselinput>
</div>
    <!-- </el-dialog> -->
</div>
<div class = "col l4 hide-on-med-and-down">
</div>
</div>
</template>

<script>
export default {
name: 'knocksuserinfoedit',
  mounted(){

  },
  computed : {

      birth_e(){
      if(this.birthdate == null) return null ;
      return moment(this.birthdate).format('YYYY-MM-DD');
    },
    phone_string(){
      if(this.phone == null) return null ;
      var num;
      num = this.phone;
      var s;
      s = ''+num
      console.log(s);
      console.log(this.userObject.phone);
      return s;
    },


  },

  data(){
   return{
     pickerOptions1: {
       disabledDate(time) {
         return time.getTime() > Date.now();
       },
       shortcuts: [{
         text: 'Today',
         onClick(picker) {
           picker.$emit('pick', new Date());
         }
       }, {
         text: 'Yesterday',
         onClick(picker) {
           const date = new Date();
           date.setTime(date.getTime() - 3600 * 1000 * 24);
           picker.$emit('pick', date);
         }
       }, {
         text: 'A week ago',
         onClick(picker) {
           const date = new Date();
           date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
           picker.$emit('pick', date);
         }
       }]
     },
     gender : '' ,
     userObject : null ,
     user_id : '',
     first_name : '',
     middle_name : '',
     last_name : '',
     nickname : '',
     birthdate : '',
     orientation : '',
     religon : '',
     marital_status : '',
     bio : '',
     phone : '',
     tabs : '',

     auth : parseInt(UserId) ,
       dialogVisible: false,
        knocksTapsDevOptionss : [ { icon : 'knocks-male2' , label : 'Male' , static : true , value : 'male'} ,
                                 { icon : 'knocks-female2' , label : 'Female' , static : true , value : 'female'} ,
                                 { label : 'Other' , static : true , value : 'other'}
                               ],
   }
   },
   methods : {
     passToParent(e){

       let ob = e.submit_data ;
       ob.id = e.submit_data.user_id;
       this.$emit('knocks_user_name_updated' , ob );
        // this.dialogVisible=false;
     },
     deleteMiddlename(index){
       const vm = this;
       App.$emit('knocksUserKeyUpdate' ,
         {
           user : vm.auth ,
           patch : [
           { key : 'middle_name' , value :  null } ,
         ]
       })
     },
   construct(){
     console.log(this.tabIndex(this.userObject.gender))
    App.$emit('knocks_change_taps_value' , {scope : ['user_gender_edit'] , index : this.tabIndex(this.userObject.gender) })
   },
   tabIndex(gender){
     if(gender == "male" || gender == "Male")
     return 0;
    else if(gender == "female" || gender == "Female")
     return 1;
     else {
       return 2;
     }
   }
 }

}
</script>

<style lang="css">
.knocks_border {
    background-color: #fbfdff;
    color: #97a8be;
    vertical-align: middle;

    position: relative;
    border: 1px solid #bfcbd9;
    border-radius: 4px;
    padding:  6px;
    width: 1px;
    white-space: nowrap;
}
</style>
