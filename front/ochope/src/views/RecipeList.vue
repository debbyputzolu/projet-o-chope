<template>

    <section class="pagination">
        <div class="recipeListDiv">
        <img class="recipeListImage" src="../assets/images/recipeList.png">
        <h1 class="recipeListTitle">Recettes de bière</h1>
        </div>
        <div>
        
           <Filters v-on:recipes-loaded="handleRecipesLoaded"/> 

        </div>

            <ul
                v-for="recipe in recipes"
                :key="recipe.id"
            >
                <RecipeCard :recipeProps="recipe"/>
            </ul> 
        
    </section>

</template>

<script>


import RecipeCard from '../components/RecipeCard.vue';
import Filters from '../components/Filters.vue';

import recipeService from '../services/recipeService.js';

export default({
    name: 'RecipeList',

    async created() {
        this.recipes = await recipeService.loadRecipes();
    },

    data() {

        return {
            recipes: []
        }
    },

    components: {
        RecipeCard,
        Filters,
    },

    methods: {
        handleRecipesLoaded(recipes) {
            this.recipes = recipes;
        }
    }

})
</script>

<style>

</style>
