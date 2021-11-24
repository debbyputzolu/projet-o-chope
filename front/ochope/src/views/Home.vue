<template>
    <div class="home">
   
        <CarouselHome/>
              
       <router-link
            :to="{
                name: 'register',
            }"
        >
        <img src="../assets/images/registerhome.png" class="registerHomeImage">
       
        <img src="../assets/images/forumhome.png" class="forumHomeImage">
       </router-link>

    </div>
</template>

<script>
import CarouselHome from '../components/CarouselHome.vue';
export default{
    name: 'Home',
    components: {
    CarouselHome,

  },

}
</script>

<style>

</style>
