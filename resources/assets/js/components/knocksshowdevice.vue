<template>
<div>
  <!--retrivers-->
  <knocksretriver
  url = "user/device/info"
  v-model = "deviceRetriever"
  :xdata = "{ device : device }"
  @success = "handleDeviceInfo($event)"></knocksretriver>
  <!--retrivers-->
  <!--Hiddens-->
  <div class = "knocks_hidden">
    <static_message msg = "Unknown" v-model = "msgs.unknown"></static_message>
  </div>
  <!--Hiddens-->
  <div>
    <knockscollapse
    v-if = "msgs.unknown.length > 0"
    unstatic_title
    :title = "handleName(device)"
    :icon = "map.devices[device] !== undefined ? map.devices[device].icon : 'knocks-display'"
    >
    <div slot = "content" v-loading = "deviceRetriever.loading" style="padding : 5px;">
      <table class="ui celled striped table" v-if = "deviceObject">
        <thead>
          <tr><th colspan="2">
            <span class = "knocks-information3"></span>
           {{handleName(device)}}
          </th>
        </tr></thead>
        <tbody>

          <tr>
            <td class="collapsing">
              <i class="knocks-enter"></i>
               <static_message msg = "Total Usage"></static_message>
            </td>
            <td>
             {{ deviceObject.usage }}
            </td>
          </tr>

          <tr>
            <td class="collapsing">
              <i class="knocks-calendar-plus-o"></i>
               <static_message msg = "First Usage"></static_message>
            </td>
            <td>
              <knocksdateviewer :date = "deviceObject.first_use.date"></knocksdateviewer>
            </td>
          </tr>

          <tr>
            <td class="collapsing">
              <i class="knocks-calendar-check-o"></i>
               <static_message msg = "Last Usage"></static_message>
            </td>
            <td>
              <knocksdateviewer :date = "deviceObject.last_use.date"></knocksdateviewer>
            </td>
          </tr>

          <tr>
            <td class="collapsing">
              <span class="knocksapp-gear"></span>
               <static_message msg = "Operating Systems"></static_message> {{'('+deviceObject.os.length+')'}}
            </td>
            <td>
              <ul class = 'uk-list uk-list-bullet'>
                <li v-for = "os in deviceObject.os">
                  <span :class ="map.os[os] !== undefined ? map.os[os].icon : 'knocks-gears'"></span>
                  <span>{{handleName(os)}}</span>
                </li>
              </ul>
            </td>
          </tr>

          <tr>
            <td class="collapsing">
              <span class="knocks-globe6"></span>
               <static_message msg = "Browsers"></static_message> {{'('+deviceObject.browsers.length+')'}}
            </td>
            <td>
              <ul class = 'uk-list uk-list-bullet'>
                <li v-for = "browser in deviceObject.browsers">
                  <span :class ="map.browsers[browser] !== undefined ? map.browsers[browser].icon : 'knocks-globe6'"></span>
                  <span>{{handleName(browser)}}</span>
                </li>
              </ul>
            </td>
          </tr>

          <tr>
            <td class="collapsing">
              <i class="knocks-key8"></i>
               <static_message msg = "Logins"></static_message>
            </td>
            <td>
             {{ deviceObject.logins }}
            </td>
          </tr>

          <tr>
            <td class="collapsing">
              <i class="knocks-calendar10"></i>
               <static_message msg = "Logins Dates"></static_message>
            </td>
            <td>
              <knocksshowkeys :show_input = "deviceObject.logins_dates" show_scope = "datefilter"></knocksshowkeys>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
    </knockscollapse>
  </div>
</div>
</template>

<script>
export default {

  name: 'knocksshowdevice',
  props :{
  	device : {
  		type : String , 
  		required : true 
  	}
  },
  data () {
    return {
    	map : {
    		devices : {
    			Macintosh : { icon : 'knocksapp-screen'  } , 
          iPhone : { icon : 'knocks-mobile2'  } , 
          iPad : { icon : 'knocks-tablet6'  } , 
          iPod : { icon : 'knock-ipod'  } , 
          WebKit : { icon : 'knocksapp-screen'  } , 
          Samsung : { icon : 'knocks-phone12'  } , 
          HTC : { icon : 'knocks-phone12'  } , 
          Samsung : { icon : 'knocks-phone12'  } , 
          Bot : { icon : 'knocks-microchip' }

    		},
    		os : {
    			'OS X' : { icon : 'knocks-brand9' } , 
          iOS : { icon : 'knocks-brand9' } , 
          AndroidOS : { icon : 'knocks-brand8' } , 
          Linux : { icon : 'knocks-linux' } , 
          Windows : { icon : 'knocks-brand286' } , 
    		},
        browsers : {
          Chrome : { icon : 'knocks-chrome green-text'} , 
          Firefox : { icon : 'knocks-firefox orange-text'},
          Mozilla : { icon : 'knocks-firefox orange-text'},
          Opera : { icon : 'knocks-brand175' } , 
          IE : { icon : 'knocks-internet-explorer blue-text'},
          Edge : { icon : 'knocks-edge blue-text text-lighten-2'},
          Safari : { icon : 'knocks-safari blue-text'},

        }
    	},
      msgs : {
        unknown : ''
      },
    	deviceObject : null ,
      deviceRetriever : { loading : false }
    }
  },
  methods : {
  	init(object){
      this.deviceObject = object
      this.$emit('input' , this.deviceObject)
  	},
  	handleDeviceInfo(e){
      if(e.response != 'invalid')
        this.init(e.response)
  	},
    handleName(name){
      return name == 0 || name == null ? this.msgs.unknown : name
    }
  }
}
</script>

<style lang="css" scoped>
</style>