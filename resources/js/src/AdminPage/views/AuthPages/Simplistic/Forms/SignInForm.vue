<template>
  <ValidationObserver ref="form" slim v-slot="{ handleSubmit }">
    <form class="mt-4" novalidate @submit.prevent="handleSubmit(onSubmit)">
      <ValidationProvider vid="Username" name="username" rules="required" v-slot="{ errors }">
        <div class="form-group">
          <input
            type="text"
            :class="'form-control mb-0' +(errors.length > 0 ? ' is-invalid' : '')"
            id="emailInput"
            aria-describedby="emailHelp"
            v-model="user.username"
            placeholder="Email"
            required
          />
          <div class="invalid-feedback">
            <span>{{ errors[0] }}</span>
          </div>
        </div>
      </ValidationProvider>

      <ValidationProvider vid="password" name="Password" rules="required" v-slot="{ errors }">
        <div class="form-group">
          <input
            type="password"
            :class="'form-control mb-0' +(errors.length > 0 ? ' is-invalid' : '')"
            id="passwordInput"
            v-model="user.password"
            placeholder="Contraseña"
            required
          />
          <div class="invalid-feedback">
            <span>{{ errors[0] }}</span>
          </div>
           
          <router-link to="/auth/password-reset1" class="float-right">¿Olvidaste tu contraseña?</router-link>
         
        </div>
      </ValidationProvider>

      <div class="d-inline-block w-100 mt-3">
        <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
          <input type="checkbox" class="custom-control-input" :id="formType" />
          <label class="custom-control-label" :for="formType">Recuérdame</label>
        </div>
        <button type="submit" class="btn btn-primary float-right">Ingresar</button>
      </div>

      <!--
      <div class="sign-info">
        <span class="dark-color d-inline-block line-height-2">
          ¿No tienes una cuenta?
          <router-link
            to="/dark/auth/sign-up1"
            class="iq-waves-effect pr-4"
            v-if="$route.meta.dark">Regístrate</router-link>
          <router-link to="/auth/sign-up" class="iq-waves-effect pr-4" v-else>Regístrate</router-link>
        </span>
        
      </div>
      -->
    </form>
  </ValidationObserver>
</template>

<script>
import auth from "../../../../services/auth";
import { core } from "../../../../config/pluginInit";
import { mapGetters } from "vuex";

export default {
  name: "SignIn1Form",
  //components: { SocialLoginForm },
  props: ["formType", "email", "password"],
  data: () => ({
    user: {
      username: "",
      password: ""
    }
  }),
  mounted() {
    //this.user.email = this.$props.email;
    //this.user.password = this.$props.password;
  },
  computed: {
    ...mapGetters({
      stateUsers: "Setting/usersState"
    })
  },
  methods: {
    onSubmit() {
      if (this.formType === "passport") {
        this.passportLogin();
      }
    },
    passportLogin() {
      this.loading = true;
      
      auth.login(this.user)
        .then(response => {
          if (response.status) {

            var data = response.data;
            var user = JSON.parse(data.data);
            this.loading = false

            if(data.success == false){
              if (response.data.errors.length > 0){
                this.$refs.form.setErrors(response.data.errors);
              }
              //PENDIENTE: Validar que nos regrese el error
              //PENDIENTE: Traduccir errores en diferentes idiomas
              this.$swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '¡Algo salió mal!',
                footer: 'No se puedo iniciar sesion revice sus datos'
              })
            }else{
              this.$swal.fire({
                icon: 'success',
                title: 'iniciado sesión correctamente',//successfully logged in
                showConfirmButton: false,
                timer: 1500
              })

              localStorage.setItem(
                "user",
                JSON.stringify(data.access_token)
              );
              localStorage.setItem("admin_up_access_token", data.access_token);
              localStorage.setItem("admin_up_user_info", JSON.stringify(user));
              this.$router.push("/user/users-list");
                //this.$router.push('/home-2');///auth/sign-in1   register
            }
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    
  }
};
</script>
