<template>

<div class="recipeComment">
    <div class="commentAuthor">{{comment.comment_author}}, nous dit à propos de cette recette:</div>
    <div class="commentContent" v-html="comment.comment_content"></div>
</div>

</template>


<script>
export default({
    name: 'CommentCard',
    props: {
        comment: Object
    },
});
</script>

<style>
</style>