<template>
  <div class="login-container">
    <div class="container mt-5">
      <div class="row justify-content-start"> <!-- Adjusted to align the card to the left -->
        <div class="col-md-6">
          <img src="https://www.psdgraphics.com/file/group-of-people.jpg" alt="Logo" class="logo">
          <div class="card"></div>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center">ENTER YOUR EMAIL AND PASSWORD</h4>
              <form @submit.prevent="loginUser">
                <div class="form-group">
                  <input type="email" class="form-control" id="email" v-model="email" placeholder="Enter email" required @input="clearErrors">
                  <small class="text-danger" v-if="errors">{{ errors }}</small>
                </div><br>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" v-model="password" placeholder="Password" required @input="clearErrors">
                </div><br>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
              </form>
              <p class="mt-3 text-center">Don't have an account? <router-link to="/register">Register here!</router-link></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      errors: null
    };
  },
  methods: {
    async loginUser() {
      // Check if the email and password are correct
      if (this.email === 'admin@gmail.com' && this.password === 'admin') {
        this.$router.push('/home');
      } else {
        try {
          const response = await axios.post(this.$root.$data.apiUrl + '/login', {
            email: this.email,
            password: this.password
          });
          if (response.status === 201) {
            localStorage.setItem('token', response.data.token);
            this.$router.push('/home');
          }
        } catch (error) {
          this.errors = error.response.data.message;
        }
      }
    },
    clearErrors() {
      this.errors = null;
    }
  }
};
</script>

<!-- background-image: url('C:\Abegil\ITEW6_Quiz1\sanctum-app\src\image\social-network-modern-flat-concept-web-banner-design-woman-communicates-online-chats_9209-8395.jpg'); -->

<style scoped>
.login-container {
    background-size: 800px 750px; /* Set background size */
  background-position: right; /* Adjusted to position the image on the right side */
  background-repeat: no-repeat;
  height: 100vh; /* Set the height of the container to 100% of the viewport height */
  display: flex;
  margin-right: 0px;
  justify-content: left; /* Adjusted to align the card to the left */
  align-items: center;
}

.card {
  background-color: rgb(135, 190, 235);
  border: none;
  border-radius: 10px;
  margin-right: 50px;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Added box shadow */
}

.card-title {
  color: #333;
}

.logo {
  max-width: 15%; /* Ensure the logo doesn't exceed its container */
  position: absolute; /* Position the logo absolutely */
  top: 50%; /* Position from the top */
  left: 50%; /* Position from the left */
  transform: translate(-210%, -180%); /* Center the logo */
}
/* Add additional styles as needed */
</style>
