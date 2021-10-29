<template>

    <section class="pagination">
        <h1 class="recipeListTitle">Recettes</h1>

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

        <div>
        <h2>Bière au thon-orge</h2>
        <div>40 gr de thon, 30 gr de Houblon, 22 gr de levure, 1kg de malt de blé, 2 l d'eau</div>
        <div>proposé par Truc, bière de type Ambré</div>
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
       </div>

       <div>
        <h2>Bière à l'orge</h2>
        <div>60 gr d'orge, 30 gr de Houblon, 22 gr de levure, 1kg de malt de blé, 2 l d'eau</div>
        <div>proposé par Machin, bière de type IPA</div>
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
       </div>

       <div>
        <h2>Bière au citron</h2>
        <div>100 gr de citron, 30 gr de Houblon, 22 gr de levure, 1kg de malt de blé, 2 l d'eau</div>
        <div>proposé par Heineken, bière de type Blonde</div>
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
       </div>

       <div>
        <h2>Bière à la fraise</h2>
        <div>100 gr de fraise, 40 gr de Houblon, 22 gr de levure, 1kg de malt de blé, 2 l d'eau</div>
        <div>proposé par Chouette, bière de type blonde</div>
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
       </div>

        <div>
        <h2>Bière au épinard saumon</h2>
        <div>50 gr d'épinard, 50 gr de saumon, 40 gr de Houblon, 22 gr de levure, 1kg de malt de blé, 2 l d'eau</div>
        <div>proposé par Mahaloude, bière de type ambré</div>
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
       </div>
        
        <div>
        <h2>Bière a Spaghetti cailloux</h2>
        <div>65 gr de spaghetti, 15 gr de cailloux, 40 gr de Houblon, 22 gr de levure, 1kg de malt de blé, 2 l d'eau</div>
        <div>proposé par Pierre, bière de type rousse</div>
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Sunt quam voluptate obcaecati sint voluptatem! Mollitia quibusdam atque possimus enim modi qui harum,<br> repellendus voluptates porro maxime rerum est dolor illo?</div>
       </div>        
        
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
