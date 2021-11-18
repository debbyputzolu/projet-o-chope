<template>
   <article class="card">
       <img class="cardImage" :src="getImageURL"  alt="">
        
       <h2 class="cardTitle"> {{recipeProps.title.rendered}} </h2>
       
       <div 
         class="cardContent" 
         v-html="recipeProps.excerpt.rendered"
       >
       </div>

       <div>
          <router-link class="linkDiscovery"
            :to="{
              name: 'recipe',
              params: {
                id: recipeProps.id
              }
            }"
          >
           Découvrir
          </router-link>
       </div>
   </article>
</template>

<script>

export default {
  name: 'RecipeCard',
  data(){
    return {
    };
  },
  props: {
    recipeProps: Object,
  },
  methods: {
  },
  computed: {
    getImageURL() {
            if(this.recipeProps._embedded['wp:featuredmedia']) {
                if(this.recipeProps._embedded['wp:featuredmedia'][0].media_details.sizes.large) {
                    return this.recipeProps._embedded['wp:featuredmedia'][0].media_details.sizes.large.source_url;
                }
                else if(this.recipeProps._embedded['wp:featuredmedia'][0].media_details.sizes.full) {
                    return this.recipeProps._embedded['wp:featuredmedia'][0].media_details.sizes.full.source_url;
                }
                else {
                    return this.recipeProps._embedded['wp:featuredmedia'][0].media_details.source_url;
                }

            }
            else {
                return 'http://localhost/valkyrie/apotheose/ochope/front/ochope/src/assets/images/recipeCard.png';
            }
      
    }
  }
}
</script>

<style scoped lang="scss">




</style>