<template>
<div>
<nav  class="headerMobile">
    <label class="toggleLabel" for="toggle">☰</label>
    <h2 class="headerMobileTitle">O'Chope</h2>
      <input type="checkbox" id="toggle">
        <div class="main_pages">
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
    <div class="navHeaderItem"><router-link :to="{
                    name: 'about',
                }"
            >About</router-link></div>
    <div class="navHeaderItem">Forum</div>
    <div class="navHeaderItem"><router-link :to="{
                    name: 'profile',
                }"
            >Profile</router-link></div>
    </div>
</nav>
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
    <div class="navHeaderItem"><router-link v-if="!user" :to="{
                    name: 'register',
                }"
            >Register/Login</router-link></div>
    <div class="navHeaderItem"><router-link v-if="user" :to="{
                    name: 'logout',
                }"
            >Logout</router-link></div>
    <div class="navHeaderItem"><router-link :to="{
                    name: 'about',
                }"
            >About</router-link></div>
    <div class="navHeaderItem">Forum</div>
    <div class="navHeaderItem"><router-link v-if="user" :to="{
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
  </div>
</template>

<script>


export default {
  name: 'Header',

 computed: {

    user() {
        //console.log("on est bien la");
        //console.log(this.$store.state.user);
            return this.$store.state.user;
       }
    }

  
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">


</style>
