<template>
	<div :class="{'form-group':true,'has-error':errors.has(name) && fields[name].touched}">
		<label for="field-1" class="col-sm-3 control-label">{{text}}<span v-show="required">*</span>:</label>
		
		<div class="col-sm-7">
			<v-select v-model="selected" :options="vOptions" :multiple='multiple' :disabled="disabled" :placeholder="place"></v-select>
			<small class="has-error" v-show="errors.has(name) && fields[name].touched">{{ errors.first(name) }}</small>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				selected:[],
				vname:"",
			}
		},
		props:{
			name:{default:""},
			text:{required:true},
			options:{required:true},
			data:{default:[]},
			place:{default:""},
			disabled:{default:false},
			required:{default:false},
			multiple:{default:false},
		},
		watch:{
			selected:{
				handler:function(val){
					this.$emit('update:data',val);				
				},
				immediate:true,
			},
			data:{
				handler:function(val){
					this.selected=val;
				},
				immediate:true,	
			},
			
		},
		computed:{
			vOptions:function(){
				if(Array.isArray(this.options)){
					return this.options;
				}
				else{
					return [];
				}
			},
		},
		mounted(){
			if(this.name==""){
				this.vname=this.text.toLowerCase();
			}
			else{
				this.vname=this.name;
			}
		}
	}
</script>