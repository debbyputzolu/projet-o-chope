import Vue from 'vue'
import VueRouter from 'vue-router'

import Recipe from '../views/Recipe.vue'
import RecipeList from '../views/RecipeList.vue'
import Register from '../views/Register.vue'
import Profile from '../views/Profile.vue'
import RecipeCreate from '../views/RecipeCreate.vue'
//import HelloWorld from '../views/HelloWorld.vue'

Vue.use(VueRouter)

const routes = [
    {
      path: '/', // configuration de l'url a "matcher"
      name: 'recipes', // nom de la route
      component: RecipeList // composant a appeler
    },

    {
      path: '/recipe', // configuration de l'url a "matcher"
      name: 'recipeOnly', // nom de la route
      component: Recipe // composant a appeler
    },

    {
      path: '/register', // configuration de l'url a "matcher"
      name: 'register', // nom de la route
      component: Register // composant a appeler
    },

    {
      path: '/profile', // configuration de l'url a "matcher"
      name: 'profile', // nom de la route
      component: Profile // composant a appeler
    },

    {
      path: '/recipe-create', // configuration de l'url a "matcher"
      name: 'recipe-create', // nom de la route
      component: RecipeCreate // composant a appeler
    },
]



const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router