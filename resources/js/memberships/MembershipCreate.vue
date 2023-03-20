<template>
    <PublicLayout>
        <div class="wave"></div>
        <div class="container">
            <section id="section-register">
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <h1 class="title fw-normal text-white">Isi Data Diri</h1>
                    </div>
                </div>
                <div class="row membership-register-form">
                    <div class="col-12">
                        <div class="card border border-2 shadow p-3">
                            <div class="card-body">
                                <p class="card-title title-main">Silakan masukkan data diri sesuai kartu identitas Anda dengan lengkap dan benar</p>
                                <form :class="{ 'was-validated': formIsValid }">                                    
                                    <div class="mb-3">
                                      <input type="text" v-model="formField.name" class="form-control" placeholder="Nama Lengkap" required>
                                    </div>
                                    <div class="mb-3">
                                      <input type="email" v-model="formField.email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="mb-3">
                                      <input type="text" v-model="formField.phone" class="form-control" placeholder="Nomor Hp" required>
                                    </div>
                                    <div class="mb-5">
                                      <input type="text" v-model="formField.phone2" class="form-control" placeholder="Nomor Hp Alternatif(Optional)" required>
                                    </div>

                                    <p class="card-title title-main">Alamat Pemasangan</p>
                                    <p class="card-title title-sub">Masukkan alamat pemasangan yang sesuai untuk membantu kami menemukan lokasi Pemasangan.</p>
                                    <div class="mb-3">
                                      <input type="text" v-model="formField.province" class="form-control" placeholder="Provinsi" required>
                                    </div>
                                    <div class="mb-3">
                                      <input type="text" v-model="formField.city" class="form-control" placeholder="Kabupaten Kota" required>
                                    </div>
                                    <div class="mb-3">
                                      <textarea class="form-control" v-model="formField.detailAddress" placeholder="Detail Alamat" required></textarea>
                                    </div>

                                    <p class="card-title title-main">Titik Lokasi</p>
                                    <div class="mb-3 row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" v-model="formField.coordinate" placeholder="Cari Lokasi" required>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-crimson search">Cari</button>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <div class="map">
                                            <iframe src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=udinus;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" class="location" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>    
                                    </div>
                                    <div class="mb-3">
                                        
                                        <button v-if="registration==='confirmation'" @click="confirmation" type="button" class="btn btn-white fs-5 fw-bold" :disabled="submitting">
                                            <span v-if="submitting" class="spinner-border spinner-border-sm"></span>
                                            <i class="fas fa-chevron-circle-right"></i> {{ buttonText }} 
                                        </button>

                                        <button v-if="registration==='register'" @click="register" class="btn btn-crimson fs-5 fw-bold" :disabled="submitting">
                                            <span v-if="submitting" class="spinner-border spinner-border-sm"></span>
                                            {{ buttonText }}
                                        </button>

                                    </div>
                                    <div v-if="registration==='success'" class="alert alert-primary text-center fw-bold" role="alert">
                                        <i class="fas fa-check-circle"></i> Registrasi Sukses, Data Anda Sudah Kami Terima
                                    </div>
                                    <div v-if="isFormEmpty" class="alert alert-danger text-center fw-bold" role="alert">
                                        <i class="fas fa-exclamation-circle"></i> Masukan Data Dengan Benar!
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
        </div>
    </PublicLayout>
</template>


<script>

import PublicLayout from '../components/Public_Layout.vue';
import axios from 'axios'
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default {
    name: 'MembershipCreate',
    extends: PublicLayout,
    setup() {
        const route = useRoute();
        const router = useRouter();
        const serviceID = route.params.id;
        const service = ref([]);

        const formField = ref({
            email: '',
            phone: '',
            phone2: '',
            province: '',
            city: '',
            detailAddress: '',
            coordinate: '',
            service_id: serviceID
        });
        const formIsValid = ref(false);
        const isFormEmpty = ref();

        const buttonText = ref('Register');
        const submitting = ref(false);
        const registration = ref('register');

        const fetchService = async () => {
            try {
                const response = await axios.get(`/api/services/${serviceID}`, formField);
                service.value = response.data;
            } catch (error) {
                console.log()
                console.error(error);
                console.clear();
                router.push('/');

            }
        };

        const register = async () => {
            submitting.value = true;
            buttonText.value = "Checking..."
            
            const isAnyFieldEmpty = () => {
                return Object.values(formField.value).some(value => value === '');
            };

            if (!isAnyFieldEmpty()){
                formIsValid.value = true;
                isFormEmpty.value = false;
                try {
                    const response = await axios.get(`/api/services/${serviceID}`, formField);
                    service.value = response.data;
                    registration.value = 'confirmation';
                    buttonText.value = "Klik Untuk Konfirmasi!"
                } catch (error) {
                    console.error(error);
                    buttonText.value = "Register"
                }
            }else{
                formIsValid.value = false;
                isFormEmpty.value = true;
                console.log('form not valid');
                buttonText.value = "Register"

            }
            submitting.value = false;
        };

        const confirmation = async () =>{
            submitting.value = true;
            buttonText.value = "Loading..."
            const isAnyFieldEmpty = () => {
                return Object.values(formField.value).some(value => value === '');
            };

            if (!isAnyFieldEmpty()){
                formIsValid.value = true;
                isFormEmpty.value = false;
                const newMember = {
                    name : formField.value.name,
                    email : formField.value.email,
                    phone : formField.value.phone,
                    phone2 : formField.value.phone2,
                    province : formField.value.province,
                    city : formField.value.city,
                    detailAddress : formField.value.detailAddress,
                    coordinate : formField.value.coordinate,
                    service_id : formField.value.service_id
                }
                try {
                    const response = await axios.post(`/api/memberships`, newMember);
                    service.value = response.data;
                    registration.value = 'success';
                    buttonText.value = "Success"
                } catch (error) {
                    console.error(error);
                    buttonText.value = "Register"
                }
            }else{
                buttonText.value = "Register"
                registration.value = 'register';
                formIsValid.value = true;
                isFormEmpty.value = true;
            }
            submitting.value = false;
        }

        onMounted(() => {
            fetchService();
            
        });
        return {service, formField, formIsValid, buttonText, submitting, registration, register, confirmation, isFormEmpty}
    }
}
</script>

<style>
/* App-wide styles go here */
</style>