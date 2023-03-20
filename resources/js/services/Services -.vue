<template>
    <PrivateLayout>
        <div class="container-fluid">
            <div class="page-header pt-3">
                <h2>Paket Internet</h2>
            </div>
            <p class="lead text-warning"><i class="fas fa-exclamation-circle"></i> Silahkan edit Paket Internet untuk menambahkan paket kedalam kategori (Kecepatan Internet, Layanan)</p>
            <a href="#" class="btn btn-crimson" @click="addService"><i class="fas fa-plus"></i> Tambah Paket Internet</a>
            <hr>
            <div class="row">
                <div class="col-12 col-xl-8">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nama Paket Internet</th>
                          <th colspan="2" class="text-center" scope="col">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(service, index) in services" :key="service.id">
                          <td>{{ index + 1 }}</td>
                          <td @click="selectService(service)" class="text-crimson text-decoration-underline">{{service.name}}</td>
                          <td><a href="#" class="text-primary" @click="editService(service)">Edit</a></td>
                          <td><a href="#" class="text-danger" @click="deleteService(service)">Delete</a></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="card service mx-auto border border-2 shadow p-3" v-if="cardService">
                        <div class="card-body text-center" v-if="selectedService">
                            <p class="card-title title-1 mt-1">{{selectedService.name}}</p>
                            <p class="card-title title-2">Bundling Gameqoo Diskon Biaya PSB</p>
                            <p class="card-text detail">Detail paket</p>
                            <p class="card-text internet">Internet</p>
                            <p class="card-text speed">Up To 30Mbps</p>
                            <p class="card-text price">Rp. {{selectedService.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}} / {{selectedService.duration}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="modalAddService">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Paket Layanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="formAddService" class="form-modified" :class="{ 'was-validated': formAddIsValid }">
                            <div class="mb-3">
                                <label class="text-warning form-text-helper"><i class="fas fa-exclamation-circle"></i> contoh: Paket JITU 1 - 2P Inet TV</label>
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="name" placeholder="Nama Paket Layanan" required v-model="fieldAddService.name">
                                    <label for="name">Nama Paket Layanan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-warning form-text-helper"><i class="fas fa-exclamation-circle"></i> contoh: 390.000</label>
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="price" placeholder="Harga" required  v-model="fieldAddService.price">
                                    <label for="price">Harga</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-warning form-text-helper"><i class="fas fa-exclamation-circle"></i> contoh: (Bulan, Tahun). hasil : (390.000/Bulan)</label>
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="duration" placeholder="Masa Berlaku" required  v-model="fieldAddService.duration">
                                    <label for="duration">Masa Berlaku</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-crimson fs-5 fw-bold" :disabled="buttonFormAddService">
                                    <span v-if="buttonFormAddService" class="spinner-border spinner-border-sm"></span>
                                    {{ buttonTextFormAddService }}
                                </button>
                            </div>
                            
                        </form>
                        <div>
                            <h1 v-if="addSuccessful==='True'" class="text-success fw-bold"><i class="fas fa-check-circle"></i> Success</h1>
                            <h1 v-if="addSuccessful==='False'" class="text-danger fw-bold"><i class="fas fa-times-circle"></i> Failed</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="modalEditService">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Paket Layanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="formEditService" class="form-modified" :class="{ 'was-validated': formEditIsValid }">
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="name" placeholder="Nama Paket Layanan" required v-model="fieldEditService.name">
                                    <label for="name">Nama Paket Layanan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="price" placeholder="Harga" required  v-model="fieldEditService.price">
                                    <label for="price">Harga</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="duration" placeholder="Masa Berlaku" required  v-model="fieldEditService.duration">
                                    <label for="duration">Masa Berlaku</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Kategori</label>
                                <smart-tagz 
                                    input-placeholder="Masukan Kategori" 
                                    autosuggest
                                    editable
                                    :on-changed="onTagAdded"
                                    :sources="['aaa']"
                                    
                                    :default-tags="issfa"
                                    :allow-duplicates="false"
                                    :allow-paste="{delimiter: ','}"
                                    :theme="{
                                        primary: '#545454',
                                        background: '#bdbdbd',
                                        tagTextColor: '#fff',
                                    }"
                                    
                                />
                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-crimson fs-5 fw-bold" :disabled="buttonFormEditService">
                                    <span v-if="buttonFormEditService" class="spinner-border spinner-border-sm"></span>
                                    {{ buttonTextFormEditService }}
                                </button>
                            </div>
                        </form>
                        <div>
                            <h1 v-if="editSuccessful==='True'" class="text-success fw-bold"><i class="fas fa-check-circle"></i> Success</h1>
                            <h1 v-if="editSuccessful==='False'" class="text-danger fw-bold"><i class="fas fa-times-circle"></i> Failed</h1>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="modalDeleteService">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-danger text-white">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Hapus Paket Layanan?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <form @submit.prevent="formDeleteService" class="form-modified">
                            <div class="mb-3" v-if="fieldDeleteService">
                                <h1>{{fieldDeleteService.name}}</h1>
                            </div>
                            <button class="btn btn-crimson fs-5 fw-bold" :disabled="buttonFormDeleteService">
                                <span v-if="buttonFormDeleteService" class="spinner-border spinner-border-sm"></span>
                                {{ buttonTextFormDeleteService }}
                            </button>
                        </form>
                        <div>
                            <h1 v-if="deleteSuccessful==='True'" class="text-white fw-bold"><i class="fas fa-check-circle"></i> Success</h1>
                            <h1 v-if="deleteSuccessful==='False'" class="text-crimson fw-bold"><i class="fas fa-times-circle"></i> Failed</h1>
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
import {reactive, onMounted, ref } from 'vue';import { SmartTagz } from "smart-tagz";
import "smart-tagz/dist/smart-tagz.css";

export default {
    name: 'Services',
    components: {
        PrivateLayout,SmartTagz,
    },
    computed: {
        indexedServices() {
          return this.services.map((service, index) => ({ ...service, index }));
        },
        availableOptions() {
            return this.options.filter(opt => this.value.indexOf(opt) === -1)
        },
        issfa(){
        return this.internetSpeed;
        }
    },
    setup() {

        // fetch the services to display
        const services = ref([]);
        const fetchServices = async () => {
            try {
                const response = await axios.get('/api/services', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                });
                services.value = response.data;
                console.log('ser 1 : ', services.value)
            } catch (error) {
                console.error(error);
            }
        };

        // card detail
        const cardService = ref(false);
        const selectedService = ref(null);
        const selectService = (service) => {
            selectedService.value = service;
            cardService.value = true;
        };

        // ========================= MODAL ADD SERVICE
        const modalAddService = ref(null);
        const fieldAddService = ref([]);
        const buttonTextFormAddService = ref('Tambah');
        const formAddIsValid = ref(false);
        const buttonFormAddService = ref(false);
        const addSuccessful = ref('');
        const addService = () => {
            new bootstrap.Modal(modalAddService.value).show();
        };
        const formAddService = async () => {
            buttonFormAddService.value = true;
            buttonTextFormAddService.value = "Loading..."
            if(fieldAddService.value.name && fieldAddService.value.price && fieldAddService.value.duration){
                formAddIsValid.value = true;
                const serviceData = {
                    name: fieldAddService.value.name,
                    price: fieldAddService.value.price,
                    duration: fieldAddService.value.duration
                };
                try {
                    const response = await axios.post('/api/services', serviceData, {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token'),
                        }
                    });
                    addSuccessful.value = 'True';
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } catch (error) {
                    addSuccessful.value = 'False';
                    buttonFormAddService.value = false;
                    buttonTextFormAddService.value = 'Tambah';
                }
            }else{
                formAddIsValid.value = false;
                buttonFormAddService.value = false;
                buttonTextFormAddService.value = 'Tambah';
            } 
        };


        // ========================= MODAL EDIT SERVICE
        const modalEditService = ref(null);
        const fieldEditService = ref([]);
        const buttonTextFormEditService = ref('Save');
        const formEditIsValid = ref(false);
        const buttonFormEditService = ref(false);
        const editSuccessful = ref('');
        const internetSpeed = ref([]);
      
        const fieldCategories = reactive({
            internetSpeed: ref([]),
            devices: ref([]),
        });
        const onTagAdded = (tags) => {
            fieldCategories.internetSpeed.value = tags
        };
        const editService = (service) => {
            fieldEditService.value = service;
            console.log(internetSpeed.value)
            new bootstrap.Modal(modalEditService.value).show();
        }
        const formEditService = async () => {
            buttonFormEditService.value = true;
            buttonTextFormEditService.value = "Loading..."
            if(fieldEditService.value.name && fieldEditService.value.price && fieldEditService.value.duration){
                formEditIsValid.value = true;
                console.log('default : ', internetSpeed.value);
                const serviceData = {
                    name: fieldEditService.value.name,
                    price: fieldEditService.value.price,
                    duration: fieldEditService.value.duration
                };
                try {
                    const response = await axios.put(`/api/services/${fieldEditService.value.id}`, serviceData, {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token'),
                        }
                    });console.log('Selected tags:', fieldCategories.internetSpeed.value);
                    editSuccessful.value = 'True';
                    //setTimeout(() => {
                    //    location.reload();
                    //}, 1000);
                    buttonFormEditService.value = false;
                buttonTextFormEditService.value = 'Save'; 
                } catch (error) {
                    editSuccessful.value = 'False';
                    buttonFormEditService.value = false;
                    buttonTextFormEditService.value = 'Save';  
                }
            }else{
                formEditIsValid.value = false;
                buttonFormEditService.value = false;
                buttonTextFormEditService.value = 'Save';  
            } 
        };

        
        const fetchCategories = async () => {
            try {
                const response = await axios.get('/api/categories', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                });
                internetSpeed.value = response.data.filter(category => category.category_type === 'internet speed');
                fieldCategories.devices.value = response.data.filter(category => category.category_type === 'devices');
                console.log('successfully load categories')
                console.log('is 1: ', internetSpeed.value)
            } catch (error) {
                console.error(error);
            }
        };

        // ========================= MODAL DELETE SERVICE
        const modalDeleteService = ref(null);
        const fieldDeleteService = ref([]);
        const buttonTextFormDeleteService = ref('Delete');
        const buttonFormDeleteService = ref(false);
        const deleteSuccessful = ref('');
        const deleteService = (service) => {
            fieldDeleteService.value = service;
            new bootstrap.Modal(modalDeleteService.value).show();
        }

        const formDeleteService = async () => {
            buttonFormDeleteService.value = true;
            buttonTextFormDeleteService.value = "Loading..."
            try {
                const response = await axios.delete(`/api/services/${fieldDeleteService.value.id}`, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                });
                deleteSuccessful.value = 'True';
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } catch (error) {
                deleteSuccessful.value = 'False';
                buttonTextFormDeleteService.value = 'Delete';
            }
        };
    
        onMounted(() => {
            fetchServices();
            console.log('ser : ', services.value)
            fetchCategories();
            console.log('is : ', internetSpeed.value)
            
        });
        return {
            services, fieldCategories, onTagAdded, internetSpeed, 
            cardService, selectedService, selectService,
            modalAddService, fieldAddService, buttonTextFormAddService, formAddIsValid, buttonFormAddService, addSuccessful, addService, formAddService,
            modalEditService, fieldEditService, buttonTextFormEditService, formEditIsValid, buttonFormEditService, editSuccessful, editService, formEditService,
            modalDeleteService, fieldDeleteService, buttonTextFormDeleteService, buttonFormDeleteService, deleteSuccessful, deleteService, formDeleteService
        };
    },
};
</script>

<style>
/* App-wide styles go here */
</style>
