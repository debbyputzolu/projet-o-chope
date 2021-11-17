<template>
  <article
    v-if="recipe" 
  >
  

<div class="recipe">
        <img class="recipeImage" :src="getImageURL">
        <h2 class="recipeTitle">{{recipe.title.rendered}}</h2>
        <div class="recipeAuthor">Proposé par {{recipe._embedded['author'][0].name}} </div>
        <div class="recipeType">Elle est de {{recipe._embedded['wp:term'][1][0].name}} </div>
        <div class="recipeSubtitle">Ingrédients</div>
        <div class="recipeIngredient">
        
          <span v-for="(dose, index) in recipe.dose" :key="dose.id">
            
            <span v-if="index !== 0">, </span>{{dose.formatted_ingredient}}  {{dose.quantity}} {{dose.formatted_unit}}
          </span>
        </div>
        <div class="recipeSubtitle">Préparation</div>
        <div class="recipeContent" v-html="recipe.content.rendered"></div>
        
</div>
  <div>

    <CommentSection :recipe="this.recipe"/>

    

  </div>

  </article>
</template>

<script>
import CommentSection from '../components/CommentsSection.vue'
import recipeService from '../services/recipeService.js';

export default {
  name: 'Recipe',
  components: {
        CommentSection,
        
    },
  data(){
      return {
       recipeId: null,
       recipe: null
      };
  },
  async created(){
    //! IMPORTANT depuis la mise en place de notre router
    // les composant on acces a une "armoire" this.$router, cette dernière contient un tiroir "params" dans lequel je vais trouver la partie dynamique de mon URL
    
    
    this.recipeId = this.$route.params.id;
    //console.log('Je suis dans le composant Recipe et ma data recipeId contient :' + this.recipeId);  

    this.recipe = await recipeService.getRecipeById(this.recipeId);
    console.log(this.recipe);
  },
  computed: {
    getImageURL() {
            // Vérification : la recette a-t-elle une image
            if(this.recipe._embedded['wp:featuredmedia']) {
                if(this.recipe._embedded['wp:featuredmedia'][0].media_details.sizes.large) {
                    return this.recipe._embedded['wp:featuredmedia'][0].media_details.sizes.large.source_url;
                }
                else if(this.recipe._embedded['wp:featuredmedia'][0].media_details.sizes.full) {
                    return this.recipe._embedded['wp:featuredmedia'][0].media_details.sizes.full.source_url;
                }
                else {
                    return this.recipe._embedded['wp:featuredmedia'][0].media_details.source_url;
                }
            }
            else {
                return 'http://localhost/valkyrie/apotheose/ochope/front/ochope/src/assets/images/recipeCard.png';
                //trouver solution pour mettre image biere
            }
      
   }
  }
}
</script>

<style scoped lang="scss">


</style>
