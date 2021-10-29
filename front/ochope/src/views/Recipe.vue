<template>
  <article
    class="card"
    v-if="recipe"
  >
  <div class="image-container">
    <img :src="getImageURL">
  </div>
<h2>hellooooooo</h2>
  <h2>{{recipe.title.rendered}}</h2>
  <div class="card__content"
   v-html="recipe.content.rendered"
  >
  </div>

  <div>
    <router-link
      :to="{
        name: 'home'
      }
      "
    >
      Retourner vers la page d'accueil
    </router-link>

  </div>

  </article>
</template>

<script>
import recipeService from '../services/recipeService.js';
export default {
  name: 'Recipe',
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
    console.log('Je suis dans le composant Recipe et ma data recipeId contient :' + this.recipeId);    

    this.recipe = await recipeService.getRecipeById(this.recipeId);
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
                return 'https://picsum.photos/seed/picsum/400/300';
            }
      
    }
}
}
</script>

<style scoped lang="scss">


</style>
