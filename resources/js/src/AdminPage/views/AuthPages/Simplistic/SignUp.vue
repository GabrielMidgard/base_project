<template>
  <div>
    <h1 class="txtColor-login mb-0 text-center"><b>Registrarte</b></h1>
    <p>Es rápido y fácil</p>
   
    <div id="pills-tabContent-1" class="mt-0">
      <sign-up-form formType="passport"></sign-up-form>
    </div>

  </div>
</template>

<style>
  .txtColor-login{
    color:#e0a861 !important;
  }
</style>

<script>

import SignUpForm from './Forms/SignUpForm'
import auth0 from 'auth0-js'
import constant from '../../../config/constant'

export default {
  name: 'SignUp',
  components: { SignUpForm },
  data: () => ({}),
  methods: {
    loginOAuth0 () {
      new auth0.WebAuth(constant.auth0Config).authorize()
    }
  }
}
</script>
