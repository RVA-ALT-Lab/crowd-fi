<template>
  <div>
    <b-card
      v-for="place in places"
      :key="place.name"
      :title="place.name"
      :sub-title="place.formatted_address"
    >
      <b-card-text>
        <div v-html="place.description"></div>
        <p v-if="place.distance">{{Math.round(place.distance)}} Mile<span v-if="Math.round(place.distance) > 1 || Math.round(place.distance) < 1">s</span> Away</p>
        <router-link class="card-link" :to="`/access-point/${place.id}`"> Get Driving Directions</router-link>
      </b-card-text>
    </b-card>
  </div>
</template>

<script>
export default {
  name: 'Places',
  props: {
    places: {
      type: Array,
      required: true
    }
  }
}
</script>