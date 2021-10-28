<template>
   <article class="card">
       <img :src="getImageURL"  alt="">
        
       <h2 > {{recipeProps.title.rendered}} </h2>
       
       <div 
         class="card__content" 
         v-html="recipeProps.excerpt.rendered"
       >
       </div>

       <div>
          <router-link
            :to="{
              name: 'recipe',
              params: {
                id: recipeProps.id
              }
            }"
          >
           Lire la suite
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
                return 'https://picsum.photos/seed/picsum/400/300';
            }
      
    }
  }
}
</script>

<style scoped lang="scss">




</style>