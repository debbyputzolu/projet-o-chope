<template>

    <article class="card">

        <div class="image-container">
            <img :src="getImageURL"/>
        </div>
        <h2>{{recipe.title.rendered}}</h2>

        <div class="card__content" v-html="recipe.excerpt.rendered">

        </div>

        <div>
            <router-link
                :to="{
                    name: 'recipe',
                    params: {
                        id: recipe.id
                    }
                }"
            >
          
            </router-link>
        </div>

    </article>

</template>

<script>

export default({
    name: 'RecipeCard',

    props: {

        recipe: Object,
    },


    computed: {
        getImageURL() {

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

});
</script>


<style scoped lang="scss">

</style>
