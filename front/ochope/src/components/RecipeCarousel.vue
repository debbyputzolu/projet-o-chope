<template>
   <div class="recipe">
        <img class="recipeImage" :src="getImageURL">
        <h2 class="recipeTitle">{{recipe.title.rendered}}</h2>
        <div class="recipeAuthor">Proposé par {{recipe._embedded['author'][0].name}} </div>
        <div class="recipeType">Elle est de type {{recipe._embedded['wp:term'][1][0].name}} </div>
        <div class="recipeSubtitle">Ingrédients</div>
        <div class="recipeIngredient">
        
          <span v-for="(ingredient, index) in recipe._embedded['wp:term'][0]" :key="ingredient.id">
            
            <span v-if="index !== 0">, </span>{{ingredient.name}}
          </span></div>
        <div class="recipeSubtitle">Préparation</div>
        <div class="recipeContent" v-html="recipe.content.rendered"></div>
        
</div>
</template>

<script>

export default {
  name: 'RecipeCarousel',
  data(){
    return {
    };
  },
  props: {
    
    recipe: Object,
  },

  computed: {
    getImageURL() {
            
                return 'http://localhost/valkyrie/apotheose/ochope/front/ochope/src/assets/images/recipeCard.png';
            }
      
    }
  }

</script>

<style scoped lang="scss">




</style>