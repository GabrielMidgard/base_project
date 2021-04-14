<template>
    <b-form-group
        class="row"
        label-cols-sm="2"
        :label="labelText"
        :label-for="id"
        style="margin-top: 1rem;">

        <b-form-input :id="id" 
            :name="name"
            :type="type"
            :placeholder="placeholder"
            v-model="dataInfo"
            @input="$emit('update:data', $event)"
            :disabled="disabled">
            <!--
                v-validate="{ required: true, min: 3 }" -->
        </b-form-input>
    </b-form-group>
</template>
    
<script>
    export default {
        props:{
            id:{default:"", required:true},
            placeholder:{default:""},
            data:{default:""},
            disabled:{default:false},
            labelText:{default:""},
            name:{default:""},
            type:{default:"text"},
        },
        data() {
            return {
                dataInfo:''
            }
        },
		computed:{
			
        },
        created() {
            this.dataInfo=this.data;
        },
		mounted(){
            
            /*
			if(this.name==""){
				this.name=this.name.toLowerCase();
            }
            */
		}
    }
</script>
    
<style>

</style>
