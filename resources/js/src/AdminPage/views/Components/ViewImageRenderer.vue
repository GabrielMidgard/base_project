<template>
  <div class="user-actions" :id="this.id">
    <button
      type="button"
      :attr="this.id"
      @click="viewImage()"
      class="btn btn-link btn-warning btn-just-icon text-white"
      style="width: 40px !important;">
      <i class="fas fa-eye"></i>
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
        viewImage(){
          this.actionType='update';
          this.params.context.componentParent.viewImageModal(this.params.data.name, this.params.data.colorId, this.params.data.image_url);
        },
      },
      beforeMount(){
        var row  = this.params.node.rowIndex
        var colName = this.params.colDef.headerName
      }
    }
  ]
});
</script>
