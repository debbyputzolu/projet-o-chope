<template>
    <section class="login">
        <img src="../assets/images/login.png" class="loginImage">
        <h2 class="loginTitle">Connexion</h2>
        <form @submit="handleSubmit" class="loginForm">
            <label class="loginLabel">Login
                <br><input v-model="login" name="login">
            </label>
            <div class="error" v-if="loginEmpty">
                Vous devez saisir un identifiant
            </div>

        <label class="loginLabel">
            Mot de passe
            <br><input v-model="password" type="password" name="password">
        </label>
        <div class="error" v-if="passwordEmpty">
                Vous devez saisir un mot de passe
        </div>

        <div class="error" v-if="loginFailed">
                Echec de connexion
        </div>

        <button class="loginButton">Se connecter</button>

        </form>

    </section>
</template>

<script>

import userService from '../services/userService.js';
import storage from '../plugins/storage.js';

export default {
  name: 'Login',
  data(){
      return {
          login:'',
          password:'',
          loginEmpty: false,
          passwordEmpty: false,
          loginFailed: false
      };
  },
  methods: {
      async handleSubmit(evt){
          evt.preventDefault();
          if(this.login == ''){
              console.log('LOGIN EST VIDE !!');
              this.loginEmpty = true;
          }
          if(this.password == ''){
              console.log('PASSWORD EST VIDE !!');
              this.passwordEmpty = true;
          }

          // Si j'ai bien un login ET un password
          if(!this.passwordEmpty && !this.loginEmpty){
              let userData = await userService.login(this.login, this.password);
              console.log(userData);
              if(userData){
                  storage.set('userData', userData);
                  this.loginFailed = false;
                  this.$router.push('profile');
              }
              else {
                  console.log('LOGIN FAILED');
                  this.loginFailed = true;
              }

              //Si l'utilisateur a rentré des bons identifiants/mot de passe je vais recevoir dans userData un token, que je vais devoir stocker dans le localStorage (grace a mon plugin storage)
              // storage.set('userData', userData);
          }


      }
  }
}
</script>

<style scoped lang="scss">


</style>




