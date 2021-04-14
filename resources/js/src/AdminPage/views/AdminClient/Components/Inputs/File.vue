<template>
  <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label">{{text}}:</label>
    
    <div class="col-sm-7">
      <div class="upload-btn-wrapper">
        <button>Seleccionar archivo</button>
        <input type="file" :name="name" id="v_file" />
        {{ file() }}
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
  export default {
    props:{
      name:{required:true},
      text:{required:true},
      data:{default:"Ninguno.."},     
    },
    data(){
      return {
        status:"",
      }
    },
    methods:{
      file:function(){
        if(!jQuery('#v_file')[0] || jQuery('#v_file')[0].files.length==0){
          return this.data;
        }
        else{
          return jQuery('#v_file')[0].files[0].name;
        }
      }
    },
    mounted(){
      // this.status=this.data;
    }
  }
</script>

<style>
  .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

button {
  border: 2px solid #f30;
  color: black;
  background-color: withe;
  padding: 8px 20px;
  border-radius: 0px;
  font-size: 15px;
  font-weight: bold;
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
</style>