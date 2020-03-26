import Vue from 'vue'
import VueRouter from 'vue-router'
import IndexPage from '../pages/IndexPage.vue'
import AddPointPage from '../pages/AddPointPage.vue'
import SearchPage from '../pages/SearchPage.vue'
Vue.use(VueRouter)
const routes = [
  {path: '/', component: IndexPage },
  {path: '/add-point', component: AddPointPage },
  {path: '/search', component: SearchPage }
]
const router = new VueRouter({
  routes
})

export default router