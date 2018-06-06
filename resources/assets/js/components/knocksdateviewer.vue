<template v-if ="!hide">
	<el-tooltip>
		<div slot = "content">
			<span :class = "details_icon"></span>
			<span :class = "date_class">{{detailsDate}}</span>
		</div>
		<span>
    <span :class = "fromnow_icon"></span>
    <span :class = "date_class">{{fromNowDate}}</span>  
    </span>
	</el-tooltip>
</template>
<script>
export default {

  name: 'knocksdateviewer',
  props : {
  	date : {
  		type : String ,
  		required : true ,
  	},
  	hide : {
  		type : Boolean ,
  		default : false
  	},
  	fromnow_icon : {
  		type : String , 
  		default : 'knocksapp-clock'
  	},
  	details_icon : {
  		type : String , 
  		default : 'knocksapp-calendar'
  	},
  	date_class : {
  		type : String ,
  		default : ''
  	},
    interval_rate : {
      type : Number , 
      default : null
    }

  },
  data () {
    return {
    	time : '' , 
    	fromNowDate : '' , 
    	detailsDate : '' ,
      offset : new Date().getTimezoneOffset() ,
    }
  },
  computed : {
  },
  mounted(){
    this.timer()
  },
  methods : {
  	timer(){
      this.formateTime()
      this.emit()
      setInterval( ()=>{
        this.time = ''; 
        this.formateTime()
        this.emit()
       }, this.interval_rate);
    },
    emit(){
      this.fromNowDate = this.time == ''  ? '' : this.time.fromNow();
      this.detailsDate = this.time == ''  ? '' : this.time.format('MMMM Do YYYY, h:mm a');
      this.$emit('input' , { fromNowDate : this.fromNowDate , detailsDate : this.detailsDate })
    },
    formateTime(){
      if(this.offset > 0){
          this.time = moment(this.date).add(this.offset * 60 ,'seconds');
          return
      }
      if(this.offset < 0){
          this.time = moment(this.date).subtract(this.offset * -60 ,'seconds');
          return
      }
      if(this.offset == 0){
          this.time = moment(this.date);
          return
      }
    }
  }
}
</script>

<style lang="css" scoped>
</style>