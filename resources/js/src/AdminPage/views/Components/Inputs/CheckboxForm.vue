<template>
    <b-form-group
        class="row"
        label-cols-sm="2"
        :label="labelText"
        :label-for="id"
        style="margin-top: 1rem;">
             
        <b-form-checkbox
            :id="id"
            :name="name"
            v-model="state"
            :value="true"
            @input="changeMethod"
            :disabled="disabled"
            inline
            switch>
            {{text}}
        </b-form-checkbox>

    </b-form-group>
</template>
    
<script>
    export default {
        props:{
            id:{default:"", required:true},
            labelText:{default:""},
            data:{default:""},
            disabled:{default:false},
            name:{default:""},
            text:{default:""},
        },
        data(){
			return {
				state:false,
			}
		},
        watch:{
		},
		computed:{
			
        },
        
		mounted(){
        },
        methods: {
             changeMethod(){
                this.$emit('update:data',this.state);
            }
        }
    }
</script>
    
<style>

</style>
