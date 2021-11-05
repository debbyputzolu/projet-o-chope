import Vue from 'vue'
import App from './App.vue'

import router from './plugins/router.js'
import './assets/scss/main.scss'

import VueCarousel from 'vue-carousel';

Vue.use(VueCarousel);

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
