<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <div v-if="!placeSelection" class="col">
          <h2>Add Point</h2>
          <p>There are several ways you can save a wi-fi location.</p>
          <ol>
            <li>
              <p>Save your current location</p>
              <b-button variant="outline-primary" @click="geolocate">Locate Me Again</b-button>
            </li>
            <li>
              <p>Select a location from the search complete. Please click a result.</p>
              <gmap-autocomplete class="autocomplete-input form-control"
                @place_changed="setPlace" :selectFirstOnEnter="true">
              </gmap-autocomplete>
            </li>
            <li>Click the map to manually add a map marker.</li>
          </ol>
          <p>When you are happy with the selected location, click the button below to fill out details about the location.</p>
          <b-button variant="outline-primary" @click="placeSelection = true">Fill Out Details</b-button>
        </div>
      </div>
      <current-place
        v-if="placeSelection"
        :place="currentPlace"
        v-on:remove-place-selection="removePlaceSelection"
        v-on:place-add-success="onPlaceAddSuccess"
      >
      </current-place>


      <div class="row mt-5">
        <div class="col">
          <gmap-map
            :center="center"
            :zoom="18"
            style="width:100%;  height: 400px;"
            @click="manuallySetCurrentPlace"
            ref="mapRef"
          >
            <gmap-marker
              :position="currentPlace.location"
              @click="center=currentPlace.location"
            ></gmap-marker>
          </gmap-map>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import CurrentPlace from '../components/CurrentPlace.vue'
import Places from '../components/Places.vue'
import axios from 'axios'
export default {
  name: 'AddPointPage',
  components: {
    CurrentPlace,
    Places
  },
  data () {
    return {
      center: { lat: 37.541290, lng: -77.434769 },
      markers: [],
      currentPlace: {
        name: 'Your Location',
        formatted_address: '',
        location: { lat: 37.541290, lng: -77.434769 }
      },
      placeSelection: false
    }
  },
  computed: {
  },
  mounted () {
    this.geolocate()
  },
  methods: {
    removePlaceSelection () {
      this.placeSelection = false
    },
    manuallySetCurrentPlace (event) {
      console.log(event)
      this.currentPlace = {
        formatted_address: '',
        name: 'Manually Added Place',
        location: {
          lat: event.latLng.lat(),
          lng: event.latLng.lng()
        }
      };
    },
    setPlace(place) {
      this.currentPlace = {
        formatted_address: place.formatted_address,
        name: place.name,
        location: {
          lat: place.geometry.location.lat(),
          lng: place.geometry.location.lng()
        }
      };

      this.center = this.currentPlace.location
      this.$refs.mapRef.panTo(this.center)
    },
    onGeolocateSuccess (position) {
      this.center.lat = position.coords.latitude
      this.center.lng = position.coords.longitude
      this.currentPlace.location.lat = this.center.lat
      this.currentPlace.location.lng = this.center.lng
      this.$refs.mapRef.panTo(this.center)
    },
    onGeolocateError (error) {
      const message = `Your experience will be degraded because we couldn't locate you. Plase enable geolocation services in your browser for this website and try again.\n\nError: ${error.message}`
      this.$bvToast.toast(message, {
        title: 'Error Getting Your Location',
        variant: 'danger',
        solid: true
      })
      const position = { lat: 37.541290, lng: -77.434769 }
      this.center.lat = position.latitude
      this.center.lng = position.longitude
      this.currentPlace.location.lat = this.center.lat
      this.currentPlace.location.lng = this.center.lng
      this.$refs.mapRef.panTo(this.center)
    },
    geolocate () {
      try {
        navigator.geolocation.getCurrentPosition(
          this.onGeolocateSuccess,
          this.onGeolocateError,
          {
            enableHighAccuracy: true,
            timeout: 10000
          }
          );
      } catch (error) {
        this.onGeolocateError(error)
      }
    },
    onPlaceAddSuccess (location) {
      this.removePlaceSelection()
      this.$bvToast.toast(`Successfully added new location for ${location.name}`, {
        title: 'New Location Added',
        variant: 'success',
        solid: true
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