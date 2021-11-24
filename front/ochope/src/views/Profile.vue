<template v-if="user">
  <div class="profile" v-if="isUserConnected" >
      <div class="headProfile">
          <img src="../assets/images/profiledefault.png" class="profileImage">
          <h2 class="profileTitle">{{user.user_display_name}}{{user.user_id}}</h2>
          <button class="buttonProfile"><router-link :to="{
                    name: 'recipe-create',
                }"
            >Ajouter une recette</router-link></button> <br>
          <button class="buttonProfile"><router-link :to="{
                    name: 'logout',
                }"
            >Déconnexion</router-link></button>
      </div>
      <div class="infoProfile">
          <h3 class="subtitleProfile">Informations</h3>
          <div class="infoProfileItem">Mon pseudo : {{user.user_display_name}} </div>
          <div class="infoProfileItem">Mon email : {{user.user_email}} </div>
          <button class="buttonProfile">Modifier le profil</button>
      </div>
      <div class="recipeProfile">
          <h3 class="subtitleProfile">Mes recettes</h3>
          <div v-for="recipe in recipes" :key ="recipe.id">
            <RecipeCard :recipeProps="recipe"/>
            </div>
      </div>
   
  </div>
</template>

<script>
import RecipeCard from '../components/RecipeCard.vue'
import userService from  "../services/userService.js";
import recipeService from '../services/recipeService.js';

export default {
  name: 'Profile',

  components: {
   RecipeCard,
  },
 
  data() {
        return {
            isUserConnected: false,
            recipes: [],
            authorId: null,
           infoUser: [],
           name: null
        };
  },

  async created() {
        // STEP AUTHENFICATION is the user logged in
        const isTokenValid = await userService.isConnected();
        if(!isTokenValid) {
            // the token is invalid, we redirect the user to the login page
            // IMPORTANT VUEJS router : make a redirect
            this.$router.push('register');
        }
        else {
            this.isUserConnected = true;
        }

       this.authorId = this.$route.params.id;
        
       this.name = this.$store.state.user.user_display_name;
       this.recipes = await recipeService.getRecipeByAuthor(this.name);
  },

computed: {
    user(){
      return this.$store.state.user;
    }
  }
}

</script>

<style lang="scss">

</style>
