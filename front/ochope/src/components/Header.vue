<template>
  <header class="header header--vertical">
  <div class="headerTop">
  <img class="logo" src="../assets/logo.png">
  </div> 
  <nav class="navHeader">
    <div class="navHeaderItem"><router-link :to="{
                    name: 'home',
                }"
            >Home</router-link></div>
    <div class="navHeaderItem"><router-link :to="{
                    name: 'recipes',
                }"
            >Recipes</router-link></div>
    <div class="navHeaderItem"><router-link :to="{
                    name: 'register',
                }"
            >Register/Login</router-link></div>
    <div class="navHeaderItem"><router-link :to="{
                    name: 'logout',
                }"
            >Logout</router-link></div>
    <div class="navHeaderItem">About</div>
    <div class="navHeaderItem">Forum</div>
    <div class="navHeaderItem"><router-link :to="{
                    name: 'profile',
                }"
            >Profile</router-link></div>
  </nav>
  <nav class="navHeaderBottom">
    <div class="navHeaderBottomItem"><img class="pictureFb" src="../assets/images/facebook.png"></div>
    <div class="navHeaderBottomItem"><img class="pictureTwitter" src="../assets/images/twitter.png"></div>
    <div class="navHeaderBottomItem">Legal notice</div>
    <div class="navHeaderBottomItem">Privacy policy</div>
  </nav>
  </header>
</template>

<script>
export default {
  name: 'Header',
 
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">


</style>
