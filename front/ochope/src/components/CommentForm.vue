<template>

    <section>
        <div class="commentForm">
        <h3 class="commentFormTitle">Poster un commentaire</h3>
        <form @submit="saveComment">
            <textarea v-model="comment" class="commentFormTextarea"></textarea><br>

            <button class="commentFormButton">Envoyer</button>
        </form>
        </div>
    </section>

</template>

<script>
export default({
    name: 'CommentForm',
    data() {
        return {
            comment: '',
            
        }
    },
    props: {
        recipe: Object
    },
    methods: {
        saveComment(event) {
            event.preventDefault();
            // nous n'envoyons le commentaire que si l'utilisateur est bien connectée
            if(this.$store.state.user) {
                // nous faisons appel à l'api pour enregistrer le commentaire
                
                const result = this.$store.state.services.recipe.saveComment(
                    this.recipe.id,
                    this.comment
                );
                
                if(result ){
              console.log('OK TOUT EST NICKEL');
              //this.$router.push('profile');
                }
                
            }
            else {
                return ('raté');
            }
        }
    }
});
</script>

<style>
</style>