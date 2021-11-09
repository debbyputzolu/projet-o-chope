import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../views/Home.vue'
import Recipe from '../views/Recipe.vue'
import RecipeList from '../views/RecipeList.vue'
import Register from '../views/Register.vue'
import Profile from '../views/Profile.vue'
import RecipeCreate from '../views/RecipeCreate.vue'
import Logout from '../views/Logout.vue'

Vue.use(VueRouter)

const routes = [
    {
      path: '/', // URL configuration to match
      name: 'home', // road name
      component: Home // component to call
    },

    {
      path: '/recipes', // URL configuration to match
      name: 'recipes', // road name
      component: RecipeList // component to call
    },

    {
      path: '/recipe/:id', // URL configuration to match
      name: 'recipe', // road name
      component: Recipe // component to call
    },

    {
      path: '/register', // URL configuration to match
      name: 'register', // nom de la route
      component: Register // component to call
    },

    {
      path: '/profile', // URL configuration to match
      name: 'profile', // road name
      component: Profile // component to call
    },

    {
      path: '/recipe-create', // URL configuration to match
      name: 'recipe-create', // road name
      component: RecipeCreate // component to call
    },

    {
      path: '/logout', // URL configuration to match
      name: 'logout', // road name
      component: Logout // component to call
    },
]



const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router