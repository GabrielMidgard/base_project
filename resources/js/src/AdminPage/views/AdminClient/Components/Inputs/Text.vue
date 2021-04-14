<template>
	<div class="form-group">
		<label for="field-1" class="col-sm-3 control-label">{{text}}<span v-show="required">*</span>:</label>
		
		<div class="col-sm-7">
			<textarea class="form-control" :id="vname" v-model="vdata" :required="required" :placeholder="place" :rows="rows"></textarea>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				vname:"",
				vdata:"",
			}
		},
		props:{
			name:{default:""},
			text:{required:true},
			data:{default:""},
			required:{default:false},
			place:{default:""},
			rows:{default: "7"}
		},
		watch:{
			vdata:{
				handler:function(val){
					this.$emit('update:data',val);				
				},
				immediate:true,
			},
			data:{
				handler:function(val){
					this.vdata=val;
				},
				immediate:true,	
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