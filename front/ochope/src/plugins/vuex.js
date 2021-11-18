import Vue from 'vue';
import Vuex from 'vuex';

import storage from '../plugins/storage.js';
import userService from '../services/userService';
import recipeService from '../services/recipeService';

Vue.use(Vuex);


const store = new Vuex.Store({

    // stocke les données partageable avec les composants
    state: {
      user: null,

      services: {
          user: userService,
          recipe: recipeService,
          storage: storage
      }

    },
  
    // "setters" pour modifier le state du store
    mutations: {
      saveUser(state, user) {
        //console.log('%c' + 'Stockage du user', 'color: #0bf; font-size: 1rem; background-color:#fff');
        // on enregistre dans le state l'utilisateur
        state.user = user;
      },
      clearUser(state) {
          state.user = false;
      }
    }
  });

const userData = storage.get('userData');
if(userData){
    store.commit('saveUser', userData);
}



export default store;