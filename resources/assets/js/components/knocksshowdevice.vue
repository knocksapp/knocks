<template>
<div>
  <!--retrivers-->
  <knocksretriver
  url = "user/device/info"
  v-model = "deviceRetriever"
  :xdata = "{ device : device }"
  @success = "handleDeviceInfo($event)"></knocksretriver>
  <!--retrivers-->
  <div>
    <knockscollapse
    unstatic_title
    :title = "device"
    :icon = "map.devices[device] !== undefined ? map.devices[device].icon : 'knocks-display'"
    >
    <div slot = "content" v-loading = "deviceRetriever.loading" style="padding : 5px;">
      <table class="ui celled striped table" v-if = "deviceObject">
        <thead>
          <tr><th colspan="2">
            <span class = "knocks-information3"></span>
           {{device}}
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
                  <span>{{os}}</span>
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
                  <span>{{browser}}</span>
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
    			Macintosh : { icon : 'knocksapp-screen'  }
    		},
    		os : {
    			'OS X' : { icon : 'knocks-apple' }
    		},
        browsers : {
          Opera : { icon : 'knocks-brand175' } , 
          Chrome : { icon : 'knocks-chrome blue-text'} , 
          Firefox : { icon : 'knocks-firefox orange-text'}
        }
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
  	}
  }
}
</script>

<style lang="css" scoped>
</style>