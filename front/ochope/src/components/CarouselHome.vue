<template>
<carousel class="carousselHome" :perPage="1" :autoplay='true' :loop="true" :autoplayTimeout="2000">
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
import { Carousel, Slide } from 'vue-carousel';
import Recipe from './Recipe.vue';

export default{
    name: 'CarouselHome',
    components: {
    Carousel,
    Slide,
    Recipe
  },
       
   
};


</script>

<style scoped lang="scss">



</style>