<template>
	<div class="row vueMsg" tabindex="-1">
		<div class="col-sm-offset-2 col-sm-8">
			<div :class="real_class" role="alert" id="alertMsg" v-show="show">
			  <strong>{{type}}!</strong> <span v-html="msg"></span>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default {
		data(){
			return {
				type:"Aviso",
				show:false,
			}
		},
		props:['msg','vclass'],
		watch:{
			msg:{
				handler:function(){
					if(this.show==false){
						this.show=true;
						jQuery('.vueMsg').focus();

						setTimeout(()=>{
							alertify.notify(this.msg,this.vclass,5);
						},1000);
						
						setTimeout(()=>{							
							this.show=false;
						},5000);
					}
				},
				immediate: true,
			},
			vclass:function(){
				switch(this.class){
					case "success":
						this.type="Bien";
						break;
					case "danger":
						this.type="Error";
						break;
					case "warning":
						this.type="Atencion";
						break;
					default:
						this.type="Aviso";
						break;
				}
			}
		},
		computed:{
			real_class:function(){
				return "alert alert-"+this.vclass;
			}
		},
		methods:{

		},
		mounted(){
			
		}
	}
</script>