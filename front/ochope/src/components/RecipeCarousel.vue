<template>
   <div class="recipe">
        <img class="recipeImage" :src="getImageURL">
        <h2 class="recipeTitle">{{recipe.title.rendered}}</h2>
        <div class="recipeAuthor">Proposé par {{recipe._embedded['author'][0].name}} </div>
        <div class="recipeType">Elle est de {{recipe._embedded['wp:term'][1][0].name}} </div>
        <div class="recipeSubtitle">Ingrédients</div>
        <div class="recipeIngredient">{{recipe._embedded['wp:term'][0][0].name}}, {{recipe._embedded['wp:term'][0][1].name}}, {{recipe._embedded['wp:term'][0][2].name}}, {{recipe._embedded['wp:term'][0][3].name}}, {{recipe._embedded['wp:term'][0][4].name}}</div>
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
  methods: {
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