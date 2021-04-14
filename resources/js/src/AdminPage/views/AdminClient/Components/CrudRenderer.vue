<template>
  <div class="user-actions" :id="this.id">
    <button
      type="button"
      :attr="this.id"
       @click="updateData()"
      data-action-type="edit"
      class="btn btn-link btn-warning btn-just-icon text-white"
      style="width: 40px !important;">
      <i class="fas fa-pen"></i>
    </button>

    <!--
    <button
      type="button"
      :attr="this.params.data.id"
      @click="removeData()"
      data-action-type="remove" 
      class="btn btn-link btn-danger btn-just-icon text-white"
      style="width: 40px !important;">
      <i class="fa fa-trash"></i>
    </button>
    -->
  </div>
</template>

<script>
import Vue from "vue";
import { core } from "../../../config/pluginInit";

export default Vue.extend({
    props: ['module'],
    mixins: [{
      data() {
        return {
          actionType:'',
          id:-1,
          api:'',
          list:'',
          row:0,
          elementData:{
            id:-1
          },
        };
      },
      methods: {
        updateData(){
          this.actionType='update';
          this.$router.push({name: 'departments.departament-element', params: {id: this.id}})
        },
        removeData() {
          this.actionType='delete';
          this.params.deleteData(this.actionType, this.id);
          /*
          $router.currentRoute.path
          core.showSnackbar("success", "User has been remove successfully."+this.$route.name);
          */
        }
      },
      beforeMount(){
        if (this.params.data.ID) {
          this.id = parseInt(this.params.data.ID);
          this.api = this.params.api;
          this.list = this.params.list; 
          this.row = this.params.node.rowIndex;
        }
        var row  = this.params.node.rowIndex
        var colName = this.params.colDef.headerName
      }
    }
  ]
});
</script>
