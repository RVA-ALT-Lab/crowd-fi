import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import * as VueGoogleMaps from "vue2-google-maps"
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.use(VueGoogleMaps, {
  load: {
    key: window.WP_OPTIONS.google_api_key,
    libraries: "places" // necessary for places input
  }
});



import App from './App.vue'

const app = new Vue({
  el:'#app',
  render: h => h(App)
})