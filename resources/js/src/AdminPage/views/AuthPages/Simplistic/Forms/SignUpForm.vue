<template>
  <ValidationObserver ref="form" v-slot="{ handleSubmit }">
    
    <form class="mt-4" novalidate @submit.prevent="handleSubmit(onSubmit)">
      
      <ValidationProvider :vid="`${formType}-name`" name="Full Name" rules="required" v-slot="{ errors }">
        <div class="form-group">
          <input type="text" v-model="user.name" :class="'form-control mb-0' +(errors.length > 0 ? ' is-invalid' : '')"
                 :id="`${formType}-name`" aria-describedby="emailHelp" placeholder="Nombre completo">
          <div class="invalid-feedback">
            <span>{{ errors[0] }}</span>
          </div>
        </div>
      </ValidationProvider>

      <ValidationProvider :vid="`${formType}-email`" name="Email" rules="required|email" v-slot="{ errors }">
        <div class="form-group">
          <input type="email" v-model="user.email" :class="'form-control mb-0' +(errors.length > 0 ? ' is-invalid' : '')"
                 :id="`${formType}-email`" aria-describedby="emailHelp" placeholder="Correo electrónico">
          <div class="invalid-feedback">
            <span>{{ errors[0] }}</span>
          </div>
        </div>
      </ValidationProvider>

      <ValidationProvider :vid="`${formType}-password`" name="Password" rules="required" v-slot="{ errors }">
        <div class="form-group">
          <input type="password" v-model="user.password" :class="'form-control mb-0' +(errors.length > 0 ? ' is-invalid' : '')"
          
          :id="`${formType}-password`" placeholder="Contraseña">
          <div class="invalid-feedback">
            <span>{{ errors[0] }}</span>
          </div>
        </div>
      </ValidationProvider>
<!-- minlength="8"-->
       

      <div class="d-inline-block w-100">
        <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
          <input type="checkbox" class="custom-control-input" :id="formType"
          v-model="user.termAndConditions">
          <label class="custom-control-label" :for="formType">Al hacer clic en "Registrarte", aceptas nuestras <a href="#">Condiciones</a>, <a href="#">los terminos de uso</a> y la <a href="#">Política de cookies</a>. Es posible que te enviemos notificaciones, que puedes desactivar cuando quieras.
          </label>
        </div>
        <button type="submit" class="btn btn-primary float-right">Registrarte</button>
      </div>
      <div class="sign-info">
          <span class="dark-color d-inline-block line-height-2">
            ¿Ya tienes una cuenta?
              <router-link to="/dark/auth/login" class="iq-waves-effect pr-4" v-if="$route.meta.dark">
                Ingresar
              </router-link>
            <router-link to="/auth/login" class="iq-waves-effect pr-4" v-else>
                Ingresar
              </router-link>
          </span>
      </div>
    </form>
  </ValidationObserver>
</template>

<script>
import auth from '../../../../services/auth'
import { mapGetters } from 'vuex'

export default {
  name: 'SignUpForm',
  components: {  },
  props: ['formType'],
  computed: {
    ...mapGetters({
      users: 'Setting/usersState' 
    })
  },
  data: () => ({
    user: {
      email: '',
      password: '',
      termAndConditions: false
    }
  }),
  methods: {
    onSubmit () {
      if (this.formType === 'passport') {
        this.passportRegister()
      } 
    },
    passportRegister () {
      if(this.user.termAndConditions == false){
       this.notice('warning', 'Si desea crear una cuanta debe aceptar nuestras politicas, terminos y condiciones');
      }else{
        this.loading = true;
 
        auth.register(this.user).then(response => {
          if (response.status) {
            var data = response.data;
            this.loading = false

            if(data.status == false){
              if (response.data.errors.length > 0){
                this.$refs.form.setErrors(response.data.errors);
              }
              //PENDIENTE: Validar que nos regrese el error
              //PENDIENTE: Traduccir errores en diferentes idiomas
              this.$swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '¡Algo salió mal!',
                footer: 'No se puedo crear su cuenta, su información'
              })
              /*"errors":{"password":["The password must be at least 8 characters."]}
              //data.errors //Array
              //data.message*/
            }else{
              this.$swal.fire({
                icon: 'success',
                title: 'Cuenta creada correctamente',//successfully logged in
                showConfirmButton: false,
                timer: 1500
              })
              //this.$router.push('/home-2');///auth/sign-in1   register
            }
          }
        }).finally(() => { this.loading = false })
      }
      
     
    },
    notice (type, message) { 
      var title = '';
      if(type == 'warning'){
        title = "Noticia de advertencia"
      }
      this.$notice[type]({
        title: title,
        description: message
      })
    },
  }
}
</script>
