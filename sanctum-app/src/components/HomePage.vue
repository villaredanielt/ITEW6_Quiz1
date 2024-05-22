
<template>
  <NavBar></NavBar>
  <div class="container">
    <div class="background-image"></div>
    <router-link to="/create" class="btn-create">Create New Post</router-link>
    <div class="table-wrapper">
    <table class="table">
      <thead>
        <tr>
          <th width="30%">Title</th>
          <th width="20%">Created At</th>
          <th width="25%">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(post, index) in posts" v-bind:key="post.id">
          <td>{{ post.title }}</td>
          <td>{{ this.formatDate(post.created_at) }}</td>
          <td>
            <button class="btn-view btn-primary m-1" @click="viewPost(post)">View</button>
            <button @click="editPost(post)" class="btn-edit btn-warning">Edit</button>
            <button @click="openDeleteModal(post, index)" class="btn-delete btn-danger m-1">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div v-if="showModal" class="modal-overlay">
    <div class="modal-content">
      <p>Are you sure you want to delete this post?</p>
      <button @click="confirmDelete" class="btn-confirm">Yes</button>
      <button @click="closeDeleteModal" class="btn-cancel">No</button>
    </div>
  </div>
</div>
  <router-view />
</template>


<script>
import axios from 'axios';
import NavBar from '@/components/NavBar.vue';
export default {
  components: {
    NavBar
  },
  async mounted() {
    const response = await axios.get(this.$root.$data.apiUrl + '/home');
    this.posts = response.data.posts;
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
        const response = await axios.delete(this.$root.$data.apiUrl + "/delete/" + this.postToDelete.id);
        if (response.status == 200) {
          this.posts.splice(this.postIndexToDelete, 1);
          alert(this.postToDelete.title + " is sucessfully deleted");
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
    viewPost(post){
      this.$router.push({
        path: '/show/' + post.id,
        params: {id: post.id}
      });
    },
    editPost(post){
      this.$router.push({
        path: '/edit/' + post.id,
        params: {id: post.id}
      });
    },
  }
}
</script>


<style scoped>


 /*delete modal*/
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

  
  /*buttons*/
  .btn-create {
      position: fixed;
      top: 0px; 
      left: 50px; 
      z-index: 1000;
      padding: 10px;
      border-radius: 15px;
      box-shadow: rgba(45, 35, 66, 0.5) 0 2px 4px, rgba(45, 35, 66, 0.5) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
      background-color: #5293f5;
      border: none;
      color: white;
      cursor: pointer;
      border: 1px solid #000000;
      transition: all 0.3s ease; 
      margin-top: 50px;
      margin-right: 50px; 
      margin-bottom: 30px; 
      text-decoration: none;
    }

    .btn-create:hover {
    background: linear-gradient(to bottom, #5293f5, white);
        color: black;
        border: 1px solid #102033;
        transform: scale(1.02);
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
     background: linear-gradient(to bottom, #ff0000, white);
     color: black;
     border: 1px solid #360b0b;
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
     background: linear-gradient(to bottom, #31b0d5, white);
     color: black;
     border: 1px solid #0f343f;
     transform: scale(1.02);
  }



  .btn-view {
      padding: 10px;
      border-radius: 15px;
      box-shadow: rgba(45, 35, 66, 0.5) 0 2px 4px, rgba(45, 35, 66, 0.5) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
      background-color: #e6b800;
      border: none;
      color: white;
      cursor: pointer;
      border: 1px solid #000000;
      transition: all 0.3s ease; 
    }

  .btn-view:hover {
      background: linear-gradient(to bottom, #e6b800, white);
      color: black;
      border: 1px solid #352c0b;
      transform: scale(1.02);
    }

    .btn-edit {
     padding: 10px;
     border-radius: 15px;
     box-shadow: rgba(45, 35, 66, 0.5) 0 2px 4px, rgba(45, 35, 66, 0.5) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
     background-color: #00b33c;
     border: none;
     color: white;
     cursor: pointer;
     border: 1px solid #000000;
     transition: all 0.3s ease; 
   }

 .btn-edit:hover {
     background: linear-gradient(to bottom, #00b33c, white);
     color: black;
     border: 1px solid #0a3d1b;
     transform: scale(1.02);
  
   }

   .btn-delete {
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

 .btn-delete:hover {
     background: linear-gradient(to bottom, #ff0000, white);
     color: black;
     border: 1px solid #360909;
     transform: scale(1.02);
  
   }

  
       

/* Table Design */
    .table-wrapper {
      max-height: calc(95vh - 100px);
      width: 100%; 
      overflow-y: auto; 
      margin: auto; 
      margin-top: 80px;
      }

      .table thead {
        width: 100%;
        position: sticky;
        top: 0;
        background-color: #44c0ab; 
        z-index: 1; 
      }
      .table-wrapper::-webkit-scrollbar {
        width: 8px; 
        background-color: transparent;
      }

      .table-wrapper::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.3); 
        border-radius: 4px; 
      }

      .table-wrapper::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.5); 
      }

      .table-wrapper::-webkit-scrollbar-track {
        background-color: transparent; 
      }

      .modal-group {
        margin: 1rem;
        display: flex;
        flex-direction: column;
        align-items: start;
      }
      table {
        border-radius: 10px; 
        border-collapse: collapse;
        margin: auto;
        padding: 10px;
        width: 100%;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 1); 
        margin-top: 20px;
        animation: float 5s infinite;
      }

      th {
        background: rgb(255, 255, 255, 0.5);
        background: #31b0d5,;
        border-bottom: 4px solid #000000;
        border-right: 1px solid #343a45;
        font-size: 20px;
        font-weight: bold;
        padding: 24px;
        text-align: center;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        vertical-align: middle;
      }

     
      .table thead th:nth-child(1),
      .table thead th:nth-child(2),
      .table thead th:nth-child(3) {
        background: linear-gradient(to bottom, #31b0d5, #b6d7e0);
        
      }

      th:first-child {
        border-top-left-radius: 10px; 
      }

      th:last-child {
        border-top-right-radius: 10px;
        border-right: none;
      }


      tr {
        border-top: 1px solid #000000;
        border-bottom: 1.5px solid #000000;
        color: #432d27;
        font-size: 16px;
        font-weight: normal;
        text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
      }

      tr:hover td {
        background: linear-gradient(to bottom, #216f86, #74b5c7);
        color: #ffffff;
        border-top: 1px solid #274873;
      }


      tr:first-child {
        border-top: none;
      }

      tr:last-child {
        border-bottom: none;
      }



      tr:nth-child(odd):hover td {
        background: linear-gradient(to bottom, #216f86, #74b5c7);
      }

      tr:last-child td:first-child {
        border-bottom-left-radius: 20px; 
      }

      tr:last-child td:last-child {
        border-bottom-right-radius: 20px;
      }
      /* Actions column */
      td:nth-child(3) {
          text-align: center;
        }

      td {
        background: rgb(255, 255, 255, 0.1);
        padding: 20px;
        vertical-align: middle;
        font-weight: 300;
        font-size: 18px;
        text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
        border-right: 1px solid #1e5b51;
      }

      td:last-child {
        border-right: none;
      }
</style>
