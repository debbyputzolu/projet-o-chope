<template>
    <div>
        <section>
            <h2>Commentaires</h2>
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