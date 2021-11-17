<template>
<carousel class="carousselHome" :perPage="1" :autoplay='true' :loop="true" :autoplayTimeout="2500" >
  <slide
    v-for="recipe in recipes.slice(0,3)"
                :key="recipe.id"
            >
    <RecipeCarousel :recipe="recipe"/> 
  </slide>
 
</carousel>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';
import RecipeCarousel from './RecipeCarousel.vue';
import recipeService from '../services/recipeService.js';

export default{
    name: 'CarouselHome',

    async created() {
        this.recipes = await recipeService.loadRecipes();
        
    },

    components: {
    Carousel,
    Slide,
    RecipeCarousel
    },
   
    data() {

        return {
            recipes: []
        }
    },
   
};


</script>

<style scoped lang="scss">



</style>