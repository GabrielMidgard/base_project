<template>
	<div class="form-group">
		<label for="field-1" class="col-sm-3 control-label">{{text}}:</label>
		<div class="col-sm-7">
			<vSwitch :name="name" :value="value" v-model="state"></vSwitch>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				state:false,
				input_name:"",
				input_value:"",
			}
		},
		props:{
			name:{default:""},
			text:{required:true},
			data:{default:""},
			value:{default:true},
		},
		watch:{
			state:{
				handler:function(val){
					this.$emit('update:data',val);
				},
				immediate:true,
			},
			data:{
				handler:function(val){
					this.state=val;
				},
				immediate:true,	
			},
		},
		mounted(){
			if(this.name==""){
				this.input_name=this.text.toLowerCase();
			}
			else{
				this.input_name=this.name;
			}
			this.input_value=this.value;
		}
	}
</script>