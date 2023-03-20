<template>
    <PrivateLayout>
        <div class="container-fluid">
            <div class="page-header pt-3">
                <h2>Settings</h2>
            </div>
            <p class="lead">Edit user.</p>
            <hr>

            <div class="container mt-5">
            <div class="row">
               
                <div class="col-md-4">
                    <form class="row g-3 form-modified" @submit.prevent="formUpdateUser" :class="{ 'was-validated': formEditIsValid }">
                        
                        <div class="">
                            <label for="username" class="form-label">New Username</label>
                            <input type="text" v-model="fieldEditUser.username" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="chrome-off" required>
                            <div class="invalid-feedback">
                                Enter Username!
                            </div>
                        </div>
                        <div class="">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" v-model="fieldEditUser.password" class="form-control" aria-describedby="inputGroupPrepend" autocomplete="new-password" required>
                            <div class="invalid-feedback">
                                Enter Password!
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <button class="btn btn-crimson fs-5 fw-bold" :disabled="submitting">
                                <span v-if="submitting" class="spinner-border spinner-border-sm"></span>
                                {{ buttonText }}
                            </button>
                        </div>
                    </form>
                    <div class="mt-5">
                        <h1 v-if="editSuccessful==='True'" class="text-primary fw-bold"><i class="fas fa-check-circle"></i> Success</h1>
                        <h1 v-if="editSuccessful==='False'" class="text-crimson fw-bold"><i class="fas fa-times-circle"></i> Failed</h1>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </PrivateLayout>
</template>

<script>
    import PrivateLayout from '../components/Private_Layout.vue';
    import axios from 'axios'
    import {onMounted, ref } from 'vue';

export default {
    name: 'Settings',
    extends: PrivateLayout,
    setup() {

        const submitting = ref(false);
        const errorMessage = ref(null);
        const buttonText = ref("Update");
        const formEditIsValid = ref(false);
        const editSuccessful = ref('');
        const fieldEditUser = ref([]);
        const fetchUser = async () => {
            try {
                const response = await axios.get('/api/authentication/1', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                });
                fieldEditUser.value = response.data;
            } catch (error) {
                console.error(error);
            }
        };

        const formUpdateUser = async () => {
            console.log(fieldEditUser.value)
            submitting.value = true;
            
            buttonText.value = 'Loading...'


            if (fieldEditUser.value.username && fieldEditUser.value.password) {
                formEditIsValid.value = true;
                const userData = {
                    username : fieldEditUser.value.username,
                    password : fieldEditUser.value.password,
                }
                try {
                    const response = await axios.put('/api/authentication/1', userData, {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token'),
                        }
                    });
                    editSuccessful.value = 'True'
                    console.log('success')
                } catch (error) {
                    console.log(error);
                    editSuccessful.value = 'False'
                    errorMessage.value = error;
                }
                
            }else {
                console.log('im here')
                formEditIsValid.value = false;
            }
            submitting.value = false;
            buttonText.value = 'Update'
            
        };
        onMounted(() => {
            fetchUser();
            
        });

        return {
            fieldEditUser, submitting, buttonText, errorMessage, formUpdateUser, formEditIsValid, editSuccessful

        }

    }
}
</script>

<style>
/* App-wide styles go here */
</style>
