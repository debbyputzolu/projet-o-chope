<template>
  <article
    
  >
  

<div class="card">
        <img class="cardImage" src="../assets/images/recipeCard.png">
        <h2 class="cardTitle">Bière au thon-orge</h2>
        <div class="cardContent">Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        <div>Découvrir</div>
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
