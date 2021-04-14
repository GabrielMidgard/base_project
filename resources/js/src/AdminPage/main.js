import Vue from 'vue'

import '@babel/polyfill'
import 'mutationobserver-shim'
import './Utils/fliter'
import App from './App.vue'
import router from './router'
import store from './store'

//Pluggins
import './plugins'
//import Raphael from 'raphael/raphael'

import AlgoliaComponents from 'vue-instantsearch'
import i18n from './i18n'

import './directives'
import FileManager from 'laravel-file-manager'

// Vue2-Dropzone
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
Vue.component('vue-dropzone', vue2Dropzone);

import Loading from "./views/AdminClient/Components/Loading.vue"; 
Vue.component('loading', Loading);
//global.Raphael = Raphael 

Vue.use(AlgoliaComponents)
Vue.use(FileManager, {store})
Vue.config.productionTip = false

let vm = new Vue({
  router,
  store,
  i18n,
  data:{
    /*
    inPetition:false,
    logged:false,
    isLoading:{
      show:false,
      label: 'Cargando espere un momento...',
      overlay:true, 
    },
    */
  },
  render: h => h(App)
}).$mount('#app')

window.vm = vm
