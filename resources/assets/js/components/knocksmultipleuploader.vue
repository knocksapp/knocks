<template>
<div >
    <div class="file-field input-field" v-if = "draggingMode">
        <div class="col s12 btn knocks_bordered_uploader valign-wrapper animated rubberBand"  >
            <span class = "knocks_text_md knocks_multiple_uploader_span" >
                <static_message msg="Drop Your Files Here .." ></static_message>
                <span class = "knocks-upload10"></span>
            </span>
            <input type="file"  multiple :id="gid"  @change = "construct()" :content = "content">
        </div>

        <div class="file-path-wrapper ">
            <input class="file-path validate knocks_hidden "  v-model = "names" type="text" placeholder="Upload one or more files">
        </div>
    </div>

    <div class = "row knocks_house_keeper" v-if = "files.length > 0" :class = "[{'knocks_hidden':isLoading}]">
        <div class = "col s3 knocks_house_keeper offset-s1 knocks_image_mup_port" v-for = "(img , index) in images" style="line-hight : 200px">

            <knockspopover>
            <template slot = "container">
                <a @click = "spliceFile(index)" class="red circle">
                <span class="badge red-text"><span class = "knocks-close"></span></span>
            </a><br/>
            <knocksimageeditor :gid = "gid+'_image_editor_'+index" v-model = "imageblobs[index]"
            :source = "blobs[img]"
            ></knocksimageeditor>
            </template>
            <span slot = "content"  class = "knocks_tooltip animated flipInX" >
                <span class ="knocks-pictures5"></span>
                {{files[img].name}}
            </span>
            </knockspopover>
            <!-- <br/> -->
            <knockspopover>
            <template slot = "container">

            <span
                v-if = "files[img].name != undefined
                && files[img].type != undefined
                && files[img].name != undefined
                && !notAnImage(index)
                && files[img].name.length < 15 "
                :class = "[file_name_class]">{{files[img].name}}
            </span>
            <span
                v-if = "files[img].name != undefined
                && files[img].type != undefined
                && files[img].name != undefined
                && !notAnImage(index)
                && files[img].name.length "
                :class = "[file_name_class]">{{minimizedText(files[img].name)}}
            </span>
            </template>
            <span slot = "content"  class = "knocks_tooltip animated flipInX" >

                {{files[img].name}}
            </span>
            </knockspopover>

        </div>
    </div>
    <br v-if="images.length > 0" />
    <hr v-if="images.length > 0" />
    <div :class = "[icons_parent_holder , {'knocks_hidden':isLoading}]" v-if = "files.length > 0">
        <div v-for = "(file, index) in files" v-if = "files.length > 0 && notAnImage(index)" :class = "[icons_container]">
            <a @click = "spliceFile(index)" class="red circle" >
                <span class="badge red-text"><span class = "knocks-close"></span></span>
            </a>
            <br/>
            <knockspopover>
            <template slot = "container" v-if = "file.name != undefined && file.type != undefined" >
            <span v-if = "file.name != undefined && file.type != undefined && extensions[file.type] != undefined"
            :class = "[extensions[file.type] , icons_class ]"></span>
            <span v-if = "file.name != undefined
                && file.type != undefined
                && file.name != undefined
                && file.name.length < 15
                && notAnImage(index)"
            :class = "[file_name_class]">{{file.name}}</span>
            <span v-if = "file.name != undefined
                && file.type != undefined
                && file.name != undefined
                && file.name.length > 15
                && notAnImage(index)"
            :class = "[file_name_class]">{{minimizedText(file.name)}}</span>
            </template>
            <span slot = "content"  class = "knocks_tooltip animated flipInX" >
                <span :class = "[extensions[file.type] , 'knocks_text_light']"></span>
                <span>{{file.name}}</span>
            </span>
            </knockspopover>

        </div>
    </div>
    <div v-if = "isLoading" class = "animated fadeIn    ">

          <h4 class="ui horizontal divider header transparent">

      <i class="knocks-cloud-upload4 blue-text   knocks_text_ms"></i>
      <span classe = "blue-text animated pulse infinite">Uploading {{emitCounter+1}}/{{filesCounter}}</span>
      </h4>
       <center> <el-progress type="circle" :percentage="loadingPercentage"></el-progress> </center>
    </div>
</div>
</template>

<script>
export default {
	props : {
		gid : {
			type : String ,
			required : true
		},
		icons_class : {
			type : String ,
			default : 'knocks_text_dark knocks_text_lg'
		},
		file_name_class : {
			type : String ,
			default : 'knocks_text_dark knocks_text_sm knocks_word_break'
		},
		icons_container : {
			type : String ,
			default : 'col s4'
		},
		icons_parent_holder : {
			type : String ,
			default : 'row'
		},
        images_url : {
            type : String ,
            default : 'media/image/upload'
        },
        regular_files_url : {
            type : String ,
            default : 'media/file/upload'
        },
        scope : {
            type : Array ,
            default : null
        },
        max_size : {
            type : Number ,
            default : 52428800
        }



	},
  data () {
    return {
    	content : null ,
    	files : [],
        blobs : [] ,
        images : [] ,
        names : null ,
        imageblobs : [],
        imagesExtensions : ['image/png' , 'image/jpeg' , 'image/jpg'],
        imagesTokens : [],
        filesTokens : [],
        draggingMode : false ,
        imagesQuotes : [],
        emitCounter : 0 ,
        blobsIndex : 0 ,
        isLoading : false ,
        nwerrors : null ,
        isUploading : false ,
        loadingPercentage : 0 ,





    	extensions :  {
    		"text/x" : 'knocks-document-file-app2' ,
    		"application/pdf" : 'knocks-document-file-pdf2' ,
    		"audio/mpeg" : 'knocks-document-file-mp32' ,
    		"video/mp4" : 'knocks-document-file-mp42' ,
    		"application/x-iwork-pages-sffpages" : 'knocks-document-file-pages' ,
    		// "text/x" : 'knocks-document-file-mov2' ,
    		// "text/x" : 'knocks-document-file-key2' ,
    		// "text/x" : 'knocks-document-file-html2' ,
    		// "text/x" : 'knocks-document-file-css2' ,
        "application/javascript" : 'knocks-file',
    		"text/x-java-source,java" : 'knocks-document-file-java2' ,
    		"image/vnd.adobe.photoshop" : 'knocks-document-file-psd2' ,
    		"application/vnd.adobe.air-application-installer-package+zip" : 'knocks-document-file-ai2' ,
    		"image/bmp" : 'knocks-document-file-bmp2' ,
    		"image/vnd.dwg" : 'knocks-document-file-dwg2' ,
    		// "text/x" : 'knocks-document-file-eps2' ,
    		"image/tiff" : 'knocks-document-file-tiff2' ,
    		"application/vnd.oasis.opendocument.spreadsheet-template" : 'knocks-document-file-ots2' ,
    		"text/php" : 'knocks-document-file-php2' ,
    		// "text/x" : 'knocks-document-file-py2' ,
    		// "text/x" : 'knocks-document-file-c2' ,
    		// "text/x" : 'knocks-document-file-sql2' ,
    		// "text/x" : 'knocks-document-file-rb2' ,
    		"text/x-c" : 'knocks-document-file-c2' ,
    		// "text/x" : 'knocks-document-file-tga2' ,
    		// "text/x" : 'knocks-document-file-doc2' ,
    		// "text/x" : 'knocks-document-file-xls2' ,
    		// "text/x" : 'knocks-document-file-docx2' ,
    		// "text/x" : 'knocks-document-file-ppt2' ,
    		// "text/x" : 'knocks-document-file-asp2' ,
    		"text/calendar" : 'knocks-document-file-ics2' ,
    		// "text/calendar" : 'knocks-document-file-dat2' ,
    		// "text/x" : 'knocks-document-file-xml2' ,
    		// "text/x" : 'knocks-document-file-h2' ,
    		"application/x-msdownload" : 'knocks-document-file-exe2' ,
    		"video/x-msvideo" : 'knocks-document-file-avi2' ,
    		// "text/x" : 'knocks-document-file-dotx2' ,
    		"text/plain" : 'knocks-document-file-txt2' ,
    		"application/rtf" : 'knocks-document-file-rtf2' ,
    		"video/x-m4v" : 'knocks-document-file-m4v2' ,
    		"video/x-flv" : 'knocks-document-file-flv2' ,
    		"audio/mpeg" : 'knocks-document-file-mpg2' ,
    		"video/3gpp" : 'knocks-document-file-3gp2' ,
    		"application/vnd.oasis.opendocument.text-template" : 'knocks-document-file-ott2' ,
    		// "text/x" : 'knocks-document-file-tgz2' ,
    		// "text/x" : 'knocks-document-file-zip2' ,
    		"application/x-apple-diskimage" : 'knocks-document-file-dmg2' ,
    		// "text/x" : 'knocks-document-file-iso2' ,
    		// "text/x" : 'knocks-document-file-rar2' ,
    		// "text/x" : 'knocks-document-file-gif2' ,
        "application/zip" : 'knocks-document-zip',
        "application/x-rar-compressed" : 'knocks-document-file-rar2' ,
        "application/zip" : 'knocks-document-zip',
        "application/mp4" : 'knocks-document-file-mp42',
        "application/x-msaccess" : 'knocks-brand155',
        "application/vnd.ms-excel" : 'knocks-brand156',
        "application/vnd.ms-powerpoint" : 'knocks-brand159',
        "application/onenote" : 'knocks-brand157',
        "application/msword" : 'knocks-brand160',
        "application/vnd.openxmlformats-officedocument.presentationml.presentation" : 'knocks-brand159',
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document" : 'knocks-brand160',
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" : 'knocks-brand156',
        "application/rss+xml" : 'knocks-document-file-xml2' ,
        "image/gif" : 'knocks-document-file-gif2' ,

    	}
    }
  },
  mounted(){
    const vm = this;
    App.$on('knocks_submit' , (scope) =>{
        // if(vm.filesCounter > 0){
            if(scope != null && scope.length > 0 && vm.scope != null && vm.scope.length > 0){
            let i;
            for(i = 0; i < scope.length; i++){

              if(vm.scope.indexOf(scope[i]) != -1){
               vm.upload();
               return;
              }
            }
            return;
           }
      // }else return;
    });

    App.$on('knocks_multiple_uploader_reset' , (scope) =>{
        if(vm.filesCounter > 0){
            if(scope != null && scope.length > 0 && vm.scope != null && vm.scope.length > 0){
            let i;
            for(i = 0; i < scope.length; i++){

              if(vm.scope.indexOf(scope[i]) != -1){
               vm.reset();
               return;
              }
            }
            return;
           }
      }else return;
    });

    this.$on('mediaQueryCounter', ()=>{
        vm.emitCounter++;
        if(vm.emitCounter == vm.filesCounter){
            const vm = this;
            let tokens = {files : vm.filesTokens , images : vm.imagesTokens };
            let hasFiles = vm.finalResult.regularFiles.length > 0 ? true : false ;
            let hasImages = vm.finalResult.images.length > 0 ? true : false ;

            App.$emit('knocksMediaQueryLogged' , { scope : vm.scope , token : tokens , query : 'file' , hasFiles : hasFiles , hasImages : hasImages });
            vm.isLoading = false;
        }
    });

    //Dragging Mode Triggers
    let dragTimer;
    $(document).on('dragover', function(e) {
      var dt = e.originalEvent.dataTransfer;
      if (dt.types && (dt.types.indexOf ? dt.types.indexOf('Files') != -1 : dt.types.contains('Files'))) {
        vm.draggingMode = true ;
        App.$emit('knocksMultipleUploaderDragging' , true);
        window.clearTimeout(dragTimer);
      }
    });
    $(document).on('dragleave', function(e) {
      dragTimer = window.setTimeout(function() {
        vm.draggingMode = false ;
        App.$emit('knocksMultipleUploaderDragging' , false);
      }, 25);
    });

    //Responding on manual Triggers
    App.$on('knocksMultipleUploaderTrigger' , (scope)=>{
        if(scope != null && scope.length > 0 && vm.scope != null && vm.scope.length > 0){
            let i;
            for(i = 0; i < scope.length; i++){
              if(vm.scope.indexOf(scope[i]) != -1){
                //if(!vm.draggingMode)
               vm.triggerDraggingMode();
               return;
              }
            }
            return;
        }
    });
  },
  computed : {
    regularFiles(){
        let res , file;
        res = [];
        for(file in this.files){
            if(this.imagesExtensions.indexOf(this.files[file].type) == -1 ){
                res.push(this.files[file]);
                res[res.length-1]['blob']= this.blobs[file];
            }
        }
        return res;
    },
    finalResult(){
        let res = { regularFiles : this.regularFiles , images : this.imageblobs};
        let img , imagesNames , imagesTypes;
        imagesNames = [];
        imagesTypes = [];
        for(img in this.images){
            imagesNames.push(this.files[parseInt(this.images[img])].name);
            imagesTypes.push(this.files[parseInt(this.images[img])].type);
        }
        res['imagesNames'] = imagesNames;
        res['imagesTypes'] = imagesTypes;
        this.$emit('input' , res);
        return res;
    },
    filesCounter(){
        return this.finalResult.images.length + this.finalResult.regularFiles.length  ;
    }
  },
  methods : {
  	construct(){
  		//this.$emit('input' , event.target.files);
  		this.content = document.getElementById(this.gid).files;
  		//console.log(this.content);
  		this.analysis();
    },
    reset(){
        this.content = null ;
        this.files = [];
        this.blobs = [] ;
        this.images = [] ;
        this.names = null ;
        this.imageblobs = [];
        this.imagesTokens = [];
        this.imagesQuotes =[];
        this.filesTokens = [];
        this.draggingMode = false ;
        this.emitCounter = 0 ;
        this.blobsIndex = 0;

    },
    analysis(){
        const vm  = this;
    	//this.files =  [];
        //this.blobs = [];
    	if(this.content.length == 0){
    		return;
    	}else{
    		let file , fileHasher, fileReader;
            for (file = 0;  file < this.content.length; file++){
                fileReader = new FileReader();
                fileReader.onload = (function(currentFile , len , indexCounter){
                   return function(data){
                    //Validation Goes Here
                    if(currentFile.size < vm.max_size){
                        vm.files.push(
                            {
                                name : currentFile.name ,
                                type : currentFile.type ,
                                size : currentFile.size
                            }
                        )
                        vm.blobs.push(data.target.result);
                        vm.imageHasher();
                        vm.restructureNames();
                        vm.$emit('input' ,  { regularFiles : vm.regularFiles , images : vm.imageblobs});
                        App.$emit('knocksMultipleUploaderDragging' , false);
                        vm.draggingMode = false ;
                    }else{
                        vm.notify(currentFile.name);
                    }
                   };
               })(document.getElementById(this.gid).files[file] );
               fileReader.readAsDataURL(document.getElementById(this.gid).files[file]);
            }
    	}
    }, imageHasher(){
        if(this.files.length == 0){
            this.images = [];
            return;
        }else{
           let file ;
           this.images = [];
           for(file in this.files){
            if(this.imagesExtensions.indexOf(this.files[file].type) != -1)
            this.images.push(file);
           }
        }
    } ,
    notAnImage(index){
        return this.imagesExtensions.indexOf(this.files[index].type) == -1 ? true : false ;
    },
    getTheEquiv(index){
        let i , counter;
        for(i = 0; i <= index ; i++){
            if(!this.notAnImage(i))
                counter++;
        }
        return counter;
    },
    spliceFile(index){
        if(!this.notAnImage(index)){
            this.imageblobs.splice(this.getTheEquiv(index));
        }
        this.files.splice(index, 1);
        this.blobs.splice(index, 1);
        this.imageHasher();
        this.refreshImagePorts();
        this.restructureNames();
        this.$emit('input' ,  { regularFiles : this.regularFiles , images : this.imageblobs});

    },
    refreshImagePorts(){
        let temp = this.images;
        this.images = [];
        $('.knocks_image_mup_port').empty();
        setTimeout( ()=>{ this.images = temp } ,200);
    },
    restructureNames(){
        let file ;
        this.names = [];
        for(file in this.files){
            this.names.push(this.files[file].name)
        }
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
    triggerDraggingMode(){
        this.draggingMode = !this.draggingMode;
    },
    notify(name) {
        this.$notify.error({
          title : 'Too large file!' ,
          message: 'Oops, Your file `'+name+'` size is too large, it must be less than 50MB',

        });
    },
    upload(){
        if(this.finalResult.images.length == 0 && this.finalResult.regularFiles.length ==0){
          App.$emit('knocksMediaQueryLogged' , { scope : this.scope , token : null , query : 'file' , hasFiles : false , hasImages : false });
          return;
        }
        const vm = this;
        //Seperating the images

        let img , counter;
        counter = 0;
        for(img in this.finalResult.images){
            axios({
                method : 'post' ,
                url : LaravelOrgin + vm.images_url ,
                data : {
                    object : { blob : vm.finalResult.images[img].blob.replace('data:'+vm.finalResult.imagesTypes[img]+';base64,' ,'') ,
                    name : vm.finalResult.imagesNames[img] ,
                    extension : vm.finalResult.imagesTypes[img] ,
                    quote : vm.finalResult.images[img].quote ,
                    album : 'Timeline'  },
                },
                onDownloadProgress : ()=>{ vm.isLoading = true ;} ,
                onUploadProgress : (progressEvent)=>{
                    vm.isLoading = true ;
                    vm.isUploading = true;
                    vm.loadingPercentage = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
                } ,
            }).then((response)=>{
                vm.isUploading = false ;
                if(response.data != 'invalid')

                  
                  //console.log('final res');
                  //console.log(vm.finalResult);

                  vm.imagesTokens.push(response.data);
                  vm.$emit('mediaQueryCounter');
                  counter++;

            }).catch((err)=>{
                vm.nwerrors = err ;
            });
        }

        //Separating the regular files

        let file;
        for(file in this.finalResult.regularFiles){
            axios({
                method : 'post' ,
                url : LaravelOrgin + vm.regular_files_url ,
                // data : vm.regularFiles[file]
                  data : {
                    object : {
                    blob : vm.regularFiles[file].blob.replace('data:'+vm.regularFiles[file].type+';base64,',''),
                    name : vm.regularFiles[file].name ,
                    extension : vm.regularFiles[file].type ,
                    album : 'Timeline'  },
                },
                onDownloadProgress : ()=>{ vm.isLoading = true ;} ,
                onUploadProgress : (progressEvent)=>{
                    vm.isLoading = true ; vm.isUploading = true;
                    vm.loadingPercentage = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
                }

            }).then((response)=>{
                vm.isUploading = false ;
                if(response.data != 'invalid')
                  vm.filesTokens.push(response.data);
                  vm.$emit('mediaQueryCounter');
            }).catch((err)=>{
                vm.nwerrors = err ;
                vm.isUploading = false ;
                vm.isLoading = false ;
            });
        }


    }
  }
}
</script>

<style lang="css" scoped>
.knocks_bordered_uploader > span{
    padding : 5% !important;
}
.knocks_bordered_uploader{
    background-color: #fff;
    border: 1px dashed #691a40 !important;
    color: #691a40;
    border-radius: 10px !important;
    display: block !important;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    -webkit-box-shadow: 0 0 0 0;
    box-shadow: 0 0 0 ;

}


</style>
