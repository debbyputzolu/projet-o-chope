<template>
    <section>
        Vous etes a présent déconnectés

    </section>
</template>

<script>
//import userService from '../services/userService'
export default {
  name: 'Logout',
  created(){
      // deconnexion du user
      this.$store.commit('clearUser');
      this.$store.state.services.storage.logout()
  }
}
</script>

<style scoped lang="scss">
</style>