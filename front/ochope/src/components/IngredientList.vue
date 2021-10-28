<template>

    <select v-if="recipeIngredients.length">
        <option
            v-for="ingredient in recipeIngredients"
            :key="ingredient.id"
            :value="ingredient.id"
        >
            {{ingredient.name}}
        </option>
    </select>

</template>


<script>
import recipeService from '../services/recipeService.js';
export default({
  watch: {
  },
    async created() {
        this.recipeIngredients = await recipeService.loadRecipesIngredients();
    },
    name: 'IngredientList',
    data() {
        return {
            recipeIngredients: []
        };
    }
})
</script>