<template>

<div class="recipeComment">
    <div v-html="comment.content.rendered"></div>
</div>

</template>


<script>
export default({
    name: 'CommentCard',
    props: {
        comment: Object
    }
});
</script>

<style>
</style>