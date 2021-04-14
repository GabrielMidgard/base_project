import * as rules from 'vee-validate/dist/rules'
import { required } from "vee-validate/dist/rules";
import { localize, extend, ValidationObserver, ValidationProvider } from 'vee-validate'
import es from "vee-validate/dist/locale/es.json";

import Vue from 'vue'

localize({
  es,
});
localize("es");
extend("required", required);
Object.keys(rules).forEach(rule => {
  extend(rule, rules[rule])
})
Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)

