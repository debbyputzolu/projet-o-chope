<template>
<section class="inscription">
  
  <img src="../assets/images/community.png" class="inscriptionImage">
  <h2 class="inscriptionTitle">Création d'un nouveau compte</h2>
  <form @submit="handleSubmit" class="inscriptionForm">
            <label class="inscriptionLabel">Nom d'utilisateur
                <br><input v-model="username" name="username">
            </label>
            <div class="error" v-if="usernameEmpty">
                Vous devez saisir un pseudo
            </div>
            <label class="inscriptionLabel">Nom
                <br><input v-model="lastname" name="lastname">
            </label>
            <div class="error" v-if="lastnameEmpty">
                Vous devez saisir un nom
            </div>
            <label class="inscriptionLabel">Prénom
                <br><input v-model="firstname" name="firstname">
            </label>
            <div class="error" v-if="firstnameEmpty">
                Vous devez saisir un prénom
            </div>

            <label class="inscriptionLabel">Email
                <br><input v-model="email" name="email">
            </label>
            <div class="error" v-if="emailEmpty">
                Vous devez saisir un email
            </div>

        <label class="inscriptionLabel">
            Mot de passe
            <br><input v-model="password" type="password" name="password">
        </label>
        <div class="error" v-if="passwordEmpty">
                Vous devez saisir un mot de passe
        </div>

        <label class="inscriptionLabel">
            Vérification mot de passe
            <br><input v-model="passwordBis" type="password" name="passwordBis">
        </label>
        <div class="error" v-if="passwordBisEmpty">
               Vous devez saisir un deuxieme fois le mot de passe
        </div>

        <div class="error" v-if="passwordNotEqual">Les deux mot de passe ne sont pas identiques</div>

        <div class="error" v-if="formFailed">
                Le formulaire n'a pas pu être soumis
        </div>

        <button class="inscriptionButton">S'inscrire</button>

        </form>
</section>
</template>

<script>
import userService from '../services/userService.js';

export default {
    name: 'Inscription',

     data(){
      return {
        username:'',
        lastname:'',
        firstname:'',
        email:'',
        password:'',
        passwordBis: '',
        usernameEmpty: false,
        lastnameEmpty: false,
        firstnameEmpty: false,
        emailEmpty: false,
        passwordEmpty: false, 
        passwordBisEmpty: false,
        passwordNotEqual: false,
        formFailed: false
      };
  },

  methods: {
      async handleSubmit(evt){
          evt.preventDefault();
          if(this.username == ''){
              console.log('NOM UTILISATEUR EST VIDE !!');
              this.usernameEmpty = true;
          }
          if(this.lastname == ''){
              console.log('NOM EST VIDE !!');
              this.lastnameEmpty = true;
          }
          if(this.firstname == ''){
              console.log('PRENOM EST VIDE !!');
              this.firstnameEmpty = true;
          }
          if(this.email == ''){
              console.log('EMAIL EST VIDE !!');
              this.emailEmpty = true;
          }
          if(this.password == ''){
              console.log('PASSWORD EST VIDE !!');
              this.passwordEmpty = true;
          }
        if(this.passwordBis == ''){
              console.log('PASSWORD BIS EST VIDE !!');
              this.passwordBisEmpty = true;
          }
          if(this.password != this.passwordBis){
              this.passwordNotEqual = true;
          }

          if(this.username != '' && 
          this.lastname != '' &&
          this.firstname != '' &&
          this.email != '' && 
          this.password != '' &&
          this.passwordBis != '' 
          && this.password == this.passwordBis
          ){
              console.log('on est la');
            const result = await userService.inscription(
            this.username,
            //this.lastname,
            //this.firstname,
            this.email,
            this.password
            ); 

            //console.log(result);
          
          
          if(result){
              console.log('OK TOUT EST NICKEL');
              this.$router.push('profile');
          }
        }
        else{
            console.log("coucou c'est nous");
        }
      }
  }
  

}
</script>

<style scoped lang="scss">


</style>