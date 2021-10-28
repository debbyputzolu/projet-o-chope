<template>
  <header class="header header--vertical">
  <div class="headerTop">
  <img class="logo" src="../assets/logo.png">
  <div>O'Chope</div>
  </div> 
  <nav class="navHeader">
    <div class="navHeaderItem">Home</div>
    <div class="navHeaderItem">Recipes</div>
    <div class="navHeaderItem">Register/Login</div>
    <div class="navHeaderItem">About</div>
    <div class="navHeaderItem">Forum</div>
    <div class="navHeaderItem">Profile</div>
  </nav>
  <nav class="navHeaderBottom">
    <div class="navHeaderBottomItem"><img class="picture" src="../assets/images/facebook.png"></div>
    <div class="navHeaderBottomItem"><img class="picture" src="../assets/images/twitter.png"></div>
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



/*header {
  align-items: center;
  height: auto;
  display: flex;
  flex-direction: row;
  padding: 2rem; 
  background-image: url(../assets/images/fondmenuheader.png);
  background-size: contain;
  background-repeat: no-repeat; 
  bottom: 0;
  flex-direction: column;
  grid-area: header;
  height: auto;
  left: 0;
  position: fixed;
  top: 0;
  width: 25%;

}

.logo {
  align-items: center;
  display: flex;
  flex-direction: row;
  box-sizing: border-box;
  width: 25%;
 
}

*/



</style>
