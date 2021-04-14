<template>
    <b-form-group
        class="row"
        label-cols-sm="2"
        label="Imagen Banner web:"
        label-for="imageBannerWeb"
        style="margin-top: 1rem;">

        <div v-if="!image">
            <h2>Seleccionar una imagen</h2>
            <input id="imageBannerWeb" :name="name" type="file" @change="onFileChange">
        </div>

        <div v-else>
            <img :src="image" />
            <button @click="removeImage">Remover imagen</button>
        </div>
    
    </b-form-group>
</template>


<script type="text/javascript">
	export default {
		
		props:{
			id:{default:""},
			labelText:{default:""},
			data:{default:1},
            name:{default:""},
            file:{default:null}
		},
		data(){
			return {
                image: ''
			}
		},
		watch:{ },
        computed:{ },
        methods: {
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                this.$emit('update:data', files);
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                this.file = file;
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file); 
                
            },
            removeImage: function (e) {
                this.image = '';
            }
        },

		mounted(){
			
		}
	}
</script>

<style scoped>
    img {
        width: 40%;
        margin: auto;
        display: block;
        margin-bottom: 10px;
    }
</style>