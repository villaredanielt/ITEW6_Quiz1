<template>
    <NavBar></NavBar>
    <div class="container">
        <div class="background-image"></div>
        <h1>Create New Post</h1>
        <form @submit.prevent="createPost">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" v-model="title" class="form-control" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" v-model="body" id="body" name="body" rows="5"></textarea>
            </div>
            <div class="button-container">
                <router-link to="/home" class="btn-back">Back</router-link>
                <button type="submit" class="btn-submit">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import NavBar from '@/components/NavBar.vue'
export default {
    components: {
        NavBar
    },
    data() {
        return {
            title: '',
            body: '',
            errors: {}
        };
    },

    methods: {
        async createPost() {
            try {
                const response = await axios.post("http://127.0.0.1:8000/api" + '/create', {
                    title: this.title,
                    body: this.body
                });

                if(response.status == 201){
                    this.title = '';
                    this.body = '';
                    this.$router.go(-1);
                }
                
            } catch (error) {
                alert("Something went wrong. Please try again!")
            }
        }
    }
}

</script>
<style scoped>

.container {
  position: relative;
  margin-top: 10%;
  width: 100%;
  flex-direction: column;
  justify-content: center; 
  align-items: center;
  box-sizing: border-box; 
  padding: 20px;
  overflow: hidden; 
}


.background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://i.pinimg.com/originals/16/69/e5/1669e57761ccc67fa5e31a09a54764d0.gif');
            background-size: cover;
            background-position: center;
            z-index: -1;
            overflow: hidden;
            filter: blur(3px); 
            &::before {
                content: '';
                position: absolute;
                top: 0;
                 left: 0;
                width: 100%;
                height: 100%; 
                background-color: rgba(255, 255, 255, 0.2); 
                z-index: -1;
                }
            }

    .h1, h1, .form-group {
    
    color: #ffffff;
    }

    /*buttons*/
    .button-container {
        display: flex;
        justify-content: flex-start;
        margin-top: 20px;
        }

     .btn-back, .btn-submit {
        font-size: 19px;
        padding: 10px;
        border-radius: 15px;
        box-shadow: rgba(45, 35, 66, 0.5) 0 2px 4px, rgba(45, 35, 66, 0.5) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
        border: none;
        color: white;
        cursor: pointer;
        border: 1px solid #000000;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-right: 10px;
        margin-bottom: 100px;
        }

    .btn-back {
        background-color: #6a6767;
        }

     .btn-back:hover {
        background: linear-gradient(to bottom, #6a6767, white);
        color: black;
        border: 1px solid #6a6767;
        transform: scale(1.02);
        }

    .btn-submit {
        background-color: #0096c7;
        }

     .btn-submit:hover {
        background: linear-gradient(to bottom, #0096c7, white);
        color: black;
        border: 1px solid #0096c7;
        transform: scale(1.02);
        }
</style>