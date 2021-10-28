<template>

    <section>
        <h1>Recettes</h1>

        <div>
        
            <Filters v-on:recipes-loaded="handleRecipesLoaded"/>

        </div>


        <ul>
            <li
                v-for="recipe in recipes"
                :key="recipe.id"
            >
                <RecipeCard :recipe="recipe"/>
            </li>

        </ul>
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum, repellendus voluptates porro maxime rerum est dolor illo?</div>
       
        
        
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
