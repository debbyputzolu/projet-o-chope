<template>
    <select
        v-if="terms.length"
        v-model="selectedOption"

        @change="selectTerm"
    >
        <option value="0"> {{label}} </option>
        <option
            v-for="term in terms"
            :key="term.id"
            :value="term.id"
        >
            {{term.name}}
        </option>
    </select>

</template>


<script>

export default({

    async created() {


        if(this.$store.state.termsList[this.taxonomy]) {
            this.terms = this.$store.state.termsList[this.taxonomy];
        }
        else {
            this.terms = await this.$store.state.services.recipe.loadTerms(this.taxonomy);
            this.$store.commit(
                'saveTermsList',
                {
                    taxonomy: this.taxonomy,
                    terms: this.terms
                }
            );
        }
    },

    name: 'TermList',

    data() {
        return {
            terms: [],
            selectedOption: 0
        };
    },

    props: {
        taxonomy: String,
        label: String
    },

    methods: {
        selectTerm(event) {
            event.preventDefault();
            this.$emit(
                'recipe-term-selected',
                {
                    termId: this.selectedOption,
                    taxonomy: this.taxonomy
                }
            );
        }
    }
})

</script>