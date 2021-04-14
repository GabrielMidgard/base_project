<template>
  <b-container fluid>
    <b-row>
      <b-col sm="12">
      
        <table-user :api="api" :UrlList="UrlList" :UrlElement="UrlElement"></table-user>

      </b-col>
    </b-row>
  </b-container>
</template>

<script>

  import TableUser from "../Components/Tables/TblUser"; 
  import { core } from "../../config/pluginInit";

export default {
  name: "UsersList",
  
  data() {
    return {
      lblDeleteElement:'',
      api:'api/user',
      UrlList:'users.users-list',
      UrlElement:'users.user-element',
      elementData:null
    };
  },

  components: {
    TableUser
  },
  
  beforeMount() { },
  methods: {
    
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

  mounted() {
    core.index();
  },
}; 
</script>