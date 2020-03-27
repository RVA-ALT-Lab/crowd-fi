<template>
  <div>
    <div v-for="place in places" :key="place.name" class="card">
      <div class="card-body">
        <h5 class="card-title">{{place.title.rendered}}</h5>
        <p>{{place.meta.latitude}}</p>
        <p>{{place.meta.longitude}}</p>
        <p>{{place.id}}</p>
        <router-link :to="`/access-point/${place.id}`">Directions</router-link>

      </div>
    </div>
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