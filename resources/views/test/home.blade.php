@extends('layouts.main')
@section('externals')
<meta name="session-type" content="dev">
<title>Knocks Developers</title>
@endsection
@section('content')
<div class = "" id = "app"  style = "margin-top: 150px; !important">
  <center>
  <el-radio-group v-model="devStage">
  <el-radio-button label="Dictionary"></el-radio-button>
  <el-radio-button label="Knocks Data"></el-radio-button>
  <el-radio-button label="Components"></el-radio-button>
  </el-radio-group>
  </center>
  <div class= "row">
    <!--Dictionary Siction-->
    <transition enter-active-class = "animated zoomIn" enter-leave-class = "animated zoomOut">
      <div id = "dev_dictionary" v-if = "devStage == 'Dictionary'">
        <h3 class = "knocks_text_dark">Dictionary</h3>
        <!--Add Words-->
        <p class = "grey-text knocks_text_ms">Add a totally new word <span class = "knocks-book-bookmark"></span></p>
        <div style="margin-top: 5px;">
          <el-input placeholder="Add a new word" v-model="wordAdderInput" class="input-with-select" v-if= "languages != null">
          <el-select v-model="wordAdderSelector" slot="prepend" placeholder="Language" style = "width :110px !important">
          <el-option v-for = "(lang , index) in languages" :label="lang.display_name" :value="lang.name"></el-option>
          </el-select>
          <el-button slot="append" icon=" knocks_icon knocks-plus6" @click = "addNewWord()"></el-button>
          </el-input>
        </div>
        <div v-if = "addNewWordRes != null" class = "knocks_fair_bounds">
          <el-alert v-if = "addNewWordRes.state != undefined && addNewWordRes.state == 'done'"
          title="Done"
          type="success"
          :description="'Generated id : '+addNewWordRes.new_id"
          show-icon>
          </el-alert>
          <el-alert v-if = "addNewWordRes.state != undefined && addNewWordRes.state == 'dublicate'"
          title="This message already exists!"
          type="error"
          :description="'Already found in : '+addNewWordRes.found[0].id"
          show-icon>
          </el-alert>
        </div>
        <br/>
        <!--Add Words End-->
        <!--Translation-->
        <div style="margin-top: 5px;">
          <p class = "grey-text knocks_text_ms">Translation <span class = "knocks-feather3"></span></p>
          <div class = "col s6 l7">
            <el-input placeholder="The Word Body" v-model="staticMessagesBodyTranslate" class="input-with-select">
            <el-select v-model="staticMessagesLanguageTranslate"
            slot="prepend"
            placeholder="Language"
            style = "width :110px !important">
            <el-option v-for = "(lang , index) in languages"  :label="lang.display_name" :value="lang.name"></el-option>
            </el-select>
            </el-input>
          </div>
          <div class = "col s6 l5">
            <el-tag type="info">ID</el-tag>
            <el-input-number v-model="staticMessagesIdTranslate"  :min="0" ></el-input-number>
            <el-tooltip content="Regular Translate" placement="bottom" effect="light">
            <el-button type="primary" :loading = "collectMessagesLoading" class ="right" @click = "translateMessageDev()" icon = " knocks_icon knocks-feather3 " ></el-button>
            </el-tooltip>
            <el-tooltip content="Force Translate" placement="bottom" effect="light">
            <el-button type="danger" :loading = "collectMessagesLoading" class ="right" @click = "translateForceMessageDev()" icon = " knocks_icon knocks-feather3 " style = "margin-right : 1px;"></el-button>
            </el-tooltip>
          </div>
          <br/>
          <div v-if = "TranslateMessagesRes != null" class = "knocks_fair_bounds">
            <el-alert v-if = "TranslateMessagesRes.state != undefined && TranslateMessagesRes.state == 'done'"
            title="Done"
            type="success"
            :description="'Your word has translated to '+staticMessagesBodyTranslate+' successfully'"
            show-icon>
            </el-alert>
            <el-alert v-if = "TranslateMessagesRes.state != undefined && TranslateMessagesRes.state == 'dublicate'"
            title="This message was translated already"
            type="error"
            :description="'Already translated as : '+TranslateMessagesRes.found+' use the force translation to over-ride'"
            show-icon>
            </el-alert>
            <el-alert v-if = "TranslateMessagesRes.state != undefined && TranslateMessagesRes.state == 'override'"
            title="This message was translated already"
            type="warning"
            :description="'The Message was already translated as : '+TranslateMessagesRes.found+', however its now over-rided to be '+staticMessagesBodyTranslate"
            show-icon>
            </el-alert>
          </div>
          <br/>
        </div>
        <br/><br/>
        <!--Translation End-->
        <!--All Words-->
        <div style="margin-top: 5px;">
          <a @click = "showStaticMessagesTable = true" class = "knocks_pointer" v-if="!showStaticMessagesTable">
            <p class = "grey-text knocks_text_ms">Show Messages Dictionary<span class = "knocks-chevron-down2"></span></p>
          </a>
          <a @click = "showStaticMessagesTable = false" class = "knocks_pointer" v-if="showStaticMessagesTable">
            <p class = "grey-text knocks_text_ms">Hide Messages Dictionary<span class = "knocks-chevron-up2"></span></p>
          </a>
          <!--Search Queries-->
          <div class = "col s7">
            <el-input placeholder="Search for a word body" v-model="staticMessagesBodyQuery" @input = "collectMessages()" class="input-with-select">
            <el-select v-model="staticMessagesLanguageQuery"  @input = "collectMessages()"
            slot="prepend"
            placeholder="Language"
            style = "width :110px !important">
            <el-option v-for = "(lang , index) in languages"  :label="lang.display_name" :value="lang.name"></el-option>
            </el-select>
            </el-input>
          </div>
          <div class = "col s5">
            <el-tag type="info">ID</el-tag>
            <el-input-number v-model="staticMessagesIdQuery"  @input = "collectMessages()"  :min="0" ></el-input-number>
            <el-tooltip content="Refresh" placement="bottom" effect="light">
            <el-button type="primary" :loading = "collectMessagesLoading" class ="right" @click = "collectMessages()"
            icon = " knocks_icon knocks-refresh3 "></el-button>
            </el-tooltip>
          </div>
          <br/><br/>
          <transition enter-active-class = "animated zoomIn" leave-active-class = "animated zoomOut">
            <div v-if = "showStaticMessagesTable">
              <el-table
              :data="staticMessages"
              max-height="550"
              style="width: 100%">
              <el-table-column
              prop="id"
              label="ID"
              :filters="staticMessagesIdFilter"
              :filter-method="filterId"
              filter-placement="bottom-end"
              sortable>
              </el-table-column>
              <el-table-column
              prop="body"
              sortable
              label="Body">
              </el-table-column>
              <el-table-column
              prop="language"
              label="Language"
              sortable
              :filters="langFilters"
              :filter-method="filterTag"
              filter-placement="bottom-end">
              <template slot-scope="scope">
              <el-tag type = "primary" close-transition>@{{scope.row.language}}</el-tag>
              </template>
              </el-table-column>
              </el-table>
            </div>
          </transition>
        </div>
      </div>
    </transition>
    <!--KNOCKS DATA-->
    <transition enter-active-class = "animated zoomIn" enter-leave-class = "animated zoomOut">
      <div id = "dev_dictionary" v-if = "devStage == 'Knocks Data'">
        <br/><br/>
        <div class = "row">
          <knockscollapse title = "Ream Me" icon = "knocksapp-book" comment = "Instructions for better testing.">
          <div slot = "content">
            <div class = "col s12">
              <div class="ui horizontal divider transparent">
                Read Me
              </div>
              <p class = "col s12">
                <b class = "red-text">Prepare For Testing</b>
                ,If you have a fresh install `Just Migrated Your DB`, Then you need to Follow These Instructions
                <ul class = "uk-list uk-list-divider">
                  <li>
                    <b class = "amber-text text-darken-2">
                    <span class = "knocks-lab4 knocks_icon_border"></span>
                    Rebound The Initial Data</b>
                    <p>In all cases you need to rebound these data after every migration as you will need to declare
                    Languages, Privacy Presets and many more.</p>
                  </li>
                  <li>
                    <b class = "teal-text">
                    <span class = "knocks-user-add-outline knocks_icon_border"></span>
                    Add Users For Testing
                    </b>
                    <p>
                      This feature creates the desired number of users, they will automatically add each others on their main circles, not all of them
                      are friends, but every user will have a good amount of friends so developer can have a cases where there are people in his frinds and others are not.
                    </p>
                    <p class = "red-text">Add 150 at once as a maximum, if you are making an online testing, then 50 is prefared.</p>
                  </li>
                  <li>
                    <b class = "amber-text text-darken-2">
                    <span class = "knocksapp-enhance knocks_icon_border"></span>
                    Remove Membership Dublications</b>
                    <p>Incase you've added Users this feature will quickly make sure that there is no dublications in users main circles.</p>
                  </li>
                  <li>
                    <b class ="deep-purple-text">
                    <span class = "knocks-archive6 knocks_icon_border"></span>
                    Add Random Entery</b>
                    <p>This feature adds a random Addresses for users, and for each user who's older than 18 he will have an high education, Addresses and educations
                    records are real and understandable for developers as they can recognize them.</p>
                  </li>
                  <li>
                    <b class = "green-text text-darken-3">
                    <span class = "knocks-group-1 knocks_icon_border"></span>
                    Add Random Groups</b>
                    <p>This feature adds a groups with a sweet names, different categories and privacy presets, every group has atleast one owner, and many other
                    members with different possitions (Owners, Admins, Members).</p>
                    <p class = "red-text">Add 50 groups at once, in local testing case you can go with 70, however 50 group at once could be just great!</p>
                  </li>
                  <li>
                    <b class = "blue-text text-lighten-2">
                    <span class = "knocks-atom2 knocks_icon_border"></span>
                    Add Random Circles
                    </b>
                    <p>This feature creates a circles with a real names for many users, no standards, many circles will include a normal amount of members while others
                    will not, just like a real user case!</p>
                    <p class = "red-text">Add 50 circles at once in both online and local testing for better performance.</p>
                  </li>
                  <li>
                    <b class = "knocks_text_dark">
                    <span class = "knocks-knocks knocks_icon_border"></span>
                    Add Random Knocks
                    </b>
                    <p>This Feature adds a random knocks with a real quotes, Knocks could be in the user's own profile, or a friend of him, or even in a group he've joined.</p>
                    <p>Make sure to have groups and users in your database first.</p>
                    <p class ="red-text">150 at once could be fair, the proccess is light weighted some how.</p>
                  </li>
                  <li>
                    <b class = "pink-text">
                    <span class = "knocks-communication knocks_icon_border"></span>
                    Add Random Comments
                    </b>
                    <p>This Feature adds a random comments on the available Knocks, each comment has a real quote.</p>
                    <p>Make sure to have knocks and users in your database first.</p>
                    <p class ="red-text">150 at once could be fair, the proccess is light weighted some how.</p>
                  </li>
                  <li>
                    <b class = "deep-purple-text">
                    <span class = "knocks-laughing-face2 knocks_icon_border"></span>
                    Add Random Reactions
                    </b>
                    <p>Adding a random reactions on reactable objects, such as Knocks and Comments.</p>
                    <p>Reacting with a different reactions in a different amounts to look more real</p>
                    <p class ="red-text">50 at once could be good, the proccess is not light weighted some how.</p>
                  </li>
                </ul>
              </p>
            </div>
          </div>
          </knockscollapse>
        </div>
        <div class = "col s3">
          <el-button type="danger" icon = " knocks_icon knocks-trash2" :loading = "resetKnocksLoading"
          @click = "resetKnocksDialog=true">
          Delete Knocks Data
          </el-button>
        </div>
        <p class = "col s12">
          Truncate all the Knocks, which means deleting its childs too, this will truncate all of <span class ="knocks_text_danger">Ballons, Reactions, Blobs, Comments</span> and
          <span class = "knocks_text_danger">Knocks</span> tables.
        </p>
        <el-dialog
        title="Delete All Knocks Data ?"
        :visible.sync="resetKnocksDialog"
        width="80%"
        >
        <span>Confirming this dialog will truncate all of <span class ="knocks_text_danger">Ballons, Reactions, Blobs, Comments</span> and
        <span class = "knocks_text_danger">Knocks</span> tables.
      Are you sure that you want to truncate them?</span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="resetKnocksDialog = false">Cancel</el-button>
        <el-button type="primary" @click="resetKnocks()">Confirm</el-button>
      </span>
      </el-dialog>
      <br/><br/><br/>
      <div class = "col s12">
        <div class="ui horizontal divider transparent">
          Delete Users Data
        </div>
        <el-button type="danger" icon = " knocks_icon knocks-trash2" :loading = "resetKnocksLoading"
        @click = "resetKnocksDialog=true">
        Delete Users Data
        </el-button>
      </div>
      <p class = "col s12">
        Truncate all the Users, which means deleting its childs too, this will truncate all of  <span class ="knocks_text_danger">Ballons, Reactions, Blobs, Comments, Knocks, Circles, Circle Members, Privacy Circle Sets, Privacy User Sets, Objects</span> and
        <span class = "knocks_text_danger">Users</span> tables.
      </p>
      <el-dialog
      title="Delete All Knocks Data ?"
      :visible.sync="resetAllDialog"
      width="80%"
      >
      <span>Confirming this dialog will truncate all of <span class ="knocks_text_danger">Ballons, Reactions, Blobs, Comments, Knocks, Circles, Circle Members, Privacy Circle Sets, Privacy User Sets, Objects</span> and
      <span class = "knocks_text_danger">Users</span> tables.
    Are you sure that you want to truncate them?</span>
    <span slot="footer" class="dialog-footer">
      <el-button @click="resetKnocksDialog = false">Cancel</el-button>
      <el-button type="primary" @click="resetUsers()">Confirm</el-button>
    </span>
    </el-dialog>
    <br/><br/><br/>
    <div class = "col s12">
      <div class="ui horizontal divider transparent">
        Rebound The Initial Data
      </div>
      <el-button type="warning" icon = " knocks_icon knocks-lab4" :loading = "resetKnocksLoading"
      @click = "reinstallDialog=true">
      Rebound The Initial Data
      </el-button>
    </div>
    <p class = "col s12">
      If you have a fresh install or migration for the Database, so this will rebound the initial data for the whole App
      <span class ="knocks_text_danger">, You will need to reinsert the Static Messages manually from the database but still you cant if you dont have this kind of data</span>
    </p>
    <el-dialog
    title="Delete All Knocks Data ?"
    :visible.sync="reinstallDialog"
    width="80%"
    >
    <span>Confirming this dialog will reinsert <span class ="knocks_text_danger">Langauges and Presets</span>
  Are you sure that you already dont have them inserted?</span>
  <span slot="footer" class="dialog-footer">
    <el-button @click="reinstallDialog = false">Cancel</el-button>
    <el-button type="primary" @click="reboundInitialData()">Confirm</el-button>
  </span>
  </el-dialog>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      SOCIALIZE
    </div>
    <knockstestingsocialize></knockstestingsocialize>
    <p class = "col s12">It makes sure that friends are only recorded once at Main Circles, after finishing check your dev tools
      on <code class = "knocks_text_pink">dev/db/chck/members</code> route and check the response object.<br/>
      Normally you should find an object <code class = "knocks_text_pink">{ found : X , removed : Y }</code> ,make sure that both numbers are the same.<br/>
      Otherwise, that means that there are still dublicated Memberships, which means you will need to run it again.
    </p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Add Random Users
    </div>
    <div class = "row">
      <el-input-number v-model="usersCount"  :min="1" :max="200"></el-input-number>
    </div>
    <knockselbutton
    placeholder = "Add Random Users"
    type = "success"
    :error_at = []
    :scope = "['add_random_users']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "dev/db/add/users"
    success_at = "done"
    :timeout = "60000"
    class = "teal"
    icon = "knocks-user-add-outline"
    success_msg = "Added 100 user Successfully"
    :submit_data = " {count : usersCount} ">
    </knockselbutton>
    <p class = "col s12">Add Random Users For Testing, Every user has a real understandable name, and friendship relations out of the box.</p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Add Random Entery
    </div>
    <knockselbutton
    placeholder = "Add Random Entery"
    type = "success"
    :error_at = []
    :scope = "['add_random_users']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "dev/db/entry/users"
    success_at = "done"
    :timeout = "600000"
    class = " deep-purple darken-4"
    icon = "knocks-archive6"
    success_msg = "Added Random Entery Successfully"
    :submit_data = " {} ">
    </knockselbutton>
    <p class = "col s12">Add Random Users For Testing, Every user has a real understandable name, and friendship relations out of the box.</p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Check Membership Dublications
    </div>
    <knockselbutton
    placeholder = "Check Membership Dublications"
    type = "warning"
    :error_at = []
    :scope = "['add_random_users']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "dev/db/chck/members"
    computed_response
    :timeout = "60000"
    icon = "knocksapp-enhance"
    success_msg = "Check Your Dev Tools For Statics"
    :submit_data = " {} ">
    </knockselbutton>
    <p class = "col s12">It makes sure that friends are only recorded once at Main Circles, after finishing check your dev tools
      on <code class = "knocks_text_pink">dev/db/chck/members</code> route and check the response object.<br/>
      Normally you should find an object <code class = "knocks_text_pink">{ found : X , removed : Y }</code> ,make sure that both numbers are the same.<br/>
      Otherwise, that means that there are still dublicated Memberships, which means you will need to run it again.
    </p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Add Random Groups
    </div>
    <div class = "row">
      <el-input-number v-model="usersCount"  :min="1" :max="200"></el-input-number>
    </div>
    <knockselbutton
    placeholder = "Add Random Groups"
    type = "success"
    :error_at = []
    :scope = "['add_random_groups']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "dev/db/add/groups"
    success_at = "done"
    :timeout = "60000"
    icon = "knocks-group-1"
    class = "cyan darken-3"
    success_msg = "Added Random Groups Successfully"
    :submit_data = " {count : usersCount} ">
    </knockselbutton>
    <p class = "col s12">Add Random Groups with a real names, installed with atleast one owner and variety of members with different positions out of the box.</p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Add Random Circles
    </div>
    <div class = "row">
      <el-input-number v-model="usersCount"  :min="1" :max="200"></el-input-number>
    </div>
    <knockselbutton
    placeholder = "Add Random Circles"
    type = "success"
    :error_at = []
    :scope = "['add_random_circles']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "dev/db/add/circles"
    success_at = "done"
    :timeout = "60000"
    icon = "knocks-atom2"
    class = " light-blue accent-3"
    success_msg = "Added Random Circles Successfully"
    :submit_data = " {count : usersCount} ">
    </knockselbutton>
    <p class = "col s12">Add Random Circles with a real names, installed with only one owner and variety of members.</p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Add Random Knocks
    </div>
    <div class = "row">
      <el-input-number v-model="usersCount"  :min="1" :max="200"></el-input-number>
    </div>
    <knockselbutton
    placeholder = "Add Random Knocks"
    type = "success"
    :error_at = []
    :scope = "['add_random_groups']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "dev/db/add/knocks"
    success_at = "done"
    :timeout = "60000"
    icon = "knocks-knocks"
    class = "knocks_color_kit"
    success_msg = "Added Random Knocks Successfully"
    :submit_data = " {count : usersCount} ">
    </knockselbutton>
    <p class = "col s12">Add Random Knocks, they will be bounded in a different places, friends profile, knock owner groups, and on their own profiles.</p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Add Random Comments
    </div>
    <div class = "row">
      <el-input-number v-model="usersCount"  :min="1" :max="200"></el-input-number>
    </div>
    <knockselbutton
    placeholder = "Add Random Comments"
    type = "success"
    :error_at = []
    :scope = "['add_random_groups']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "dev/db/add/comment"
    success_at = "done"
    :timeout = "60000"
    icon = "knocks-communication"
    class = "pink lighten-2"
    success_msg = "Added Random Comments Successfully"
    :submit_data = " {count : usersCount} ">
    </knockselbutton>
    <p class = "col s12">Add Random Comments, they will be bounded in a different places, friends profile, knock owner groups, and on their own profiles.</p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Add Random Reactions
    </div>
    <div class = "row">
      <el-input-number v-model="usersCount"  :min="1" :max="200"></el-input-number>
    </div>
    <knockselbutton
    placeholder = "Add Random Reactions"
    type = "success"
    :error_at = []
    :scope = "['add_random_groups']"
    validation_error = "You need to complete some fields"
    reset_on_success
    submit_at = "dev/db/add/reaction"
    success_at = "done"
    :timeout = "60000"
    icon = "knocks-laughing-face2"
    class = "red accent-3"
    success_msg = "Added Random Reactions Successfully"
    :submit_data = " {count : usersCount} ">
    </knockselbutton>
    <p class = "col s12">Add Random Reactions, they will be bounded in a different places, friends profile, knock owner groups, and on their own profiles.</p>
  </div>
  <div class = "col s12">
    <div class="ui horizontal divider transparent">
      Delete Circle Members
    </div>
    <knockselbutton
    type = "danger"
    submit_at = "dev/delete/allmems"
    :submit_data = "{}"
    success_at = "done"
    placeholder = "Delete All Circle Members"
    icon = "knocks-trash2"></knockselbutton>
    <p class = "red-text knocks_fair_bounds col s12">Clicking this will remove all circle members which means all friendship relations will be removed.</p>
  </div>
</div>
</transition>
<transition enter-active-class = "animated zoomIn" leave-active-class = "animated zoomOut">
<div v-if = "devStage == 'Components'" class = "knocks_fair_bounds">
  <h3 class = "knocks_text_dark">Knocks Taps</h3>
  <div class = "row">
    <knockstaps :multiple = "knocksTapsDevMultiple" :define_with_index = "knocksTapsDevDefineIndex" v-model="knocksTapsDevModel"
    :options = "knocksTapsDevOptions" :radio_unset = "knocksTapsDevRadioReset">
    </knockstaps>
    <div class = "col s12">
      <button class = "btn btn-floating" style= "margin-right: 3px" @click = "knocksTapsDevOptions.push({icon : '' , label : '' , value : '' , static : false })">
      <span class = "knocks-plus7"></span>
      </button>
      <span class="knocks_badge blue darken-1 knocks_fair_bounds white-text" v-for="(tag , index) in knocksTapsDevOptions" >
        @{{tag.label}}
        <a @click = "knocksTapsDevOptions.splice(index,1)"><span class = " knocks_side_padding knocks-x2 white-text"></span></a>
      </span>
    </div>
  </div>
  <div class = 'row'>The Model Value : <span style = "font-family : monospace">@{{knocksTapsDevModel}}</span></div>
  <div class = "row">
    <div class = 'col s6 l3'>Multiple
      <el-switch
      v-model="knocksTapsDevMultiple"
      active-color="#13ce66"
      inactive-color="#ff4949"
      :active-value="true"
      :inactive-value="false">
      </el-switch>
    </div>
    <div class = 'col s6 l3'>
      <div class = "col s6">Define Index</div>
      <div class = "col s6">
        <el-input-number v-model="knocksTapsDevDefineIndex" :min="0" :max="knocksTapsDevOptions.length+5"></el-input-number>
      </div>
    </div>
  </div>
  <div class = "row">
    <div class = 'col s6 '>Radio Reset
      <el-switch
      v-model="knocksTapsDevRadioReset"
      active-color="#13ce66"
      inactive-color="#ff4949"
      :active-value="true"
      :inactive-value="false">
      </el-switch>
    </div>
    <div class = 'col s6'>
      <div class = 'col s6'> Is Required
        <el-switch
        v-model="knocksTapsDevIsRequired"
        active-color="#13ce66"
        inactive-color="#ff4949"
        active-value="100"
        inactive-value="0">
        </el-switch>
      </div>
    </div>
  </div>
  <div class = "col s6 l3">
    Options Icons
    <div class = "" v-for = "(option , index) in knocksTapsDevOptions">
      <el-input
      placeholder="Your Icon"
      suffix-icon = "knocks_icon knocks-puzzle-piece"
      v-model="knocksTapsDevOptions[index].icon">
      <span slot="append" class=" knocks_icon knocks-puzzle-piece"></span>
      </el-input>
    </div>
  </div>
  <div class = "col s6 l3">
    Options Labels
    <div class = "" v-for = "(option , index) in knocksTapsDevOptions">
      <el-input
      placeholder="Your Label"
      suffix-icon = "knocks_icon knocks-puzzle-piece"
      v-model="knocksTapsDevOptions[index].label">
      <span slot="append" class=" knocks_icon knocks-puzzle-piece"></span>
      </el-input>
    </div>
  </div>
  <div class = "col s6 l3">
    Options Values
    <div class = "" v-for = "(option , index) in knocksTapsDevOptions">
      <el-input
      placeholder="Your Value"
      suffix-icon = "knocks_icon knocks-puzzle-piece"
      v-model="knocksTapsDevOptions[index].value">
      <span slot="append" class=" knocks_icon knocks-puzzle-piece"></span>
      </el-input>
    </div>
  </div>
  <div class = "col s6 l3">
    Options Static Messages
    <div class = "row" v-for = "(option , index) in knocksTapsDevOptions">
      <div class = "col s6">Static Label</div>
      <div class = "col s6">
        <el-switch
        v-model="knocksTapsDevOptions[index].static"
        active-text="Stable"
        inactive-text="Not stable">
        </el-switch>
      </div>
    </div>
  </div>
  <div class = "row">
    <h3 class = "knocks_text_dark">Knocks Static Messages with Replacements</h3>
    Replacement in Static Messages is now available, to enable it just set some target in your static messages, then enable the replacement option in your component and provid it with target and body.<br/>
    EG: The next text is stored in the database as 'replace ** By Foo', in my case i need to give this text to invlolve it between the string, so i'll enable the replaceble option and setup my component like the following sample.
    <span style = "font-family: monospace" class = "blue-text"> <br/>
      < static_message <br/>
      msg = "replace ** by Foo"  <br/>
      replaceable <br/>
      :replacements = "[ { target : '**' , body : 'Bar'  } ]" > <br/>
      < /static_message> <br/>
    </span>
    The Result :
    <static_message msg="replace ** by Foo" replaceable :replacements = "[ { target : '**' , body : 'Bar'} ]"></static_message>
    <br/>
    You can also set many replacments as much as you want, as you define your replacements as an array you can define any number of replacments you need, the next is the same like this but having 2 replacements.<br/>
    The original message in the database will be 'replace ** by @@' <br/>
    <span style = "font-family: monospace" class = "blue-text"> <br/>
      < static_message <br/>
      msg = "replace ** by @@"  <br/>
      replaceable <br/>
      :replacements = "[ { target : '**' , body : 'Bar'  } , { target : '@@' , body : 'Foo'} ]" > <br/>
      < /static_message> <br/>
    </span>
    The Result :
    <static_message msg="replace ** by @@" replaceable
    :replacements = "[ { target : '**' , body : 'Bar'  } , { target : '@@' , body : 'Foo'} ]"></static_message>
    <br/><br/><br/>
    <div class = "row">
      <h3 class = "knocks_text_dark">Knocks Inputs and Knocks Button</h3>
      <knocksinput
      el_follower
      :mat_follower=  "false"
      placeholder = "Nickname"
      gid = "nickname"
      icon = "knocks-face-sunglasses"
      :is_required = "false"
      :max_len = "15"
      v-model = "nickname"
      :scope = "[ 'test']"
      ></knocksinput>
      <knockselinput
      el_follower
      :mat_follower=  "false"
      placeholder = "Nickname"
      inner_placeholder
      gid = "nicknameele"
      icon = "knocks-face-sunglasses"
      :is_required = "true"
      :max_len = "15"
      v-model = "nickname"
      :scope = "[ 'test']"
      ></knockselinput>
      <knockseldatepicker
      :scope = "[ 'test']"
      is_required
      :quick = "[
      {msg : 'Next Year' , margins : { count : 1 , unit : 'y' } } ,
      {msg : 'Last Year' , margins : { count : -1 , unit : 'y' } } ,
      {msg : 'Early 2017' , margins : { date : '2017-01-01' } } ,
      {msg : '2017 +2 months' , margins : { from : '2017-01-01' , count : 2 , unit : 'month' } } ,
      ]"
      :margins = '{ max : { count : 3 , unit : "y" } , min : { count : -3 , unit : "y" } }'
      placeholder = "Test date picker"
      ></knockseldatepicker>
      <knockselselect
      icon = "knocks-globe"
      allow_create
      fill_from = "address/state/get"
      :xdata ="{country : 'EG'}"
      :feeds = "[ 'one' , { label : 'Two, Static Message' , icon : 'knocks-feather3' , value : 'two' , static : true } , 'three' ]" general_icon = "knocks-knocks"></knockselselect>
      <knocksbutton
      placeholder = "Test"
      submit_at = "dev/test"
      success_at = "done"
      :error_at = []
      reset_on_success
      :submit_data = "{}"
      icon = "knocks-chevron-thin-right right"
      success_at = "done"
      gid = "stage_one_next"
      :scope = "['test']"
      label_classes="knocks_text_sm"
      :validation_error = "getTranslation('There\'s some feilds we need you to complete it.')">
      </knocksbutton>
      <br/>
    </div>
    <br/><br/><br/>
    <div class = "row">
      <h3 class = "knocks_text_dark">Knocks Button</h3>
      <hr/>
      <div class="row">
        <knocksbutton
        placeholder = "Test"
        submit_at = "dev/test"
        success_at = "done"
        :error_at = "[{res : 'error' , msg : 'Error from the server' }]"
        reset_on_success
        :submit_data = "{}"
        icon = "knocks-knocks"
        gid = "stagetest"
        :scope = "['testonlytest']"
        label_classes="knocks_text_sm"
        :validation_error = "getTranslation('There\'s some feilds we need you to complete it.')">
        </knocksbutton>
      </div>
      <div class="row">
        <knockselbutton
        placeholder = "Test"
        submit_at = "dev/test"
        success_at = "done"
        :error_at = "[{res : 'error' , msg : 'Error from the server' }]"
        reset_on_success
        :submit_data = "{}"
        icon = "knocks-knocks"
        gid = "stagetest"
        :scope = "['testonlytest']"
        label_classes="knocks_text_sm"
        :validation_error = "getTranslation('There\'s some feilds we need you to complete it.')">
        </knockselbutton>
      </div>
    </div>
    <div class = "row">
      <h3 class = "knocks_text_dark">Knocks Cover Uploader</h3>
      <knockscoveruploader
      gid = "file"
      :valid_ex="['image/png' , 'image/jpeg']"
      :crop = "true"
      v-model = "fileup"
      success_at = "done"
      success_msg = "done !"
      accepts = "image/*"
      :upload_data = "{ }"
      :error_at = "[]"
      callback_event = "update"
      :callback_payloads = "{}"
      ref = "ss"
      :special_submit = "true"
      :scope = "['cover_picture_handler']"
      upload_at = "media/cover/upload">
      </knockscoveruploader>
    </div>
  </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <hr>
  <br/>
  <br/>
  <div class="row">
    <el-tabs tab-position="left">
    <el-tab-pane label="User Career">
    <knocksusercareers></knocksusercareers>
    </el-tab-pane>
    <el-tab-pane label="User Education">
    <knocksusereducation></knocksusereducation>
    </el-tab-pane>
    <el-tab-pane label="User High Education">
    <knocksuserhigheducation></knocksuserhigheducation>
    </el-tab-pane>
    <el-tab-pane label="User Hobby">
    <knocksuserhobby></knocksuserhobby>
    </el-tab-pane>
    <el-tab-pane label="User Sport">
    <knocksusersport></knocksusersport>
    </el-tab-pane>
    </el-tabs>
  </div>
  <hr>
  <div class="row knocks_fair_bounds">
    <knocksuserabout :user = "1"></knocksuserabout>
  </div>
  <div class="row knocks_fair_bounds">
    <knocksgroupcreation></knocksgroupcreation>
  </div>
  <div class = "row">
    <h3>Knocks User</h3>
    <knocksuser :user = "1" as_result></knocksuser>
  </div>
  <hr>
  <div class="row">
    <h3>Privacy Setter 2</h3>
    <knocksprivacyadjustments></knocksprivacyadjustments>
  </div>
  <div class = "row">
    <h3>Knocks Collapse</h3>
    <knockscollapse title = "Tap One" icon = "knocks-knocks" :side_count = "3">
    <h5 slot = "content">
      This is <code class ="blue-text">knockscollapse</code> with <code class ="purple-text">:side_count</code> prop.<br/>
      in case you need to put a side count in your collapse toggler section, init this with a number, for styling it use
      <code class ="purple-text">side_count_classes</code> prop and add your classes, it accepts <code class ="amber-text">Array, Object, String</code>
      for classes values, the side numbers are based on <code class ="blue-text">knocksmeganumber</code> component, so it will handle your numbers out of the box,
      which means that 1000 and greater numbers will be shown as 1K, and so on.
    </h5>
    </knockscollapse>
    <knockscollapse title = "Tap Two" icon = "knocks-knocks-circle-fill" comment = "This is a comment">
    <h3 slot = "content">
      This is <code class ="blue-text">knockscollapse</code> with <code class ="purple-text">:side_count</code> prop.<br/>
      you can bind a comment after your title to explain some content, by default it converts both of <code class ="purple-text">title</code>
      and <code class ="purple-text">comment</code> to a
      <code class ="blue-text">static_message</code> ,however you can negate it using <code class ="purple-text">unstatic_title</code>
      and <code class ="purple-text">unstatic_comment</code>
    </h3>
    </knockscollapse>
  </div>
</transition>
</div>
</div>
</div>
@endsection
@section('tail')
@endsection