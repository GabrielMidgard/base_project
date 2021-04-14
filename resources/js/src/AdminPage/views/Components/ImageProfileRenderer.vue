<template>
    <div>
        <img border="0" :src="imageUrl" class="img-thumbnail">
    </div>
</template>

<script>
import Vue from "vue";
export default Vue.extend({
    data() {
        return {
            imageUrl: '',
        }
    },
    methods:{

    },
    /**
     * Recibiendo el parámetro del componente.
      * Y la configuración de visualización inicial para el encabezado 
      * (use siguienteTick para esperar a que se actualice el DOM).
     */
    beforeMount(){
        if (this.params.data.imageUrl) {
            this.imageUrl = this.params.data.imageUrl
        }else{
            this.imageUrl = process.env.MIX_SENTRY_DSN_API+'images/default-profile.jpg';
        }
        var row  = this.params.node.rowIndex
        var colName = this.params.colDef.headerName
        
    }
})

</script>

<style>
    .img-thumbnail {
        border-radius: 16px;
        padding: .25rem;
        background-color: #fafafa;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        box-shadow: 0 1px 2px rgba(0,0,0,.075);
        max-width: 180px;
        max-height: 50px;
        widows: 180px;
    }
</style>
