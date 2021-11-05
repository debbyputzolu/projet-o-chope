<template>
  <div class="profile">
      <div class="headProfile">
          <img src="../assets/images/machin.png" class="profileImage">
          <h2 class="profileTitle">Machindu75</h2>
          <button class="buttonProfile"><router-link :to="{
                    name: 'recipe-create',
                }"
            >Ajouter une recette</router-link></button> <br>
          <button class="buttonProfile">Déconnexion</button>
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
        <div class="card">
        <img class="cardImage" src="../assets/images/recipeCard.png">
        <h2 class="cardTitle">Bière au thon-orge</h2>
        <div class="cardContent">Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        <div>Découvrir</div>
       </div>
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
