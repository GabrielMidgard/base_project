<template> 
  <b-container fluid>
    <b-row>
      <b-col lg="12">
        <iq-card>
            
          <template v-slot:body>

            <b-form-group
              class="row"
              label-cols-sm="2"
              label="Titulo:"
              label-for="txtTitle"
              style="margin-top: 1rem;">

               <vue-dropzone  
               :useCustomSlot=true
              :options="dropzoneOptions"
              :duplicateCheck="true"
              id="dropzoneProducts"
              ref="myVueDropzone"
              @vdropzone-queue-complete="afterComplete">
                 <div class="dropzone-custom-content">
                  <h3 class="dropzone-custom-title">¡Arrastra y suelta para subir contenido!</h3>
                  <div class="subtitle">... o haga clic para seleccionar un archivo de su computadora</div>
                </div>
              </vue-dropzone>

              <!--
              
              -->
              <!--
                 @vdropzone-file-added="vfileAdded"
                @vdropzone-success="vsuccess"
                @vdropzone-error="verror"
                @vdropzone-removed-file="vremoved"
              -->
               
                
             

            </b-form-group>

       

            <div class="text-right">
              <b-button variant="outline-success" class="mb-3 mr-1"
               @click="addElement()">
                <i class="far fa-save"></i>Guardar</b-button>
              
            </div>
           
          </template>
        </iq-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>

import { core } from "../../../config/pluginInit";
import crud from "../../../services/crud";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
  name: "GalleryElement",
  components: {
    vueDropzone: vue2Dropzone
  },
  data() {
    return {
      id:0,
      api:'api/menus',
      list:'products.gallery',
      elementData:{
        id:-1,
      },
      
      dropzoneOptions: {
        url: 'store-multiple-image',
        thumbnailWidth: 150,
        maxFilesize: 5.5,
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
        },
        addRemoveLinks: true
      },

    };
  }, 
  methods:{
    addElement:function(){
      
    },
    
    afterComplete(file, xhr, formData) {
      this.notice('success', 'Se han subido las imagines');
      var objVueDropzone = this.$refs.myVueDropzone;
      setTimeout(function() {  
        objVueDropzone.removeAllFiles();
      }, 3000);
      
      // window.toastr.success('', 'Event : vdropzone-queue-complete')
    },
    
		notice (type, message) { 
      var title = '';
      if(type == 'success'){
        title = "Noticia"
      }
      else if(type == 'warning'){
        title = "Noticia de advertencia"
      }
      this.$notice[type]({
        title: title,
        description: message
      })
    },
  },
  
  mounted(){
    core.index();
    
  }
}; 
</script>
