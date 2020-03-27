<template>
  <div>
    <b-overlay :show="overlay">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <h2>Directions</h2>
          <gmap-map
            :center="center"
            :zoom="12"
            style="width:100%;  height: 400px;"
            ref="mapRef"
          >
          </gmap-map>
          <div ref="directionsDiv"></div>
        </div>
      </div>
    </div>
    </b-overlay>
  </div>
</template>

<script>
import { gmapApi } from 'vue2-google-maps'
export default {
  name: 'PointDetailsPage.vue',
  data () {
    return {
      center: { lat: 45.508, lng: -73.587 },
      currentLocation: {
        location: {lat: null, lng: null}
      },
      accessPoint: {
        location: {lat: null, lng: null}
      },
      overlay: true
    }
  },
  computed: {
    google: gmapApi
  },
  mounted () {
    this.coordinateDirectionsRequest()
  },
  methods: {
    coordinateDirectionsRequest () {
      this.getAccessPoint().then(accessPoint => {
        this.geolocate().then(position => {
          this.generateDirections(this.currentLocation.location, this.accessPoint.location)
        })
      })
    },
    getAccessPoint() {
      return new Promise((resolve, reject) => {
        fetch(`${window.WP_OPTIONS.siteurl}/wp-json/wp/v2/map-point/${this.$route.params.id}`)
        .then(res => res.json())
        .then(accessPoint => {
          this.accessPoint.location.lat = accessPoint.meta.latitude
          this.accessPoint.location.lng = accessPoint.meta.longitude
          resolve(accessPoint)
        });
      })
    },
    geolocate: function() {
      return new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(position => {
          this.currentLocation.location.lat = position.coords.latitude
          this.currentLocation.location.lng = position.coords.longitude
          resolve(position)
        });
      })
    },
    generateDirections (origin, destination) {
      console.log(this.$refs.mapRef)
      const directions = new this.google.maps.DirectionsService()
      directions.route(
        {
          destination: `${destination.lat},${destination.lng}`,
          origin: `${origin.lat},${origin.lng}`,
          travelMode: 'DRIVING'
        }, (data) => {
            const directionsRenderer = new this.google.maps.DirectionsRenderer({
              directions: data,
              map: this.$refs.mapRef.$mapObject,
              panel: this.$refs.directionsDiv
            })
            this.overlay = false
        })
    }
  }
}
</script>

<style lang="css">
  .vue-map {
    height: 400px;
  }
</style>