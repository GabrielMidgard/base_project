<template>
  <div class="user-actions" :id="this.id">
    <button
      type="button"
       @click="updateData()"
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
import { core } from "../../config/pluginInit";

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
        };
      },
      methods: {
        updateData(){
          this.actionType='update';
          this.$router.push({name: this.element, params: {id: this.id}})
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
        if (this.params.data.id) {
          this.id = parseInt(this.params.data.id);
          this.api = this.params.api;
          this.list = this.params.list;
          this.element = this.params.element; 
          this.row = this.params.node.rowIndex;
        }
        var row  = this.params.node.rowIndex
        var colName = this.params.colDef.headerName
      }
    }
  ]
});
</script>