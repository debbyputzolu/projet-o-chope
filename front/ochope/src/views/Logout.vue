<template>
 <section>
    <h2 class="logoutTitle"> Vous êtes à présent déconnectés</h2>
 </section>
</template>

<script>
import userService from '../services/userService'
export default {
    name: 'Logout',
  
  created(){
      //deconnexion user
      userService.logout();  
  },

  
}
</script>

<style scoped lang="scss">
</style>