<template>
<carousel>
  <slide>
    <Recipe/>
  </slide>
  <slide>
    <Recipe/>
  </slide>
  <slide>
    <Recipe/>
  </slide>
</carousel>

</template>

<script>
//import { Carousel, Slide } from 'vue-carousel';
import Recipe from './Recipe.vue';

export default{
    name: 'Carousel',
    components: {
    //Carousel,
    //Slide,
    Recipe
  },
       
   
};


</script>

<style scoped lang="scss">



</style>