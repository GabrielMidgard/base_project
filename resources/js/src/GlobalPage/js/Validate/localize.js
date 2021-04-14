import Vue from "vue";
import VeeValidate, { Validator } from 'vee-validate';
import es from 'vee-validate/dist/locale/es';
//Vee-validate	
Validator.localize('es', es);  
Vue.use(VeeValidate,{locale:"es"});
/*
import Vue from "vue";
import { extend, localize } from "vee-validate";
import { required, email, min } from "vee-validate/dist/rules";
import ar from "vee-validate/dist/locale/ar.json";
import en from "vee-validate/dist/locale/en.json";
 
// Install required rule.
extend("required", required);

// Install email rule.
extend("email", email);

// Install min rule.
extend("min", min);

// Install English and Arabic localizations.
localize({
  en: {
    messages: en.messages,
    names: {
      email: "E-mail Address",
      password: "Password"
    },
    fields: {
      password: {
        min: "{_field_} is too short, you want to get hacked?"
      }
    }
  },
  ar: {
    messages: ar.messages,
    names: {
      email: "البريد الاليكتروني",
      password: "كلمة السر"
    },
    fields: {
      password: {
        min: "كلمة السر قصيرة جداً سيتم اختراقك"
      }
    }
  }
});

let LOCALE = "en";

// A simple get/set interface to manage our locale in components.
// This is not reactive, so don't create any computed properties/watchers off it.
Object.defineProperty(Vue.prototype, "locale", {
  get() {
    return LOCALE;
  },
  set(val) {
    LOCALE = val;
    localize(val);
  }
});
*/
/*
import Vue from 'vue';
import VeeValidate, { Validator } from 'vee-validate';
import VeeValidate, { Validator } from "vee-validate";
import es from 'vee-validate/dist/locale/es';

//Vee-validate	
Validator.localize('es', es);
Vue.use(VeeValidate,{locale:"es"});
*/
/*
import VeeValidate from 'vee-validate';

const config = {
  aria: true,
  classNames: {},
  classes: false,
  delay: 0,
  dictionary: null,
  errorBagName: 'errors', // change if property conflicts
  events: 'input|blur',
  fieldsBagName: 'fields',
  i18n: null, // the vue-i18n plugin instance
  i18nRootKey: 'validations', // the nested key under which the validation messages will be located
  inject: true,
  locale: 'es',
  validity: false,
  useConstraintAttrs: true
};

Vue.use(VeeValidate, config);
*/
/*
import attributesEs from 'vee-validate/dist/locale/es'
import attributesEn from 'vee-validate/dist/locale/en'
import VeeValidate, { Validator } from 'vee-validate'

window.Vue = Vue

Validator.localize('es',attributesEs);

Vue.use(VeeValidate, {
  locale: 'es',
  errorBagName: 'validations',
  fieldsBagName: 'inputs',
  dictionary: {
    translationsEn: { attributes: attributesEn },
    translationsEs: { attributes: attributesEs }
  }
});*/