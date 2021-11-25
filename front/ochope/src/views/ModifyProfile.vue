<template>
    <section class="modifyProfile">
        <h2 class="modifyProfileTitle">Modifier mon profil</h2>
        <form action="" class="modifyProfileForm">

        <div class="modifyProfileItem">Mon pseudo : {{user.user_display_name}}</div>
        <div class="modifyProfileItem">Mon adresse email : {{user.user_email}}</div>
        <div class="modifyProfileItem">Mon mot de passe : </div>

            <button class="modifyProfileButton">Modifier</button>
        </form>
    </section>
</template>

<script>


export default {
    name: 'ModifyProfile',

    computed: {
    user(){
        console.log(this.$store.state.user)
      return this.$store.state.user;
    }
  }
   
}
</script>

<style scoped lang="scss">
section{
    color: white;
}
</style>