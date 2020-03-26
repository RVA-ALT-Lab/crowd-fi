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
  <b-button block variant="primary">Save Location</b-button>
</div>
</template>

<script>
export default {
  name: 'CurrentPlace',
  props: {
    place: {
      type: Object,
      required:true
    }
  },
  data () {
    return {}
  },
  methods: {

  }
}
</script>