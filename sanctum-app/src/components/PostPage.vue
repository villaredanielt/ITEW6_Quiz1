<template>
    <NavBar></NavBar>
    <div class="container">
      <h1>{{ post.title }}</h1>
      <p><strong>Author: {{ author.name }} </strong></p>
      <p><strong>Created At: {{ formatDate(post.created_at) }}</strong></p>
      <p>{{ post.body }}</p>
      <button @click="editPost(post)" class="btn btn-warning m-2">Edit</button>
      <button @click="showModal = true" class="btn btn-danger m-2">Delete</button>
      <button @click="toHomePage()" class="btn btn-secondary m-2">Back</button>
    </div>
  
    <!-- Delete Modal -->
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-content">
        <p>Are you sure you want to delete this post?</p>
        <button @click="deletePost(post)" class="btn-confirm">Yes</button>
        <button @click="showModal = false" class="btn-cancel">No</button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import NavBar from '@/components/NavBar.vue'
  export default {
    name: 'PostDetailsPage',
    components: {
      NavBar
    },
    async mounted() {
      const response = await axios.get(this.$root.$data.apiUrl + "/show/" + this.$route.params.id);
      this.post = response.data.post;
      this.author = this.post.user
    },
    data() {
      return {
        post: '',
        author: '',
        showModal: false,
      }
    },
    methods: {
      async deletePost(post) {
        const response = await axios.delete(this.$root.$data.apiUrl + "/delete/" + post.id);
        if (response.status == 200) {
          alert(post.title + " is Deleted");
          this.$router.go(-1);
        }
        this.showModal = false; // Close the modal after deleting the post
      },
      toHomePage() {
        this.$router.go(-1);
      },
      editPost(post) {
        this.$router.push({
          path: '/edit/' + post.id,
          params: { id: post.id }
        });
      },
      formatDate(value) {
        let date = new Date(value);
        const day = date.toLocaleString('default', { day: '2-digit' });
        const month = date.toLocaleString('default', { month: 'short' });
        const year = date.toLocaleString('default', { year: 'numeric' });
        return day + '-' + month + '-' + year;
      },
    }
  }
  </script>
  
  <style scoped>
  /* Modal */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .modal-content {
    background: #fff;
    padding: 15px;
    width: 300px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.8);
  }
  
  .btn-confirm, .btn-cancel {
    margin: 10px 5px;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    border: none;
    transition: background 0.3s ease;
  }
  
  .btn-confirm {
    padding: 10px;
    border-radius: 15px;
    box-shadow: rgba(45, 35, 66, 0.5) 0 2px 4px, rgba(45, 35, 66, 0.5) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
    background-color: #ff0000;
    border: none;
    color: white;
    cursor: pointer;
    border: 1px solid #000000;
    transition: all 0.3s ease;
  }
  
  .btn-confirm:hover {
    background: linear-gradient(to bottom, #ec2b2b, white);
    color: black;
    border: 1px solid #ec2b2b;
    transform: scale(1.02);
  }
  
  .btn-cancel {
    padding: 10px;
    border-radius: 15px;
    box-shadow: rgba(45, 35, 66, 0.5) 0 2px 4px, rgba(45, 35, 66, 0.5) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
    background-color: #31b0d5;
    border: none;
    color: white;
    cursor: pointer;
    border: 1px solid #000000;
    transition: all 0.3s ease;
  }
  
  .btn-cancel:hover {
    background: linear-gradient(to bottom, #7cadec, white);
    color: black;
    border: 1px solid #7cadec;
    transform: scale(1.02);
  }
  </style>
  