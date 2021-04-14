<template>
    <div>
        <button v-if="status === 1" class='btn btn-success btn-xs' 
        @click="btnClickedHandler(0)">Activado</button>
        <button v-else class='btn btn-danger btn-xs'
        @click="btnClickedHandler(1)">Desactivado</button>

    </div>
</template>

<script>
import Vue from "vue";
import crud from "../../../services/crud";

export default Vue.extend({
    data() {
        return {
            id:-1,
            status: 1,
            elementData:{
                id:-1,
                status:1
            },
            api:'',
        }
    },
    methods:{
        /**
         * btnClickedHandler: El estado de verificación se refleja en el valor de la celda en el momento del evento.
         * setDataValue: Estableciendo el valor con
         * CellRenderer: Se debe llamar a en la raiz del componente clicked.
         */
        btnClickedHandler(newStatus) {
            this.status = newStatus;
            //this.params.clicked(this.id, this.status);
            this.elementData.id= this.id;
            this.elementData.active = this.status;
            var paramsData = {
                elementData:this.elementData,
                api:this.api+'/updateActive'
            }
            var me = this;
            crud.updateActiveElement(paramsData)
                .then(response => {
                if (response.status == 200) {
                    this.notice('success', 'Se ha actualizado correctamente');
                    //me.$router.push({ name: this.list })
                }else{
                    if (response.data.errors.length > 0){
                        me.$refs.form.setErrors(response.data.errors);
                    }
                    //PENDIENTE: Validar que nos regrese el error
                    //PENDIENTE: Traduccir errores en diferentes idiomas
                    me.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Algo salió mal!',
                    footer: 'No se puedo iniciar sesion revice sus datos'
                    })
                }
                })
                .finally(() => {
                this.loading = false;
            });
        },

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
    /**
     * Recibiendo el parámetro del componente.
      * Y la configuración de visualización inicial para el encabezado 
      * (use siguienteTick para esperar a que se actualice el DOM).
     */
    beforeMount(){
        if (this.params.data.ACTIVE) {
            this.status = parseInt(this.params.data.ACTIVE)
            this.id = parseInt(this.params.data.ID)
            this.api = this.params.api;
        }
        var row  = this.params.node.rowIndex
        var colName = this.params.colDef.headerName
        
    }
})

</script>
