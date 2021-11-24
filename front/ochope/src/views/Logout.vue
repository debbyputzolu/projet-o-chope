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
      //user logout
      userService.logout();
      this.$router.push('/')
      this.$router.go();
  
  },
   
}
</script>

<style scoped lang="scss">
</style>