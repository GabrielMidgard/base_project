<template>
  <div>
    <h1 class="txtColor-login mb-0 text-center"><b>Iniciar sesión</b></h1> 
    <p>Ingrese su dirección de correo electrónico y contraseña para acceder al panel de administración.</p>
    <div id="pills-tabContent-1" class="mt-0">
      <sign-in-form formType="passport"></sign-in-form>
    </div>
  </div>
</template>

<style>
  .txtColor-login{
    color:#185cad !important;
  }
</style>

<script>
import auth0 from 'auth0-js'
import SignInForm from './Forms/SignInForm'
import constant from '../../../config/constant'

export default {
  name: 'SignIn',
  components: { SignInForm },
  data: () => ({}),
  mounted () {
    const loggedIn = localStorage.getItem('access_token')
    if (loggedIn !== undefined && loggedIn !== null) {
      this.$router.push({ name: 'users.users-list' })
    }
  },
  methods: {
    loginOAuth0: function () {
      new auth0.WebAuth(constant.auth0Config).authorize()
    }
  }
}
</script>
