<template>
<div class="row">
  <div class="col">
   <b-jumbotron>
    <template v-slot:header>Crowd Sourced Wi-Fi</template>

    <template v-slot:lead>
      A resource for remote learning, teaching, and working during the COVID 19 pandemic.
    </template>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="100px" width="100px" fill="#1a1a1a" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><g><rect x="62.8" y="31.3" transform="matrix(4.051926e-02 -0.9992 0.9992 4.051926e-02 12.0525 110.6352)" width="1.6" height="35.5"/></g><g><rect x="32.9" y="31.4" transform="matrix(0.213 -0.9771 0.9771 0.213 7.4163 73.6177)" width="33" height="1.6"/></g><g><rect x="65.1" y="20.1" transform="matrix(0.9303 -0.3668 0.3668 0.9303 -12.7124 27.4816)" width="1.6" height="54.2"/></g><g><rect x="58.5" y="42.8" transform="matrix(0.6944 -0.7196 0.7196 0.6944 -25.6393 61.2926)" width="1.6" height="36"/></g><g><rect x="22.4" y="53.2" transform="matrix(0.8732 -0.4874 0.4874 0.8732 -21.865 24.0108)" width="25.6" height="1.6"/></g><g><rect x="37.9" y="32.1" transform="matrix(0.67 -0.7424 0.7424 0.67 -18.2819 42.5382)" width="1.6" height="19.4"/></g><circle cx="45.9" cy="48.3" r="8.1"/><circle cx="31.5" cy="35.3" r="6.3"/><circle cx="54" cy="16.1" r="11.3"/><circle cx="17.3" cy="59.5" r="12.8"/><circle cx="78.5" cy="78.7" r="16"/><circle cx="81.4" cy="49.8" r="4.8"/></g></svg>
    <hr class="my-4">

    <p>
      This map is sourced from the community, so please help us in adding public wi-fi access points to ensure that everyone can teach, learn, and work remotely to help flatten the curve.
    </p>
    <b-alert show variant="dark">
      <h4><b-icon-exclamation-diamond></b-icon-exclamation-diamond> Geolocation Features</h4>
      <p>This website uses browser geolocation features to access your current location and find you the nearest wi-fi hotspots. If you are not prompted to allow access to your location, please update your security preferences to allow this site access to your location. You will be unable to generate directions without this feature enabled.</p>
    </b-alert>

    <b-button variant="primary" to="/search"><b-icon-search></b-icon-search> Search Access Points</b-button>
    <b-button variant="success" to="/add-point"><b-icon-plus></b-icon-plus> Add Access Point</b-button>
  </b-jumbotron>
  </div>
</div>
</template>

<script>
export default {
  name: 'IndexPage'
}
</script>