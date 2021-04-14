<template>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-7">
			<div class="checkbox">
				<label>
					<input type="checkbox" v-model="state" :value="value" :true-value="value"> <b>{{text}}</b>
				</label>
			</div>			
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				state:false,
				input_name:"",
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
		}
	}
</script>