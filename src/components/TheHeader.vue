<template>
  <div>
  <b-navbar toggleable="lg" type="dark" variant="primary">
    <b-navbar-brand to="/"><b-icon-wifi></b-icon-wifi> Crowd Fi</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav class="ml-auto">
      <b-navbar-nav>
        <b-nav-item to="/add-point"><b-icon-plus></b-icon-plus> Add Point</b-nav-item>
        <b-nav-item to="/search" ><b-icon-search></b-icon-search> Search</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
  </div>
</template>
<script>
export default {
  name: 'TheHeader'
}
</script>