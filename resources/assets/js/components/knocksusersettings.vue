<template>
<div>
	<knocksretriver
  v-model=  "block_user_id"
  url = "userblock/retriveblockeduser"
  @success="getUsersName()"
  :xdata = "{  }"
  :scope = "['user_filter']"
  >
  </knocksretriver>
	<!--Hiddens-->
	<div class="knocks_hidden">
		<knockswatchmywindow v-model = "myWindow"></knockswatchmywindow>
		<knocksuser :user = "auth" v-model = "authModel" @input = "handleUser($event)"></knocksuser>
		<static_message msg = "Key" v-model = "messages.country_code"></static_message>
	</div>
	<!--Hiddens end -->
	<div class = "row knocks_ocean_blue_border white knocks_tinny_border_radius knocks_fair_bounds" v-if = "authModel != null">
		<el-tabs v-model = "tabs" @input ="handleTaps($event)" :tab-position="myWindow.isSmall ? 'top' : 'left'" >
		<el-tab-pane name = "general">
		<span slot="label" class="left">
			<i class="knocksapp-disguise"></i>
			<static_message msg = "General"></static_message>
		</span>
		<div v-if = "seenOnce.general">
			<!--Name-->
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-vcard2"></span>
					<static_message msg = "Name"></static_message>
				</p>
				<div :class = "[{'white row knocks_height_padding knocks_tinny_border_radius knocks_gray_border' :!myWindow.isSmall}]">
					<div class = "col l4 s12">
						<div class = "row knocks_house_keeper">
							<knockselinput
							inner_placeholder
							placeholder = "First Name"
							icon = "knocks-grinning-face knocks_text_md"
							@control = "testCont($event)"
							is_required
							:start_as = "authModel.first_name"
							:max_len = "15"
							:min_len = "2"
							v-model = "input.first_name"
							:scope = "[ 'name'+_uid]"></knockselinput>
						</div>
					</div>
					<div class = "col l1" v-if = "!myWindow.isSmall">
						<span style="line-height: 300%;" class = "knocks-minus"></span>
					</div>
					<div class = "col l3 s12">
						<div class = "row knocks_house_keeper">
							<knockselinput
							inner_placeholder
							placeholder = "Middle Name"
							icon = "knocks-face-moustache3 knocks_text_md"
							:start_as = "authModel.middle_name ? authModel.middle_name : ''"
							:max_len = "15"
							v-model = "input.middle_name"
							:scope = "[ 'name'+_uid]"></knockselinput>
						</div>
					</div>
					<div class = "col l1" v-if = "!myWindow.isSmall">
						<span style="line-height: 300%;" class = "knocks-minus"></span>
					</div>
					<div class = "col l3 s12">
						<div class = "row knocks_house_keeper">
							<knockselinput
							inner_placeholder
							placeholder = "Last Name"
							icon = "knocks-face-moustache knocks_text_md"
							:start_as = "authModel.last_name"
							:max_len = "15"
							:min_len = "2"
							v-model = "input.last_name"
							:scope = "[ 'name'+_uid]"></knockselinput>
						</div>
					</div>
				</div>
				<div class = "col l4 s12">
					<div class = "row knocks_house_keeper">
						<knockselinput
						inner_placeholder
						placeholder = "Nickname"
						icon = "knocks-face-sunglasses knocks_text_md"
						:start_as = "authModel.nickname ? authModel.nickname : ''"
						:max_len = "15"
						v-model = "input.nickname"
						:scope = "[ 'name'+_uid]"></knockselinput>
					</div>
				</div>

				<div class = "col s12 l8">
					<knockselbutton
					submit_at = "user/update/name"
					:submit_data = "{
					first_name : input.first_name ,
					last_name : input.last_name ,
					middle_name : input.middle_name ,
					nickname : input.nickname
					}"
					success_at = "done"
					success_msg = "Saved"
					:error_at = "[]"
					:scope = "[ 'name'+_uid]"
					@knocks_submit_accepted = "updateUser([
					{ key : 'first_name' , value : input.first_name } ,
					{ key : 'last_name' , value : input.last_name } ,
					{ key : 'middle_name' , value : input.middle_name } ,
					{ key : 'nickname' , value : input.nickname } ,
					])"
					placeholder = "Save"
					icon = "knocks-save"
					type = "primary"
					class = "right"
					:disabled = "authModel.first_name == input.first_name && authModel.last_name == input.last_name &&
					authModel.middle_name == input.middle_name && authModel.nickname == input.nickname"
					plain
					></knockselbutton>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-user13"></span>
					<static_message msg = "Display Name"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<div class = "col l6 s12">
						<knockselselect
						:start_as = "authModel.display_name"
						multiple
						:feeds="displayNameFeeds"
						v-model = "input.display_name"
						is_required
						icon = "knocks-puzzle"
						:error_mixins = "[{ key : 'is_required' , mixin : { msg : 'This field is required.' , icon : 'knocks-alert-circle' } }]"
						:max_len = "70"
						:min_len = "2"
						general_icon = "knocks-tag-add"
						placeholder = "Display Name"
						:scope = "['knocks_displayname'+_uid]"></knockselselect>
					</div>
					<div class = "col l6 s12">
						<div class="animated fadeIn  ui  message"  v-if = "input.display_name.length > 0">
							<p>
								<span v-for = "(k , index) in input.display_name">
									<span v-if = "k == 'nickname' && input.display_name.length > 1"> ( </span>
									{{authModel[k]}}
									<span v-if = "k == 'nickname' && input.display_name.length > 1"> ) </span>
								</span>
							</p>
						</div>
					</div>
					<div class = "col s12 knocks_mp_bottom_margin">
						<knockselbutton
						submit_at = "user/update/displayname"
						:submit_data = "{ display_name : input.display_name }"
						success_at = "done"
						success_msg = "Saved"
						:error_at = "[]"
						:scope = "['knocks_displayname'+_uid]"
						@knocks_submit_accepted = "updateUser([
						{ key : 'display_name' , value : input.display_name } ,
						])"
						placeholder = "Save"
						icon = "knocks-save"
						type = "primary"
						class = "right"
						:disabled = "authModel.display_name == input.display_name"
						plain
						></knockselbutton>
					</div>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-birthday-cake"></span>
					<static_message msg = "Birthdate"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<div class = "col s12">
						<knockseldatepicker
						v-if = "authModel != null"
						:quick = "[]"
						is_required
						icon = "knocks-birthday-cake"
						:scope = "[ _uid + 'birthdate']"
						:margins = '{ max : { count : -5 , unit : "y" } , min : { count : -102 , unit : "y" } }'
						placeholder = "Birthdate"
						:default_time = "{ date : authModel.birthdate}"
						v-model = "input.birthdate"></knockseldatepicker>
					</div>
					<div class = "col s12 knocks_mp_bottom_margin knocks_mp_top_margin">
						<knockselbutton
						submit_at = "user/updatebirthdate"
						:submit_data = "{ birthdate : input.birthdate }"
						success_at = "done"
						success_msg = "Saved"
						:error_at = "[]"
						:scope = "[ _uid + 'birthdate']"
						@knocks_submit_accepted = "updateUser([
						{ key : 'birthdate' , value : input.birthdate } ,
						])"
						placeholder = "Save"
						icon = "knocks-save"
						type = "primary"
						class = "right"
						:disabled = "authModel.birthdate == input.birthdate"
						plain
						></knockselbutton>
					</div>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-controller-record"></span>
					<static_message msg = "Gender"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<div class = "col s12">
						<knockselselect
						:start_as = "authModel.gender"
						:feeds="[
						{ label : 'Male' , value : 'Male' , icon : 'knocks-male2' } ,
						{ label : 'Female' , value : 'Female' , icon : 'knocks-female2' } ,
						{ label : 'Mercury' , value : 'Mercury' , icon : 'knocks-mercury' } ,
						{ label : 'Intersex' , value : 'Intersex' , icon : 'knocks-intersex' } ,
						{ label : 'Transgender (Non-binary)' , value : 'Transgender' , icon : 'knocks-transgender-alt' } ,
						{ label : 'Mars Stroke (Androgyny)' , value : 'Marse Stroke' , icon : 'knocks-mars-stroke' } ,
						{ label : 'Marse Stroke Vertical' , value : 'Marse Stroke Vertical' , icon : 'knocks-mars-stroke-v' } ,
						{ label : 'Marse Stroke Horizontal' , value : 'Marse Stroke Horizontal' , icon : 'knocks-mars-stroke-h' } ,
						{ label : 'Neuter' , value : 'Neuter' , icon : 'knocks-neuter' } ,
						{ label : 'Genderless' , value : 'Genderless' , icon : 'knocks-genderless' } ,
						]"
						v-model = "input.gender"
						is_required
						allow_create
						icon = "knocks-controller-record"
						:error_mixins = "[{ key : 'is_required' , mixin : { msg : 'This field is required.' , icon : 'knocks-alert-circle' } }]"
						general_icon = "knocks-tag-add"
						placeholder = "Gender"
						:scope = "['knocks_gender_'+_uid]"></knockselselect>
					</div>
					<div class = "col s12 knocks_mp_bottom_margin knocks_mp_top_margin">
						<div class = "col s6 knocks_house_keeper">
							<div class="col knocks_house_keeper">
								<knocksprivacyadjustments
								trigger_class = "btn btn-floating amber"
								disable_quick_presets
								:signs = "{ valid : 'valid' , invalid : 'invalid' , invalidForAll : 'invalid_for_all' }"
								:keys = "{ circle : 'circle' , user : 'user' , preset : 'preset' }"
								v-model = "input.genderkps">
								<div slot = 'footer' class = "knocks_mp_bottom_margin">
									<knockselbutton
									class = "right"
									type = "primary"
									placeholder = "Save"
									v-if = "input.genderkps !==null  && input.genderkps.user_privacy !== undefined && input.genderkps.circle_privacy !== undefined"
									icon = "knocks-save"
									submit_at = "user/attr/ps/update"
									:submit_data = "{
									key : 'gender' ,
									user_privacy : input.genderkps.user_privacy ,
									circle_privacy : input.genderkps.circle_privacy ,
									}"
									:scope = "['knocks_gender_kps_'+_uid]"
									success_at = "done"></knockselbutton>
									<br/>
								</div>
								</knocksprivacyadjustments>
							</div>
						</div>
						<div class = "col s6 knocks_house_keeper">
							<knockselbutton
							submit_at = "user/updategender"
							:submit_data = "{ gender : input.gender }"
							success_at = "done"
							success_msg = "Saved"
							:error_at = "[]"
							:scope = "['knocks_gender_'+_uid]"
							@knocks_submit_accepted = "updateUser([
							{ key : 'gender' , value : input.gender } ,
							])"
							placeholder = "Save"
							icon = "knocks-save"
							type = "primary"
							class = "right"
							:disabled = "authModel.gender == input.gender"
							plain
							></knockselbutton>
						</div>
					</div>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-heart"></span>
					<static_message msg = "Sextual Orientation"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<div class = "col s12">
						<knockselselect
						:start_as = "authModel.orientation"
						:feeds="[
						{ label : 'Heterosexual (Vinus-Mars)' , value : 'Heterosexual' , icon : 'knocks-venus-mars' } ,
						{ label : 'Gay (Mars Double) ' , value : 'Marse Double' , icon : 'knocks-mars-double' } ,
						{ label : 'Lesbian (Vinus Double)' , value : 'Vinus Double' , icon : 'knocks-venus-double' } ,
						]"
						v-model = "input.orientation"
						is_required
						allow_create
						icon = "knocks-heart"
						:error_mixins = "[{ key : 'is_required' , mixin : { msg : 'This field is required.' , icon : 'knocks-alert-circle' } }]"
						general_icon = "knocks-tag-add"
						placeholder = "Sextual Orientation"
						:scope = "['knocks_orientaion_'+_uid]"></knockselselect>
					</div>
					<div class = "col s12 knocks_mp_bottom_margin knocks_mp_top_margin">
						<div class = "col s6 knocks_house_keeper">
							<div class="col knocks_house_keeper">
								<knocksprivacyadjustments
								trigger_class = "btn btn-floating amber"
								disable_quick_presets
								:signs = "{ valid : 'valid' , invalid : 'invalid' , invalidForAll : 'invalid_for_all' }"
								:keys = "{ circle : 'circle' , user : 'user' , preset : 'preset' }"
								v-model = "input.orientationkps">
								<div slot = 'footer' class = "knocks_mp_bottom_margin">
									<knockselbutton
									class = "right"
									type = "primary"
									placeholder = "Save"
									v-if = "input.orientationkps !==null  && input.orientationkps.user_privacy !== undefined && input.orientationkps.circle_privacy !== undefined"
									icon = "knocks-save"
									submit_at = "user/attr/ps/update"
									:submit_data = "{
									key : 'orientation' ,
									user_privacy : input.orientationkps.user_privacy ,
									circle_privacy : input.orientationkps.circle_privacy ,
									}"
									:scope = "['knocks_gender_kps_'+_uid]"
									success_at = "done"></knockselbutton>
									<br/>
								</div>
								</knocksprivacyadjustments>
							</div>
							<div class="col ">
								<knockselbutton
								circle
								type = "danger"
								disable_placeholder
								icon = "el-icon-delete"
								success_msg = "Deleted"
								submit_at = 'user/attr/delete'
								:scope = "['knocks_orientation_delete_'+_uid]"
								:submit_data = "{ key : 'orientation'}"
								:disabled = "authModel.orientation == null"
								@knocks_submit_accepted = "updateUser([{ key : 'orientation' , value : null }]);"
								success_at = "done"></knockselbutton>
							</div>
						</div>
						<div class = "col s6 knocks_house_keeper">
							<knockselbutton
							submit_at = "user/attr/update"
							:submit_data = "{ key : 'orientation' , value : input.orientation }"
							success_at = "done"
							success_msg = "Saved"
							:error_at = "[]"
							:scope = "['knocks_orientaion_'+_uid]"
							@knocks_submit_accepted = "updateUser([
							{ key : 'orientation' , value : input.orientation } ,
							])"
							placeholder = "Save"
							icon = "knocks-save"
							type = "primary"
							class = "right"
							:disabled = "authModel.orientation == input.orientation"
							plain
							></knockselbutton>
						</div>
					</div>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocksapp-gather2"></span>
					<static_message msg = "Religion"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<div class = "col s12">
						<knockselselect
						:start_as = "authModel.religon"
						:feeds="[
						'Christianity',
						'Islam',
						'Nonreligious',
						'Secular',
						'Agnostic',
						'Atheist',
						'Hinduism',
						'Taoism',
						'Buddhis',
						'Primal-indigenous',
						'African traditional and Diasporic',
						'Sikhism',
						'Juche',
						'Spiritism',
						'Judaism',
						'Bahai',
						'Jainism',
						'Shinto',
						'Cao Dai',
						'Zoroastrianism',
						'Tenrikyo',
						'Neo-Paganism',
						'Unitarian-Universalism'
						]"
						v-model = "input.religon"
						is_required
						allow_create
						general_static
						icon = "knocksapp-gather2"
						:error_mixins = "[{ key : 'is_required' , mixin : { msg : 'This field is required.' , icon : 'knocks-alert-circle' } }]"
						general_icon = "knocksapp-gather"
						placeholder = "Religion"
						:scope = "['knocks_religon_'+_uid]"></knockselselect>
					</div>
					<div class = "col s12 knocks_mp_bottom_margin knocks_mp_top_margin">
						<div class = "col s6 knocks_house_keeper">
							<div class="col knocks_house_keeper">
								<knocksprivacyadjustments
								trigger_class = "btn btn-floating amber"
								disable_quick_presets
								:signs = "{ valid : 'valid' , invalid : 'invalid' , invalidForAll : 'invalid_for_all' }"
								:keys = "{ circle : 'circle' , user : 'user' , preset : 'preset' }"
								v-model = "input.religonkps">
								<div slot = 'footer' class = "knocks_mp_bottom_margin">
									<knockselbutton
									class = "right"
									type = "primary"
									placeholder = "Save"
									v-if = "input.religonkps !==null && input.religonkps.user_privacy !== undefined && input.religonkps.circle_privacy !== undefined"
									icon = "knocks-save"
									submit_at = "user/attr/ps/update"
									:submit_data = "{
									key : 'orientation' ,
									user_privacy : input.religonkps.user_privacy ,
									circle_privacy : input.religonkps.circle_privacy ,
									}"
									:scope = "['knocks_religonkps_'+_uid]"
									success_at = "done"></knockselbutton>
									<br/>
								</div>
								</knocksprivacyadjustments>
							</div>
							<div class="col ">
								<knockselbutton
								circle
								type = "danger"
								disable_placeholder
								icon = "el-icon-delete"
								success_msg = "Deleted"
								submit_at = 'user/attr/delete'
								:scope = "['knocks_religon_delete_'+_uid]"
								:submit_data = "{ key : 'religon'}"
								:disabled = "authModel.religon == null"
								@knocks_submit_accepted = "updateUser([{ key : 'religon' , value : null }]);"
								success_at = "done"></knockselbutton>
							</div>
						</div>
						<div class = "col s6 knocks_house_keeper">
							<knockselbutton
							submit_at = "user/attr/update"
							:submit_data = "{ key : 'religon' , value : input.religon }"
							success_at = "done"
							success_msg = "Saved"
							:error_at = "[]"
							:scope = "['knocks_religon_'+_uid]"
							@knocks_submit_accepted = "updateUser([
							{ key : 'religon' , value : input.religon } ,
							])"
							placeholder = "Save"
							icon = "knocks-save"
							type = "primary"
							class = "right"
							:disabled = "authModel.religon == input.religon"
							plain
							></knockselbutton>
						</div>
					</div>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-heartbeat"></span>
					<static_message msg = "Marital Status"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<div class = "col s12">
						<knockselselect
						:start_as = "authModel.marital_status"
						:feeds="[
						'Single',
						'Married',
						'Divorced',
						'Engaged',
						'In Relationship',
						'Complicated',
						'Widowed',
						'Open relationship'
						]"
						v-model = "input.marital_status"
						is_required
						allow_create
						general_static
						icon = "knocks-heartbeat"
						:error_mixins = "[{ key : 'is_required' , mixin : { msg : 'This field is required.' , icon : 'knocks-alert-circle' } }]"
						general_icon = "knocks-heartbeat"
						placeholder = "Marital Status"
						:scope = "['knocks_marital_status_'+_uid]"></knockselselect>
					</div>
					<div class = "col s12 knocks_mp_bottom_margin knocks_mp_top_margin">
						<div class = "col s6 knocks_house_keeper">
							<div class="col knocks_house_keeper">
								<knocksprivacyadjustments
								trigger_class = "btn btn-floating amber"
								disable_quick_presets
								:signs = "{ valid : 'valid' , invalid : 'invalid' , invalidForAll : 'invalid_for_all' }"
								:keys = "{ circle : 'circle' , user : 'user' , preset : 'preset' }"
								v-model = "input.marital_statuskps">
								<div slot = 'footer' class = "knocks_mp_bottom_margin">
									<knockselbutton
									class = "right"
									type = "primary"
									placeholder = "Save"
									v-if = "input.marital_statuskps !==null && input.marital_statuskps.user_privacy !== undefined && input.marital_statuskps.circle_privacy !== undefined"
									icon = "knocks-save"
									submit_at = "user/attr/ps/update"
									:submit_data = "{
									key : 'marital_status' ,
									user_privacy : input.marital_statuskps.user_privacy ,
									circle_privacy : input.marital_statuskps.circle_privacy ,
									}"
									:scope = "['knocks_marital_statuskps_'+_uid]"
									success_at = "done"></knockselbutton>
									<br/>
								</div>
								</knocksprivacyadjustments>
							</div>
							<div class="col ">
								<knockselbutton
								circle
								type = "danger"
								disable_placeholder
								icon = "el-icon-delete"
								success_msg = "Deleted"
								submit_at = 'user/attr/delete'
								:scope = "['knocks_marital_status_delete_'+_uid]"
								:submit_data = "{ key : 'marital_status'}"
								:disabled = "authModel.marital_status == null"
								@knocks_submit_accepted = "updateUser([{ key : 'marital_status' , value : null }]);"
								success_at = "done"></knockselbutton>
							</div>
						</div>
						<div class = "col s6 knocks_house_keeper">
							<knockselbutton
							submit_at = "user/attr/update"
							:submit_data = "{ key : 'marital_status' , value : input.marital_status }"
							success_at = "done"
							success_msg = "Saved"
							:error_at = "[]"
							:scope = "['knocks_marital_status_'+_uid]"
							@knocks_submit_accepted = "updateUser([
							{ key : 'marital_status' , value : input.marital_status } ,
							])"
							placeholder = "Save"
							icon = "knocks-save"
							type = "primary"
							class = "right"
							:disabled = "authModel.marital_status == input.marital_status"
							plain
							></knockselbutton>
						</div>
					</div>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-phone16"></span>
					<static_message msg = "Phone"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<div class = "col s12">
						<knockselinput
						icon = "knocks-phone16"
						placeholder = "Phone"
						:start_as = "splitPhone(authModel.phone).phone"
						inner_placeholder
						has_slot
						with_select
						is_required
						is_numeric
						:scope = "['knocks_phone_'+_uid]"
						v-model = "input.phone">
						<el-select
						slot = "labelside"
						v-model="input.phonekey"
						clearable
						:placeholder="messages.country_code"
						filterable
						default-first-option>
						<el-option
						v-for="(item , index) in countries"
						:key="index"
						:label="index"
						:value="'+'+item.phone">
						<span style="float: left; ">{{ item.emoji+' +'+item.phone}}</span>
						</el-option>
						</el-select>
						</knockselinput>
					</div>
					<div class = "col s12 knocks_mp_bottom_margin knocks_mp_top_margin">
						<div class = "col s6 knocks_house_keeper">
							<div class="col knocks_house_keeper">
								<knocksprivacyadjustments
								trigger_class = "btn btn-floating amber"
								disable_quick_presets
								:signs = "{ valid : 'valid' , invalid : 'invalid' , invalidForAll : 'invalid_for_all' }"
								:keys = "{ circle : 'circle' , user : 'user' , preset : 'preset' }"
								v-model = "input.phonekps">
								<div slot = 'footer' class = "knocks_mp_bottom_margin">
									<knockselbutton
									class = "right"
									type = "primary"
									placeholder = "Save"
									v-if = "input.phonekps !==null && input.phonekps.user_privacy !== undefined && input.phonekps.circle_privacy !== undefined"
									icon = "knocks-save"
									submit_at = "user/attr/ps/update"
									:submit_data = "{
									key : 'phone' ,
									user_privacy : input.phonekps.user_privacy ,
									circle_privacy : input.phonekps.circle_privacy ,
									}"
									:scope = "['knocks_phonekps_'+_uid]"
									success_at = "done"></knockselbutton>
									<br/>
								</div>
								</knocksprivacyadjustments>
							</div>
							<div class="col ">
								<knockselbutton
								circle
								type = "danger"
								disable_placeholder
								icon = "el-icon-delete"
								success_msg = "Deleted"
								submit_at = 'user/attr/delete'
								:scope = "['knocks_phone_delete_'+_uid]"
								:submit_data = "{ key : 'phone'}"
								:disabled = "authModel.phone == null"
								@knocks_submit_accepted = "updateUser([{ key : 'phone' , value : null }]);"
								success_at = "done"></knockselbutton>
							</div>
						</div>
						<div class = "col s6 knocks_house_keeper">
							<knockselbutton
							submit_at = "user/attr/update"
							:submit_data = "{ key : 'phone' , value : input.phonekey + input.phone }"
							success_at = "done"
							success_msg = "Saved"
							:error_at = "[]"
							:scope = "['knocks_phone_'+_uid]"
							@knocks_submit_accepted = "updateUser([
							{ key : 'phone' , value : input.phonekey + input.phone } ,
							])"
							placeholder = "Save"
							icon = "knocks-save"
							type = "primary"
							class = "right"
							:disabled = "
							(splitPhone(authModel.phone).phone  == input.phone && splitPhone(authModel.phone).key == input.phonekey
							&& authModel.phone == input.phonekey+input.phone) || (input.phonekey == null || input.phonekey.length == 0)"
							plain
							></knockselbutton>
						</div>
					</div>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-feather2"></span>
					<static_message msg = "Biography"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<div class = "col s12">
						<div class="input-field col s12">
							<textarea :id="'knocks_settings_bio_'+_uid" class="materialize-textarea knocks_input_ps knocks_textarea_ps" v-model = "input.bio"  ></textarea>
							<label :for="'knocks_settings_bio_'+_uid" :id = "'knocks_settings_bio_label_'+_uid">
								<span class = "knocks-feather2"></span>
								<static_message msg = "Biography"></static_message>
							</label>
						</div>
					</div>
					<div class = "col s12 knocks_mp_bottom_margin knocks_mp_top_margin">
						<div class = "col s6 knocks_house_keeper">
							<div class="col knocks_house_keeper">
								<knocksprivacyadjustments
								trigger_class = "btn btn-floating amber"
								disable_quick_presets
								:signs = "{ valid : 'valid' , invalid : 'invalid' , invalidForAll : 'invalid_for_all' }"
								:keys = "{ circle : 'circle' , user : 'user' , preset : 'preset' }"
								v-model = "input.marital_statuskps">
								<div slot = 'footer' class = "knocks_mp_bottom_margin">
									<knockselbutton
									class = "right"
									type = "primary"
									placeholder = "Save"
									v-if = "input.bio !==null && input.bio.user_privacy !== undefined && input.bio.circle_privacy !== undefined"
									icon = "knocks-save"
									submit_at = "user/attr/ps/update"
									:submit_data = "{
									key : 'marital_status' ,
									user_privacy : input.biokps.user_privacy ,
									circle_privacy : input.biokps.circle_privacy ,
									}"
									:scope = "['knocks_marital_statuskps_'+_uid]"
									success_at = "done"></knockselbutton>
									<br/>
								</div>
								</knocksprivacyadjustments>
							</div>
							<div class="col ">
								<knockselbutton
								circle
								type = "danger"
								disable_placeholder
								icon = "el-icon-delete"
								success_msg = "Deleted"
								submit_at = 'user/attr/delete'
								:scope = "['knocks_marital_status_delete_'+_uid]"
								:submit_data = "{ key : 'bio'}"
								:disabled = "authModel.bio == null || authModel.bio.length == 0"
								@knocks_submit_accepted = "updateUser([{ key : 'bio' , value : null }]);"
								success_at = "done"></knockselbutton>
							</div>
						</div>
						<div class = "col s6 knocks_house_keeper">
							<knockselbutton
							submit_at = "user/attr/update"
							:submit_data = "{ key : 'bio' , value : input.bio }"
							success_at = "done"
							success_msg = "Saved"
							:error_at = "[]"
							:scope = "['knocks_bio_'+_uid]"
							@knocks_submit_accepted = "updateUser([
							{ key : 'bio' , value : input.bio } ,
							])"
							placeholder = "Save"
							icon = "knocks-save"
							type = "primary"
							class = "right"
							:disabled = "authModel.bio == input.bio || input.bio == null || input.bio.length == 0"
							plain
							></knockselbutton>
						</div>
					</div>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocksapp-picture2"></span>
					<static_message msg = "Profile Picture"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<knocksimg :src = "asset('media/avatar/'+auth)" @clicked = "input.ppdialog = true"
					:classes = "['knocks_user_profile_scope col knocks_bold_white_border z-depth-3 knocks_house_keeper knocks_tinny_border_radius l6 s12']"></knocksimg>
					<p class = "col s12">
						<static_message msg = "Update your profile picture"></static_message>
					</p>
					<el-dialog
					:visible.sync="input.ppdialog"
					width="99%" class = "knocks_house_keeper">
					<center>
					<div class="col s12 l6 knocks_house_keeper">
						<knockscroppie
						gid = "knocks_profile_picture_uploader"
						success_at = "done"
						success_msg = "Updated Your profile picture succecfully!"
						:upload_data = "{ }"
						:error_at = "[]"
						callback_event = "update"
						:callback_payloads = "{}"
						ref = "ss"
						:special_submit = "true"
						:scope = "['profile_picture_handler']"
						upload_at = "media/avatar/upload"
						></knockscroppie>
					</div>
					</center>
					</el-dialog>
				</div>
			</div>
			<div class = "col s12 knocks_tinny_border_radius blue-grey lighten-5 knocks_gray_border knocks_mp_top_margin" v-if = "authModel != null">
				<p class = "knocks_text_md blue-grey-text text-darken-3 ">
					<span class = "knocks-image7"></span>
					<static_message msg = "Cover Picture"></static_message>
				</p>
				<div class = "col s12 knocks_house_keeper">
					<knocksimg :src = "asset('media/cover/'+auth)" @clicked = "input.coverdialog = true"
					:classes = "['knocks_user_cover_scope col knocks_bold_white_border z-depth-3 knocks_house_keeper knocks_tinny_border_radius s12']"></knocksimg>
					<p class = "col s12">
						<static_message msg = "Update your Cover picture"></static_message>
					</p>
					<el-dialog
					:visible.sync="input.coverdialog" class = "knocks_house_keeper"
					width="99%">
					<center>
					<div class="col s12 knocks_house_keeper">
						<knockscroppie
						gid = "knocks_cover_picture_uploader"
						success_at = "done"
						success_msg = "Updated Your cover picture succecfully!"
						:upload_data = "{ }"
						:error_at = "[]"
						callback_event = "update"
						:callback_payloads = "{}"
						ref = "ss"
						:special_submit = "true"
						:scope = "['cover_picture_handler']"
						upload_at = "media/cover/upload"
						:aspect_ratio = "78/205"
						></knockscroppie>
					</div>
					</center>
					</el-dialog>
				</div>
			</div>
		</div>
		</el-tab-pane>
		<el-tab-pane name = "myPeople">
		<span slot="label" class="left">
			<i class="knocks-planet"></i>
			<static_message msg = "My People"></static_message>
		</span>
		<div v-if = "seenOnce.myPeople">
			<knockscirclechip :circle = "mainCircle" as_list toggled :show_key = "5"></knockscirclechip>
		</div>
		</el-tab-pane>
		<el-tab-pane name = "myCircles">
		<span slot="label" class="left">
			<i class="knocks-atom2"></i>
			<static_message msg = "My Circles"></static_message>
		</span>
		<div v-if = "seenOnce.myCircles">
			<knocksusercircles></knocksusercircles>
		</div>
		</el-tab-pane>
		<el-tab-pane name = "myGroups">
		<span slot="label" class="left">
			<i class="knocks-group-1"></i>
			<static_message msg = "My Groups"></static_message>
		</span>
		<div v-if = "seenOnce.myGroups">
			<knocksgroupslist></knocksgroupslist>
			<a @click = "toggleGroupCreator(true)" class = "fluid ui button knocks_no_border_radius">
				<i class="knocks-plus7 "></i>
				<static_message msg = "Create a group"></static_message>
			</a>
		</div>
		</el-tab-pane>
		<el-tab-pane name = "privacy">
		<span slot="label" class="left">
			<i class="knocksapp-lock2"></i>
			<static_message msg = "Privacy"></static_message>
		</span>
		<div v-if = "seenOnce.privacy">
			<knocksretriver
			url = 'user/devices/get'
			v-model = "userDevicesRetriver"
			@success = "userDevices = $event.response"></knocksretriver>
			<knockscollapse 
			title = "My Devices" 
			v-loading = "userDevicesRetriver.loading"
			active_title = "Hide my devices"
			:side_count = "userDevices.length"
			icon = "knocks-mobile5">
				<div v-loading = "userDevicesRetriver.loading" slot = "content">
					<knocksshowkeys :show_input = "userDevices" show_scope = "device"></knocksshowkeys>
				</div>
			</knockscollapse>
		</div>
		</el-tab-pane>
		<el-tab-pane name = "blocking">
		<span slot="label" class="left">
			<i class="knocks-eye-blocked"></i>
			<static_message msg = "Blocking"></static_message>
		</span>
		<div v-if = "seenOnce.blocking">
      <knocksblockuserlist ></knocksblockuserlist>
			<div>
				<h4 class="ui horizontal divider header transparent">
				<i class="knocks-eye-blocked blue-grey-text"></i>
				<static_message msg = "Blocked Users" classes = "knocks_text_sm blue-grey-text"  ></static_message>
				</h4>
			</div>
			<knocksshowkeys class = "knocks_mp_top_margin" show_scope = "block" :show_input = "blockedUserIds" as_result blocker :as_label = "false"></knocksshowkeys>


		</div>

		</el-tab-pane>
		</el-tabs>
	</div>
</div>
</template>

<script>
export default {

  name: 'knocksusersettings',
  props : {
  	init_tab : {
  		type : String , 
  		default : null
  	}
  },
  data () {
    return {
    	myWindow : '' ,
    	messages : {
    		country_code : ''
    	} ,
			blockedUserIds : [] ,
			block_user_id : '',
    	auth : parseInt(window.UserId) ,
    	mainCircle : window.UserMainCircle ,
    	authModel : null ,
    	tabs : 'general' ,
    	countries : window.Countries.countries ,
    	seenOnce : {
    		general : false ,
    		myPeople : false ,
    		myCircles : false ,
    		myGroups : false ,
    		privacy : false ,
    		blocking : false ,
    	},
    	input : {
    		first_name : '' ,
    		middle_name : '' ,
    		last_name : '' ,
    		nickname : '' ,
    		display_name : [] ,
    		birthdate : null ,
    		gender : '' ,
    		genderkps : null ,
    		orientation : '',
    		orientationkps : null ,
    		religon : '' ,
    		religonkps : null ,
    		marital_status : '' ,
    		marital_statuskps : null ,
    		phone : '' ,
    		phonekey : '' ,
    		phonekps : null ,
    		bio : '' ,
    		biokps : null ,
    		ppdialog : false ,
    		coverdialog : false ,

    	},
    	userDevices : [] ,
    	userDevicesRetriver : { loading : false },

    }
  },
	mounted(){

		if(this.init_tab){
			this.tabs = this.init_tab
			this.seenOnce[this.init_tab] = true
		}else{
			this.seenOnce['general'] = true
		}
		const vm = this
		App.$on('knocksUserUnblocked', (payloads)=>{

				let ind = vm.blockedUserIds.indexOf(payloads.user)
				if(ind != -1){
					let temp = this.blockedUserIds
					this.blockedUserIds = []
					setTimeout(()=>{
						temp.splice(ind , 1)
						App.$emit('KnocksContentChanged')
						this.blockedUserIds = temp

					},300)

			}
		})

		App.$on('knocksUserBlocked', (payloads)=>{

				let ind = vm.blockedUserIds.indexOf(payloads.user)
				if(ind == -1){
					let temp = this.blockedUserIds
					this.blockedUserIds = []
					setTimeout(()=>{
						temp.push(payloads.user)
						App.$emit('KnocksContentChanged')
						this.blockedUserIds = temp

					},300)

			}
		})
	},
  computed : {
  	displayNameFeeds(){
  		return [
				{ value : 'first_name' , label : 'First Name' , icon : 'knocks-grinning-face' } ,
				{ value : 'middle_name' , label : 'Middle Name' , icon : 'knocks-face-moustache3' ,
				disabled : !this.authModel.middle_name || this.authModel.middle_name.length == 0 } ,
				{ value : 'last_name' , label : 'Last Name' , icon : 'knocks-face-moustache '} ,
				{ value : 'nickname' , label : 'Nickname' , icon : 'knocks-face-sunglasses' ,
				disabled : !this.authModel.nickname || this.authModel.nickname.length == 0 } ,
				]
  	}
  },
  methods : {
  	handleTaps(e){
  		this.seenOnce[this.tabs] = true
  	},
  	 toggleGroupCreator(flag){
      App.$emit('knocksGroupCreationToggle' , {toggle : flag})
    },
    handleUser(e){
    	App.$emit('knocks_input_update' , { scope : ['knocks_displayname'+this._uid] , value : e.display_name , isFired : false })
    	App.$emit('knocks_elselect_update_feeds' , { scope : ['knocks_displayname'+this._uid] , feeds : this.displayNameFeeds })
    	App.$emit('knocks_input_update' , { scope : ['knocks_phone_'+this._uid] , value : this.splitPhone(this.authModel.phone).phone , isFired : false })
    	this.input.phonekey = this.splitPhone(this.authModel.phone).key
    	this.input.bio = this.authModel.bio

    	if(this.input.bio && this.input.bio.length > 0){
    		$('#knocks_settings_bio_label_'+this._uid).addClass('active')
    	}else{
    		$('#knocks_settings_bio_label_'+this._uid).removeClass('active')
    	}

    },
    handleDisplayNameOptions(){

    },
    updateUser(patch){
    	App.$emit('knocksUserKeyUpdate' , { user : this.auth , patch : patch })
    },
    updatePCS(pcs){
    	let i
    	for(i = 0; i < pcs.length; i++){
    		pcs[i].circle_id = pcs[i].circle
    	}
    	return pcs
    },
		getUsersName(){

		 this.blockedUserIds = this.block_user_id.response;
		 App.$emit('KnocksContentChanged')
		},
    splitPhone(phone){
    	if(!phone) return {key : null , phone : null}
    	let i
        for(i in this.countries){
        	if(phone.indexOf(this.countries[i].phone) == 1)
        		return {key :  phone.substr(0 , this.countries[i].phone.length + 1) , phone : phone.substr(this.countries[i].phone.length + 1)}
        }
        return {key : null , phone : null}
    },
    testCont(con){
    	window.ContIn = con
    },
    asset(url){
    	return Asset(url)
    }
  }
}
</script>

<style lang="css" scoped>
</style>
