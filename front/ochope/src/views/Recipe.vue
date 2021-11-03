<template>
  <article
    
  >
  

<div class="recipe">
        <img class="recipeImage" src="../assets/images/recipeCard.png">
        <h2 class="recipeTitle">Bière au thon-orge</h2>
        <div class="recipeAuthor">Proposé par Machin,</div>
        <div class="recipeType">Elle est de type ambré</div>
        <div class="recipeSubtitle">Ingrédients</div>
        <div class="recipeIngredient"> 1L d'eau, 50g de thon, 250g d'orge</div>
        <div class="recipeSubtitle">Préparation</div>
        <div class="recipeContent">Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        
</div>
  <div>

    <CommentSection/>

    

  </div>

  </article>
</template>

<script>
import CommentSection from '../components/CommentsSection.vue'

export default {
  name: 'Recipe',
  components: {
        CommentSection,
        
    },
  data(){
      return {
       
      };
  },
  
}
</script>

<style scoped lang="scss">


</style>
