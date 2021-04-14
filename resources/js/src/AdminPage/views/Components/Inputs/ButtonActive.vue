<template>
    <b-form-group
        v-if="id != -1"
        class="row"
        label-cols-sm="2"
        label="Activo:"
        label-for="active">

            <button id="active" v-if="data === 1" 
            class='btn btn-success btn-xs' 
            @click="eventActive(0)">Activado</button>
        
            <button id="active"  v-else class='btn btn-danger btn-xs'
            @click="eventActive(1)">Desactivado</button>
    </b-form-group>
</template>


<script type="text/javascript">
	export default {
		
		props:{
            id:{default:-1},
			data:{default:1},
			disabled:{default:false},
		},
		data(){
			return {
			}
		},
		watch:{ },
        computed:{ },
        methods:{
            eventActive:function(status){
                this.data = status;
                this.$emit('update:data',this.status);
            },  
        },
		mounted(){
			
        },
	}
</script>