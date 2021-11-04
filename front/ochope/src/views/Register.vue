<template>
  <div class="register">
   <Login/>

   <Inscription/>
  </div>
</template>

<script>
import Login from '../components/Login.vue';
import Inscription from '../components/Inscription.vue';

export default {
  name: 'Register',
  components: {
    Login,
    Inscription
  }
}


</script>

<style lang="scss">

</style>
