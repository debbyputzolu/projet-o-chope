<template>
    <div class="commentSection">
        <section>
            <h2 class="commentSectionTitle">Commentaires</h2>
            <CommentForm/>
        </section>



        
    </div>

</template>


<script>
import CommentForm from './CommentForm.vue';

export default({
    name: 'CommentsSection',
    components: {
        CommentForm,
        
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