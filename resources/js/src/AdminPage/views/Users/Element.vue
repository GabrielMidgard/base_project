<template> 
  <b-container fluid>
    <b-row>
      <b-col lg="12">
        <iq-card>
            
          <template v-slot:body>
            <ValidationObserver ref="observer" v-slot="{ invalid }" >

              <!-- Nombre -->
              <ValidationProvider vid="name" name="Nombre" rules="required" v-slot="{ errors }">
                <b-form-group
                  class="row"
                  label-cols-sm="2"
                  label="Nombre:"
                  label-for="txtName"
                  style="margin-top: 1rem;">
                  <b-form-input id="txtName" 
                    :class="'form-control mb-0' +(errors.length > 0 ? ' is-invalid' : '')"
                    required placeholder="Ingrese nombre"
                    v-model="elementData.name">
                  </b-form-input>

                  <div class="invalid-feedback">
                    <span>{{ errors[0] }}</span>
                  </div>
                </b-form-group>
              </ValidationProvider>

              <!-- Email -->
              <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                <b-form-group
                  class="row"
                  label-cols-sm="2"
                  label="Email:"
                  label-for="txEmail"
                  style="margin-top: 1rem;">
                  <b-form-input id="txEmail" 
                    :class="'form-control mb-0' +(errors.length > 0 ? ' is-invalid' : '')"
                    required placeholder="Ingrese email"
                    v-model="elementData.email">
                  </b-form-input>

                  <div class="invalid-feedback">
                    <span>{{ errors[0] }}</span>
                  </div>
                </b-form-group>
                
              </ValidationProvider> 

              <!-- Password -->
              <ValidationProvider name="Password" rules="required|min:3|max:10" vid="password" v-slot="{ errors }">
                <b-form-group
                  class="row"
                  label-cols-sm="2"
                  label="Contraseña:"
                  label-for="txtPsw"
                  style="margin-top: 1rem;">
                  <b-form-input id="txtPsw" 
                    :class="'form-control mb-0' +(errors.length > 0 ? ' is-invalid' : '')"
                    required placeholder="Ingrese contraseña"
                    v-model="elementData.password">
                  </b-form-input>

                  <div class="invalid-feedback">
                    <span>{{ errors[0] }}</span>
                  </div>
                </b-form-group>

              </ValidationProvider>

              <!-- Rol -->
              <ValidationProvider rules="required|excluded:-1" name="Rol" v-slot="{ classes, errors }">
                <b-form-group
                  class="row"
                  label-cols-sm="2"
                  label="Seleccionar Rol:"
                  label-for="sltRol"
                  style="margin-top: 1rem;">  
                        
                  <b-form-select id="sltRol" 
                    v-model="elementData.fk_rol"  
                    :options="rolOptions"
                    :class="classes"></b-form-select>
                    <span style="color: #EB0600">{{ errors[0] }}</span>
                     
                </b-form-group>
              </ValidationProvider>
              
              <!-- Image -->
              <b-form-group
                class="row"
                label-cols-sm="2"
                label="Imagen de curso:"
                label-for="imageCourse"
                style="margin-top: 1rem;">

                <input id="imageCourse" type="file" accept="image/*" @change="onChangeImage" />
                <div id="preview mt-4">
                    <img v-if="elementData.imageUrl" :src="elementData.imageUrl" style="max-width: 250px;"/>
                </div>
              
              </b-form-group>
          
              
              <!-- Active -->
              <b-form-group
                v-if="elementData.id != -1"
                class="row"
                label-cols-sm="2"
                label="Activo:"
                label-for="active">
                <button id="active" v-if="elementData.active === 1" class='btn btn-success btn-xs' 
                @click="eventActive(0)">Activado</button>
              
                <button id="active"  v-else class='btn btn-danger btn-xs'
                @click="eventActive(1)">Desactivado</button>
              </b-form-group> 

              <div class="text-right">
                <b-button v-if="elementData.id === -1" variant="outline-success" class="mb-3 mr-1"
                @click="addElement()" :disabled="invalid">
                  <i class="far fa-save"></i>Guardar</b-button>
                <button v-else type="button" class="btn mb-3 mr-1 btn-warning rounded-pill text-white"
                @click="updateElement()" :disabled="invalid">
                  <i class="fas fa-pen"></i>Actualizar</button>
                <b-button v-if="elementData.id != -1" variant="outline-danger" class="mb-3 mr-1"
                @click="deleteElement()">
                  <i class="fa fa-trash"></i>Borrar</b-button>
                <b-button variant="outline-secondary" class="mb-3 mr-1"
                @click="returnList()">
                  <i class="fas fa-door-closed"></i>Cerrar</b-button>
              </div>

            </ValidationObserver>
           
          </template>
        </iq-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>

import { core } from "../../config/pluginInit";
import crud from "../../services/crud";

export default {
  name: "UserElement",
  
  data() {
    return {
      api:'api/user',
      list:'users.users-list',
      elementData:{
        id:-1,
        name:'',
        email:'',
        email_verified_at:'',
        password:'',
        image_id:0,
        image:null,
        imageUrl:'',
        fk_rol:-1, 
        active:1,
      },
      rolOptions:[{ value: -1, text: 'Seleccione rol' }],
    };
  }, 
  methods:{
    onSubmit() {
      this.addElement();
    },
    getElementData:function(){
      var paramsData = {
        id:this.elementData.id,
        api:this.api+'/getElement'
      }
      var me = this;
      crud.getElementData(paramsData)
        .then(response => {
          if (response.status == 200) {
            var data = response.data;
            me.elementData = data;
            me.rolOptions = me.rolOptions.concat(data.rolOptions); 
            
          }else{
            if (response.data.errors.length > 0){
                me.$refs.form.setErrors(response.data.errors);
            }
            //PENDIENTE: Validar que nos regrese el error
            //PENDIENTE: Traduccir errores en diferentes idiomas
            me.$swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '¡Algo salió mal!',
              footer: 'No se puedo iniciar sesion revice sus datos'
            })
          }
        })
        .finally(() => {
          this.loading = false;
      });
    },
    eventActive:function(status){
      this.elementData.active = status;
    }, 
    
    addElement:function(){
      var paramsData = {
        elementData:this.elementData,
        api:this.api+'/add'
      }

      let formData = new FormData();
      formData.append("name", this.elementData.name);
      formData.append("email", this.elementData.email);
      formData.append("password", this.elementData.password);
      formData.append("fk_rol", this.elementData.fk_rol);
      formData.append("active", this.elementData.active);
      
      if(this.elementData.image){
        formData.append('image', this.elementData.image);
      }

      var me = this;
      crud.addElementMultimedia(paramsData, formData)
        .then(response => {
          if (response.status == 200) {
            this.notice('success', 'Se añadió satisfactoriamente');
            me.$router.push({ name: this.list })
          }else{
            if (response.data.errors.length > 0){
                me.$refs.form.setErrors(response.data.errors);
            }
            //PENDIENTE: Validar que nos regrese el error
            //PENDIENTE: Traduccir errores en diferentes idiomas
            me.$swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '¡Algo salió mal!',
              footer: 'No se puedo iniciar sesion revice sus datos'
            })
          }
        })
        .finally(() => {
          this.loading = false;
      });
    },
    updateElement:function(){
      var paramsData = {
        elementData:this.elementData,
        api:this.api+'/update'
      }
      let formData = new FormData();
      formData.append("id", this.elementData.id);
      formData.append("name", this.elementData.name);
      formData.append("email", this.elementData.email);
      formData.append("password", this.elementData.password);
      formData.append("fk_rol", this.elementData.fk_rol);
      formData.append("active", this.elementData.active);
      
      if(this.elementData.image){
        formData.append('image', this.elementData.image);
      }

      var me = this;
      crud.updateElementMultimedia(paramsData, formData)
        .then(response => {
          if (response.status == 200) {
             this.notice('success', 'Se ha actualizado correctamente');
            me.$router.push({ name: this.list })
          }else{
            if (response.data.errors.length > 0){
                me.$refs.form.setErrors(response.data.errors);
            }
            //PENDIENTE: Validar que nos regrese el error
            //PENDIENTE: Traduccir errores en diferentes idiomas
            me.$swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '¡Algo salió mal!',
              footer: 'No se puedo iniciar sesion revice sus datos'
            })
          }
        })
        .finally(() => {
          this.loading = false;
      });
    },
    deleteElement:function(){
      var me = this;
      this.$swal.fire({
        title: '¿Seguro que deseas borrar este elemento?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, adelante'
      }).then((result) => {
        if (result.isConfirmed) {
          var paramsData = {
            elementData:me.elementData,
            api:me.api+'/delete'
          }
      
          crud.deleteElement(paramsData)
          .then(response => {
            if (response.status == 200) {
              me.notice('success', 'El elemento ha sido eliminado');
              me.$router.push({ name: me.list })
            }else{
              if (response.data.errors.length > 0){
                me.$refs.form.setErrors(response.data.errors);
              }
              //PENDIENTE: Validar que nos regrese el error
              //PENDIENTE: Traduccir errores en diferentes idiomas
              me.$swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '¡Algo salió mal!',
                footer: 'No se puedo iniciar sesion revice sus datos'
              })
            }
          })
          .finally(() => {
            this.loading = false;
          });
        }
      })
    },
    returnList:function(){
      this.$router.push({ name: this.list })
    } ,
    getListOptions:function(){
      var paramsData = {
        api:this.api+'/getOptions'
      }
      var me = this;
      crud.getListData(paramsData)
        .then(response => {
          if (response.status == 200) {
            var data = response.data;
            me.rolOptions = me.rolOptions.concat(data); 
            
          }else{
            if (response.data.errors.length > 0){
                me.$refs.form.setErrors(response.data.errors);
            }
            //PENDIENTE: Validar que nos regrese el error
            //PENDIENTE: Traduccir errores en diferentes idiomas
            me.$swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '¡Algo salió mal!',
              footer: 'No se puedo iniciar sesion revice sus datos'
            })
          }
        })
        .finally(() => {
          this.loading = false;
      });
    },

    onChangeImage(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
          return;
      this.createImage(files[0]);
      this.elementData.image = files[0];
    },
    
    createImage(file) {
      let reader = new FileReader();
      let me = this;
      reader.onload = (e) => {
        //vm.image = e.target.result;
        me.elementData.imageUrl = e.target.result;
      };
      reader.readAsDataURL(file);
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
    if(this.$route.params.id){
      this.elementData.id=this.$route.params.id;

      this.getElementData();
    }else{
      this.getListOptions(); 
    }
  }
}; 
</script>
