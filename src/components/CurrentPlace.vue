<template>
<div>
  <h3>Location Details</h3>
  <b-form-group
    id="fieldset-1"
    description="You can change this or use the value provided by Google Place search."
    label="What is the name of this location?"
    label-for="input-1"
  >
    <b-form-input id="place.name" v-model="place.name" trim></b-form-input>
  </b-form-group>
  <b-form-group
    id="fieldset-2"
    description="Please use the following format: 123 Main Street, Farmville Virginia 23901. You can search for addresses using the Google search box."
    label="What is the address of this location?"
    label-for="input-1"
    placeholder="123 Main Street, Farmville Virginia 23901"
  >
    <b-form-input id="place.formatted_address" v-model="place.formatted_address" trim></b-form-input>
  </b-form-group>
  <b-form-group
    id="fieldset-2"
    description="Please include details like the network name, passwords, or other information about the placement of access points or coverage."
    label="What are the details of the network at this location?"
    label-for="input-1"
    placeholder="123 Main Street, Farmville Virginia 23901"
  >
    <b-form-textarea
      id="textarea"
      v-model="place.description"
      placeholder="Enter something..."
      rows="3"
      max-rows="6"
    ></b-form-textarea>
  </b-form-group>
  <b-button block variant="primary" @click="addNewLocation">
    <b-spinner small v-if="loading"></b-spinner>
    <span v-if="loading">Loading...</span>
    <span v-if="!loading">Save Location</span>
  </b-button>
  <b-button block variant="secondary" @click="removePlaceSelection">
    <span>Cancel</span>
  </b-button>
</div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'CurrentPlace',
  props: {
    place: {
      type: Object,
      required:true
    }
  },
  data () {
    return {
      loading: false
    }
  },
  methods: {
    addNewLocation: function () {
      this.loading = true
      axios({
        url:`${window.WP_OPTIONS.siteurl}/wp-json/crowd-fi/v1/map-point`,
        method: 'POST',
        headers:{
          'X-WP-Nonce': window.WP_OPTIONS.rest_nonce
        },
        data: {
          name: this.place.name,
          formatted_address: this.place.formatted_address,
          latitude: this.place.location.lat,
          longitude: this.place.location.lng,
          description: this.place.description
        }
      })
      .then(res => {
        this.loading = false
        this.$emit('place-add-success', res.data)
      })
      .catch(error => {
        this.loading = false
        this.onError(error)
      })
    },
    onError (error) {
      this.$bvToast.toast(`Error: ${error.message}`, {
        title: 'Error Adding Location',
        variant: 'danger',
        solid: true
      })
    },
    removePlaceSelection () {
      console.log('calling emit')
      this.$emit('remove-place-selection', false)
    }

  }
}
</script>