<template>
 <section>
     Vous êtes à présent déconnectés
 </section>
</template>

<script>
import userService from '../services/userService'
export default {
    name: 'Logout',
  
  created(){
      //deconnexion user
      userService.logout();
  }
}
</script>

<style scoped lang="scss">
</style>