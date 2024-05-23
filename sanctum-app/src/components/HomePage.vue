<template>
  <div>
    <NavBar></NavBar>
    <div class="container mt-4">
      <div class="row">
        <div class="col text-center">
          <router-link to="/create" class="btn btn-primary mb-3">Create New Post</router-link>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th width="30%">Title</th>
              <th width="20%">Created At</th>
              <th width="25%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(post, index) in posts" :key="post.id">
              <td>{{ post.title }}</td>
              <td>{{ formatDate(post.created_at) }}</td>
              <td>
                <button class="btn btn-info btn-sm m-1" @click="viewPost(post)">View</button>
                <button @click="editPost(post)" class="btn btn-warning btn-sm m-1">Edit</button>
                <button @click="openDeleteModal(post, index)" class="btn btn-danger btn-sm m-1">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-if="showModal" class="modal fade show d-block" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete Confirmation</h5>
              <button type="button" class="close" aria-label="Close" @click="closeDeleteModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this post?</p>
            </div>
            <div class="modal-footer">
              <button @click="confirmDelete" class="btn btn-danger">Yes</button>
              <button @click="closeDeleteModal" class="btn btn-secondary">No</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <router-view />
  </div>
</template>

<script>
import axios from 'axios';
import NavBar from '@/components/NavBar.vue';

export default {
  components: {
    NavBar
  },
  async mounted() {
    try {
      const response = await axios.get(this.$root.$data.apiUrl + '/home');
      this.posts = response.data.posts;
    } catch (error) {
      console.error('Error fetching posts:', error);
      if (error.response) {
        console.error('Response error:', error.response);
      } else if (error.request) {
        console.error('Request error:', error.request);
      } else {
        console.error('Axios error:', error.message);
      }
    }
  },
  data() {
    return {
      posts: [],
      showModal: false,
      postToDelete: null,
      postIndexToDelete: null
    };
  },
  methods: {
    openDeleteModal(post, index) {
      this.postToDelete = post;
      this.postIndexToDelete = index;
      this.showModal = true;
    },
    closeDeleteModal() {
      this.showModal = false;
      this.postToDelete = null;
      this.postIndexToDelete = null;
    },
    async confirmDelete() {
      if (this.postToDelete) {
        try {
          const response = await axios.delete(this.$root.$data.apiUrl + "/delete/" + this.postToDelete.id);
          if (response.status == 200) {
            this.posts.splice(this.postIndexToDelete, 1);
            alert(this.postToDelete.title + " is successfully deleted");
          }
        } catch (error) {
          console.error('Error deleting post:', error);
        }
      }
      this.closeDeleteModal();
    },
    formatDate(value) {
      let date = new Date(value);
      const day = date.toLocaleString('default', { day: '2-digit' });
      const month = date.toLocaleString('default', { month: 'short' });
      const year = date.toLocaleString('default', { year: 'numeric' });
      return day + '-' + month + '-' + year;
    },
    viewPost(post) {
      this.$router.push({
        path: '/show/' + post.id,
        params: { id: post.id }
      });
    },
    editPost(post) {
      this.$router.push({
        path: '/edit/' + post.id,
        params: { id: post.id }
      });
    },
  }
}
</script>

<style scoped>
/* Additional custom styles */

.modal.fade.show {
  display: block;
  background: rgba(0, 0, 0, 0.5);
}

.modal-content {
  border-radius: 0.5rem;
}

/* Optional: adjust button sizes if needed */
.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
}
</style>
