<template>
    <PublicLayout><div class="wave"></div>
  	    <div class="container mt-5" style="margin-bottom:700px"> 
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-danger" v-if="errorMessage" role="alert">
                        {{errorMessage}}
                    </div>
                </div>
                <div class="col-md-4">
                    <form class="row g-3" @submit.prevent="login" ref="form">
                        
                        <div class="">
                            <label for="username" class="form-label text-white">Username</label>
                            <input type="text" v-model="username" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="chrome-off" required>
                            <div class="invalid-feedback">
                                Enter Username!
                            </div>
                        </div>
                        <div class="">
                            <label for="password" class="form-label text-white">Password</label>
                            <input type="password" v-model="password" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="new-password" required>
                            <div class="invalid-feedback">
                                Enter Password!
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <button class="btn btn-crimson fs-5 fw-bold" :disabled="submitting" @click="login">
                                <span v-if="submitting" class="spinner-border spinner-border-sm"></span>
                                {{ buttonText }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<script>
    import PublicLayout from '../components/Public_Layout.vue';
  	import axios from 'axios';
  	
  	export default {
        extends: PublicLayout,

		data() {
  		  return {
	            username: "",
                password: "",
                submitting: false,
                errorMessage: null,
                buttonText: "Login"
  		  };
		},
		methods: {
      	
  		    login() {
                if (this.$refs.form.checkValidity()) {
                    this.submitting = true;
                    this.buttonText = "Loading...";
                    const credentials = {
                        username: this.username,
                        password: this.password,
                    };
                    axios.post('/api/authentication/login', credentials).then((response) => {
                        const token = response.data.token;
                        localStorage.setItem('token', token);

                        this.$router.push('/dashboard');
                    }).catch((error) => {
                        
                        this.errorMessage = error.response.data.message;
                        if (error.response) {
                            // The request was made and the server responded with a status code
                            // that falls out of the range of 2xx
                            if(error.response.status == 500){
                                this.errorMessage = 'An error occured. Please try again later';
                            }
                            console.log(error.response.data.message);
                            console.log(error.response.status);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                        
                        console.log(error.config);console.clear();
                    }).finally(() => {
                        this.submitting = false;
                        this.buttonText = "Login";
                        setTimeout(() => {
                            this.errorMessage = '';
                        }, 3000);
                    });
                } else {
                    this.$refs.form.classList.add("was-validated");
                }
            }
		}
  	}; 
</script>

<style scoped>

</style>