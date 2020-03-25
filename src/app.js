import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import * as VueGoogleMaps from "vue2-google-maps"
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyCUTDRbRz_mv5UAyeaEGloV-4MpzdtUJBA",
    libraries: "places" // necessary for places input
  }
});



import App from './App.vue'

const app = new Vue({
  el:'#app',
  render: h => h(App)
})