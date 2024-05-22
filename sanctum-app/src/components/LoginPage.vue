<template>
  <div class="login-container">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
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
                <div class="text-center"> <!-- Added class for centering -->
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
    },
    clearErrors() {
      this.errors = null;
    }
  }
};
</script>

<style scoped>


.card {
  border: none;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.card-title {
  color: #333;
}

/* Add additional styles as needed */
</style>
