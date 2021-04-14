<template>
    <form  class="col-lg-6 product-quantity sm-margin-bottom-20" name="f1">

        <button id="minus" type="button" class="quantity-button" name="subtract" 
        onclick="this.parentNode.querySelector('input[type=number]').stepDown()" value="-"
        style="border-radius: 20px 0px 0px 20px;">-</button>
        
        <input id="qty" type="number" class="quantity-field" name="qty"  
        :value="value" :min="min" :max="max" >
        
        <button id="plus" type="button" class="quantity-button" name="add" 
        onclick="this.parentNode.querySelector('input[type=number]').stepUp()" value="+"
        style="border-radius: 0px 20px 20px 0px;">+</button>

    </form>
</template>

<script>
    export default {
        name: "InputQuantity", 
        data() {
            return {    
                
            }
        },
        props: { 
            min: {
                type: Number,
                required: true,
                default: 1
            },
            max: {
                type: Number,
                required: true,
                default: 10000
            },
            value: {
                type: Number,
                required: true,
                default: 10000
            },
        },
        
        components: {
           
        },
        watch: {  },
        methods: {
  
        },
         
        beforeMount() {  },
        
        mounted() { }
    };
</script>


<style scoped>
    .quantity-field {
        width: 80px;
        height: 50px;
        outline: none;
        margin: 0 -4px;
        font-size: 20px;
        text-align: center;
        border: 1px solid #eee;
    }
    .quantity-button {
        color: #fff;
        width: 55px;
        height: 54px;
        padding: 5px;
        border: none;
        outline: none;
        cursor: pointer;
        font-size: 20px;
        background: #000000;
        text-align: center;
        font-weight: normal;
        white-space: nowrap;
        display: inline-block;
        background-image: none;
    }

    /* Eliminar botones nativos del input number*/
    input[type="number"] {
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; }
    .number-input {
        border: 2px solid #ddd;
        display: inline-flex;
    }
    .number-input,
    .number-input * {  box-sizing: border-box;}
    .number-input button {
        outline:none;
        -webkit-appearance: none;
        background-color: transparent;
        border: none;
        align-items: center;
        justify-content: center;
        width: 3rem;
        height: 3rem;
        cursor: pointer;
        margin: 0;
        position: relative;
    } 
    .dropdown .dropdown-menu .dropdown-item, .dropleft .dropdown-menu .dropdown-item, .dropright .dropdown-menu .dropdown-item, .dropup .dropdown-menu .dropdown-item {
        padding: .5rem !important;
    }
</style>