<template>
    <div class="home">
        
        <div class="card carousselHome">
        <Carousel/>
       </div>
       
        
       <router-link
            :to="{
                name: 'register',
            }"
        ><img src="../assets/images/registerhome.png" class="registerHomeImage"></router-link>
       
        <img src="../assets/images/forumhome.png" class="forumHomeImage">
       

    </div>
</template>

<script>
import Carousel from '../components/Carousel.vue';
export default{
    name: 'Home',
    components: {
    Carousel,

  },

}
</script>

<style>

</style>
