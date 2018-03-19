<template>
	<div>
		  <knocksloaderbar v-if = "isLoading" :class = "{'animated fadeOutUp': !isLoading}"></knocksloaderbar >
		  <a :href = "asset(file)" target="_blank"style = "padding:0.2rem" class = " knocks_anchor_light_div knocks_standard_border_radius ">
		  	<knockspopover v-if = "fileMeta != null">
            <template slot = "container" v-if = "fileMeta.name != undefined && fileMeta.extension != undefined" >
            <span v-if = "fileMeta.name != undefined && fileMeta.extension != undefined && extensions[fileMeta.extension] != undefined"
            :class = "[extensions[fileMeta.extension] , icons_class]"></span>
            <span v-if = "fileMeta.name != undefined
                && fileMeta.extension != undefined
                && fileMeta.name != undefined
                && fileMeta.name.length < 15 "
            :class = "[file_name_class]">{{fileMeta.name}}</span>
            <span v-if = "fileMeta.name != undefined
                && fileMeta.extension != undefined
                && fileMeta.name != undefined
                && fileMeta.name.length > 15"
            class = "knocks_text_anchor knocks_text_dark"
            :class = "[file_name_class , icons_class]">{{minimizedText(fileMeta.name)}}</span>
            </template>
            <span slot = "content"  class = "knocks_tooltip animated flipInX" >
                <span :class = "[extensions[fileMeta.extension] , 'knocks_text_light']"></span>
                <span>{{fileMeta.name}}</span>
            </span>
            </knockspopover>
		  </a>
	</div>
</template>

<script>
export default {

  name: 'knocksfileviewer',
  props : {
  	file : {
  		type : Number , 
  		required : true 
  	},
  		icons_class : {
			type : String , 
			default : ' knocks_text_md'
		},
		file_name_class : {
			type : String , 
			default : 'knocks_text_dark knocks_text_anchor knocks_text_sm knocks_word_break'
		},
		icons_container : {
			type : String , 
			default : 'col s4'
		},
  },
  data () {
    return {
    	    isLoading : false , 
    	    fileMeta : null ,
    		extensions :  {
    		"text/x" : 'knocks-document-file-app2' ,
    		"application/pdf" : 'knocks-file-pdf red-text' ,
    		"audio/mpeg" : 'knocks-document-file-mp32' ,
    		"video/mp4" : 'knocks-document-file-mp42' ,
    		"application/x-iwork-pages-sffpages" : 'knocks-document-file-pages' ,
    		"video/x-sgi-movie" : 'knocks-document-file-mov2' ,
    		"text/html" : 'knocks-brand110' ,
    		"text/css" : 'knocks-brand44' ,
    		"text/x-java-source,java" : 'knocks-document-file-java2' ,
    		"image/vnd.adobe.photoshop" : 'knocks-document-file-psd2 blue-text' ,
    		"application/postscript" : 'knocks-document-file-ai2 orange-text' ,
    		"text/x" : 'knocks-document-file-bmp2 purple-text' ,
    		"text/x" : 'knocks-document-file-dwg2' ,
    		"text/x" : 'knocks-document-file-eps2' ,
    		"text/x" : 'knocks-document-file-tiff2' ,
    		"text/x" : 'knocks-document-file-ots2' ,
    		"text/php" : 'knocks-document-file-php2 purple-text' ,
    		"text/x" : 'knocks-document-file-py2' ,
    		"text/x" : 'knocks-document-file-c2' ,
    		"text/x" : 'knocks-document-file-sql2' ,
    		"text/x" : 'knocks-document-file-rb2' ,
    		"text/x" : 'knocks-document-file-cpp2' ,
    		"text/x" : 'knocks-document-file-tga2' ,
    		"text/x" : 'knocks-document-file-doc2' ,
    		"text/x" : 'knocks-document-file-xls2' ,
    		"text/x" : 'knocks-document-file-file-word' ,
    		"text/x" : 'knocks-document-file-ppt2' ,
    		"text/x" : 'knocks-document-file-asp2' ,
    		"text/x" : 'knocks-document-file-ics2' ,
    		"text/x" : 'knocks-document-file-dat2' ,
    		"text/x" : 'knocks-document-file-xml2' ,
    		"text/x" : 'knocks-document-file-h2' ,
    		"text/x" : 'knocks-document-file-exe2' ,
    		"text/x" : 'knocks-document-file-avi2' ,
    		"text/x" : 'knocks-document-file-dotx2' ,
    		"text/plain" : 'knocks-document-file-txt2' ,
    		"text/x" : 'knocks-document-file-rtf2' ,
    		"text/x" : 'knocks-document-file-m4v2' ,
    		"text/x" : 'knocks-document-file-flv2' ,
    		"text/x" : 'knocks-document-file-mpg2' ,
    		"text/x" : 'knocks-document-file-3gp2' ,
    		"text/x" : 'knocks-document-file-ott2' ,
    		"text/x" : 'knocks-document-file-tgz2' ,
    		"text/x" : 'knocks-document-file-zip2' ,
    		"text/x" : 'knocks-document-file-dmg2' ,
    		"text/x" : 'knocks-document-file-iso2' ,
    		"text/x" : 'knocks-document-file-rar2' ,
    		"text/x" : 'knocks-document-file-gif2' ,
    	}
    

    }
  },
  mounted(){
  	this.loadFileMeta();
  },
  methods : {
  	asset(id){
  		return LaravelOrgin + 'media/file/retrive/'+id;
  	},
  	minimizedText(textToMinimize){
        let splitted = textToMinimize.split('');
        let i;
        let container = [];
        for(i = 0; i < 14; i++){
            container.push(splitted[i]);
        }
        return container.join('') + '...';
    },
  	loadFileMeta(){
  		const vm = this;
  		axios({
  			method : 'post' ,
  			url : LaravelOrgin + 'media/file/meta' , 
  			data : { id : vm.file } , 
  			onDownloadProgress : ()=>{ vm.isLoading = true; }
  		}).then((res)=>{
  			vm.isLoading = false; 
  			if(res.data != 'invalid')
  			vm.fileMeta = res.data;
  		})
  	}
  }
}
</script>

<style lang="css" scoped>
</style>