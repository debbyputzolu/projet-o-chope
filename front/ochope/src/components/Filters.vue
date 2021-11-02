<template>

    <div>
        <TermList
            taxonomy="recipe-type"
            label="Choisir par type"
            v-on:recipe-term-selected="handleTermSelection"
        />

        <TermList
            taxonomy="ingredient"
            label="Choisir par ingredient"
            v-on:recipe-term-selected="handleTermSelection"
        />
    </div>
</template>

<script>
import TermList from '../components/TermList.vue'
import recipeService from '../services/recipeService.js';

export default({
    name: "Filters",
    components: {
        TermList
    },
    data() {
        return {
            filters: {}
        }
    },
    methods: {
        async handleTermSelection(data) {
            if(parseInt(data.termId)) {
                this.$emit(
                    'recipe-type-term',
                    data
                );
               this.filters[data.taxonomy] = data.termId;
            }
            else {
                this.filters[data.taxonomy] = false;
            }
            const recipes = await recipeService.getRecipesByTerms(
                this.filters
            );
            this.$emit('recipes-loaded', recipes);
            
        }
    }
})
</script>

<style scoped>

</style>