<template>
    <b-form-group
		class="row"
		label-cols-sm="2"
		:label="labelText"
		:label-for="id"
		style="margin-top: 1rem;">
    	
		<b-form-select 
			:id="id" 
			v-model="selected" 
			:name="name"
			@input="changeMethod"
            :disabled="disabled"
			:options="listOptions">
		</b-form-select>
    
	</b-form-group>
</template>

<script type="text/javascript">
	export default {
		
		props:{
			id:{default:""},
			labelText:{default:""},
			listOptions:{default:[]},
			data:{default:1},
			name:{default:""},
			disabled:{default:false},
		},
		data(){
			return {
				selected:-1,
			}
		},
		watch:{ 
			
		},
		computed:{ },
		methods: {
            changeMethod(){
                this.$emit('update:data',this.selected);
            }
    	},
		mounted(){
			
		}
	}
</script>