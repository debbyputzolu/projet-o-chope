<template>

    <section class="pagination">
        <div class="recipeListDiv">
        <img class="recipeListImage" src="../assets/images/recipeList.png">
        <h1 class="recipeListTitle">Recettes de bière</h1>
        </div>
        <div>
        
           <!-- <Filters v-on:recipes-loaded="handleRecipesLoaded"/> -->

        </div>


            <ul
                v-for="recipe in recipes"
                :key="recipe.id"
            >
                <RecipeCard :recipeProps="recipe"/>
             </ul>

        <div class="card">
        <img class="cardImage" src="../assets/images/recipeCard.png">
        <h2 class="cardTitle">Bière au thon-orge</h2>
        <div class="cardContent">Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        <div>Découvrir</div>
       </div>

       <div class="card">
           <img class="cardImage" src="../assets/images/recipeCard.png">
        <h2 class="cardTitle">Bière à l'orge</h2>
        <div class="cardContent">Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        <div>Découvrir</div>
       </div>

       <div class="card">
        <img class="cardImage" src="../assets/images/recipeCard.png">
        <h2 class="cardTitle">Bière au citron</h2>
        <div class="cardContent">>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        <div>Découvrir</div>
       </div>

       <div class="card">
        <img class="cardImage" src="../assets/images/recipeCard.png">
        <h2 class="cardTitle">Bière à la fraise</h2>
        <div class="cardContent">>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        <div>Découvrir</div>
       </div>

        <div class="card">
        <img class="cardImage" src="../assets/images/recipeCard.png">
        <h2 class="cardTitle">Bière au épinard saumon</h2>
        <div class="cardContent">>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        <div>Découvrir</div>
       </div>
        
        <div class="card">
        <img class="cardImage" src="../assets/images/recipeCard.png">    
        <h2 class="cardTitle">Bière a Spaghetti cailloux</h2>
        <div class="cardContent">>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
        <div>Découvrir</div>
       </div>        
        
    </section>

</template>

<script>


import RecipeCard from '../components/RecipeCard.vue';
//import Filters from '../components/Filters.vue';

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
       // Filters,
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
