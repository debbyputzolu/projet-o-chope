<template>
  <div class="profile">
      <div class="headProfile">
          <img src="../assets/images/machin.png" class="profileImage">
          <h2 class="profileTitle">Machindu75</h2>
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
          <div class="infoProfileItem">Mon pseudo : Machindu75</div>
          <div class="infoProfileItem">Mon email : machin@truc.fr</div>
          <button class="buttonProfile">Modifier le profil</button>
      </div>
      <div class="recipeProfile">
          <h3 class="subtitleProfile">Mes recettes</h3>
            <RecipeCard/>
      </div>
   
  </div>
</template>

<script>
import RecipeCard from '../components/RecipeCard.vue'

export default {
  name: 'Profile',
  components: {
   RecipeCard,
  }
}


</script>

<style lang="scss">

</style>
