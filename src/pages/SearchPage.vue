<template>
  <div>
    <b-overlay :show="places.length === 0">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <h2>Search</h2>
          <gmap-map
            :center="center"
            :zoom="12"
            ref="mapRef"
            style="width:100%;  height: 400px;"
          >
            <gmap-marker
              :key="index"
              v-for="(m, index) in formattedPlaces"
              :position="m.location"
              @click="center=m.location"
            ></gmap-marker>
          </gmap-map>
          <div class="directions" ref="directionsDiv"></div>
          <places :places="places"></places>
        </div>
      </div>
    </div>
    </b-overlay>
  </div>
</template>

<script>
import Places from '../components/Places.vue'
import { gmapApi } from 'vue2-google-maps'
export default {
  name: 'SearchPage',
  components: {
    Places
  },
  data () {
    return {
      center: { lat: 45.508, lng: -73.587 },
      markers: [],
      places: [],
      currentPlace: {
        name: 'Your Location',
        formatted_address: '',
        location: { lat: 45.508, lng: -73.587 }
      }
    }
  },
  computed: {
    formattedPlaces () {
      return this.places.map(place => {
        return {location: {lat: parseFloat(place.meta.latitude), lng: parseFloat(place.meta.longitude) }}
      })
    },
    google: gmapApi
  },
  mounted () {
    this.geolocate()
    this.getPlaces()
  },
  methods: {
    getPlaces() {
      fetch(`${window.WP_OPTIONS.siteurl}/wp-json/wp/v2/map-point?_embed&per_page=100`)
      .then(res => res.json())
      .then(data => {
        data.forEach(point => {
          this.places.push(point)
        });
      });
    },
    geolocate: function() {
      navigator.geolocation.getCurrentPosition(position => {
        console.log(position)
        this.center.lat = position.coords.latitude
        this.center.lng = position.coords.longitude
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