<template>
  <header>
    <router-link
                :to="{
                name: 'home',
            }"
        >
            <img class="logo" src="../assets/logo.png">
            <span>O'Chope</span>
    </router-link>
    <nav>
      <div>Home</div>
      <div>Recipes</div>
      <div>Register/login</div>
      <div>About</div>
      <div>Profile</div>
    </nav> 
    <nav>
      <div>Facebook</div>
      <div>Twitter</div>
      <div>Legal notice</div>
      <div>Privacy policy</div>
    </nav>
  </header>

</template>

<script>
export default {
  name: 'Header',
  props: {
    msg: String
  }
}

</script>

<style>



</style>