<template>
  <div>
    <the-header></the-header>
    <b-button>Button</b-button>
    <gmap-autocomplete
          @place_changed="setPlace">
    </gmap-autocomplete>
    <gmap-map
      :center="center"
      :zoom="12"
      style="width:100%;  height: 400px;"
    ></gmap-map>
  </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import TheHeader from './components/TheHeader.vue'
export default {
  name: 'App',
  components: {
    TheHeader
  },
  data () {
    return {
      center: { lat: 45.508, lng: -73.587 },
      markers: [],
      places: [],
      currentPlace: null
    }
  },
  mounted () {
    this.geolocate()
  },
  methods: {
    setPlace(place) {
      this.currentPlace = place;
    },
    async getPlaces() {

    },
    geolocate: function() {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
      });
    }
  }
}
</script>

<style lang="css">
  .vue-map {
    height: 400px;
  }
</style>