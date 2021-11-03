<template>
    <div>
        <section>
            <h2>Commentaires</h2>
            <CommentForm v-if="user" :recipe="recipe"/>
        </section>



        <section v-if="recipe._embedded.replies">
            <CommentCard
                v-for="comment in recipe._embedded.replies[0]"
                :key="comment.id"
                :comment="comment"
            />
        </section>
    </div>

</template>


<script>
import CommentForm from './CommentForm.vue';
import CommentCard from './CommentCard.vue';
export default({
    name: 'CommentsSection',
    components: {
        CommentForm,
        CommentCard
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