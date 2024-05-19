<template>
  <nav class="navbar">
    <div class="container d-flex justify-content-end">
      <ul class="nav">
        <router-link to="/logout" class="col-6">Logout</router-link>
      </ul>
    </div>
    <h1>HomePage</h1>
    <ul>
      <li v-for="(post, index) in this.posts ":key="post">{{ post.title }}</li>
    </ul>
  </nav>
  <!-- the router view is where all the routes are rendered -->
  <router-view />
</template>

<script>
import axios from 'axios';
export default {
  name: 'HomePage',
  data() {

    return {
      posts: [],

    };
  },
  async mounted() {
    const response = await axios.get(this.$root.$data.apiUrl + '/home');
    this.posts = response.data.posts
  },

  methods: {

  }
}
</script>
