
<template>

<!-- the router view is where all the routes are rendered -->
  <router-view/>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css';

export default {
  name: 'App',
  data() {
    return {
      apiUrl : 'http://127.0.0.1:8000/api'      
    }
  }
}
</script>

<style>
</style>
