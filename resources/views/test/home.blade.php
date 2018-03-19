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
        <hr/>
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
        <hr/>
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
        <div class = "col s3">
          <el-button type="danger" icon = " knocks_icon knocks-trash2" :loading = "resetKnocksLoading"
          @click = "resetKnocksDialog=true">
          Delete Knocks Data
          </el-button>
        </div>
        <div class = "col s9">
          Truncate all the Knocks, which means deleting its childs too, this will truncate all of <b class ="knocks_text_danger">Ballons, Reactions, Blobs, Comments</b> and
          <b class = "knocks_text_danger">Knocks</b> tables.
        </div>
        <el-dialog
        title="Delete All Knocks Data ?"
        :visible.sync="resetKnocksDialog"
        width="30%"
        >
        <span>Confirming this dialog will truncate all of <b class ="knocks_text_danger">Ballons, Reactions, Blobs, Comments</b> and
          <b class = "knocks_text_danger">Knocks</b> tables.
        Are you sure that you want to truncate them?</span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="resetKnocksDialog = false">Cancel</el-button>
          <el-button type="primary" @click="resetKnocks()">Confirm</el-button>
        </span>
        </el-dialog>
        <br/><br/><hr/><br/>
        <div class = "col s3">
          <el-button type="danger" icon = " knocks_icon knocks-trash2" :loading = "resetKnocksLoading"
          @click = "resetKnocksDialog=true">
          Delete Users Data
          </el-button>
        </div>
        <div class = "col s9">
          Truncate all the Users, which means deleting its childs too, this will truncate all of  <b class ="knocks_text_danger">Ballons, Reactions, Blobs, Comments, Knocks, Circles, Circle Members, Privacy Circle Sets, Privacy User Sets, Objects</b> and
          <b class = "knocks_text_danger">Users</b> tables.
        </div>
        <el-dialog
        title="Delete All Knocks Data ?"
        :visible.sync="resetAllDialog"
        width="30%"
        >
        <span>Confirming this dialog will truncate all of <b class ="knocks_text_danger">Ballons, Reactions, Blobs, Comments, Knocks, Circles, Circle Members, Privacy Circle Sets, Privacy User Sets, Objects</b> and
          <b class = "knocks_text_danger">Users</b> tables.
        Are you sure that you want to truncate them?</span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="resetKnocksDialog = false">Cancel</el-button>
          <el-button type="primary" @click="resetUsers()">Confirm</el-button>
        </span>
        </el-dialog>
        <br/><br/><hr/><br/>
        <div class = "col s3">
          <el-button type="danger" icon = " knocks_icon knocks-trash2" :loading = "resetKnocksLoading"
          @click = "reinstallDialog=true">
          Rebound The Initial Data
          </el-button>
        </div>
        <div class = "col s9">
          If you have a fresh install or migration for the Database, so this will rebound the initial data for the whole App
          <b class ="knocks_text_danger">, You will need to reinsert the Static Messages manually from the database but still you cant if you dont have this kind of data</b>
        </div>
        <el-dialog
        title="Delete All Knocks Data ?"
        :visible.sync="reinstallDialog"
        width="30%"
        >
        <span>Confirming this dialog will reinsert <b class ="knocks_text_danger">Langauges and Presets</b>
        Are you sure that you already dont have them inserted?</span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="reinstallDialog = false">Cancel</el-button>
          <el-button type="primary" @click="reboundInitialData()">Confirm</el-button>
        </span>
        </el-dialog>

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
            active-value="100"
            inactive-value="0">
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
            active-value="100"
            inactive-value="0">
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
          <br/><br/><hr/><br/>
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
            gid = "nicknameele"
            icon = "knocks-face-sunglasses"
            :is_required = "true"
            :max_len = "15"
            v-model = "nickname"
            start_as = "hola"
            :scope = "[ 'test']"
            ></knockselinput>
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
          <br/><br/><hr/><br/>
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
        <hr/>
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
        <hr/>
        <div class="row knocks_fair_bounds">
          <knocksuserabout :user = "1"></knocksuserabout>
        </div>
        <hr/>
        <div class="row knocks_fair_bounds">
          <knocksgroupcreation></knocksgroupcreation>
        </div>
        <hr/>
        <div class = "row">
          <h3>Knocks User</h3>
          <knocksuser :user = "1" as_result></knocksuser>

        </div>
        <hr>
        <div class="row">
          <h3>Privacy Setter 2</h3>
          <knocksprivacyadjustments></knocksprivacyadjustments>
        </div>

      </transition>
    </div>
  </div>
</div>
@endsection
@section('tail')
@endsection