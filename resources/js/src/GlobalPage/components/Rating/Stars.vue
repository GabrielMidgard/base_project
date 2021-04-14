<template>
    <div class="star-rating" style="display: inline-block; vertical-align: bottom;">
        <div class="rating mr-2" >
            <i class="fas fa-star amber-text fa-sm mr-2" v-for="item in stars" :key="item"></i>
        </div>
    </div>
</template>

<script>
    export default {
        name: "starRating", 
        data() {
            return {    
                
            }
        },
        props: { 
            stars: {
                type: Number,
                required: true,
                default: 5
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

</style>