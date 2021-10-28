import Vue from 'vue'
import VueRouter from 'vue-router'

import RecipeList from '../views/RecipeList.vue'
//import HelloWorld from '../views/HelloWorld.vue'

Vue.use(VueRouter)

const routes = [
    {
      path: '/', // configuration de l'url a "matcher"
      name: 'recipes', // nom de la route
      component: RecipeList // composant a appeler
    },
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router