<template>
    <div class="commentSection">
        <section>
            <h2 class="commentSectionTitle">Commentaires</h2>
            <CommentForm v-if="user" :recipe="recipe"/>
        </section>

        <section v-if="recipe">
            <ul
                v-for="comment in comments"
                :key="comment.id">
   
            <CommentCard :comment="comment"/>
            </ul> 
        </section>
       

    </div>

</template>


<script>
import CommentForm from './CommentForm.vue';
import CommentCard from './CommentCard.vue';
import recipeService from '../services/recipeService.js';

export default({
    name: 'CommentsSection',
    components: {
        CommentForm,
        CommentCard
    },
    data() {

        return {
            comments: [],
            recipeId: null
        }
    },

async created() {
        this.recipeId = this.$route.params.id;
        //console.log(this.recipeId);
        this.comments = await recipeService.getCommentByRecipe(this.recipeId);
        
    },
    computed: {
        user() {
            return this.$store.state.user;
        }
    },
    props: {
        recipe: Object
    },
});
</script>

<style></style>