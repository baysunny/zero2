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
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Paket Internet</th>
                                <th colspan="2" class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(service, index) in indexedServices" :key="service.id">
                                <th scope="row">{{ index + 1 }}</th>
                                <td @click="selectService(service)" class="text-crimson text-decoration-underline">{{service.name}}</td>
                                <td class="text-center">
                                    <a href="#" class="text-primary" @click="editService(service)">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-danger" @click="deleteService(service)">
                                        <i class="fas fa-window-close"></i>
                                    </a>
                                </td>
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
                            <p class="card-text internet">internet</p>
                            <p class="card-text device">{{selectedService.device}}</p>
                            <p class="card-text speed">Up To {{selectedService.internetSpeed}}</p>
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
                                <label>Kategori(Kecepatan Internet)</label>


                                <vue3-tags-input v-model:tags="selectedInternetSpeedTags"
                                    v-model="tag"
                                    :select="true"
                                    :select-items="category_internetSpeed"
                                    @on-select="handleSelectedInternetSpeedTag"
                                    @on-tags-changed="handleChangeInternetSpeedTag"
                                    placeholder="Select the tag">
                                    <template #item="{ tag, index }">
                                        {{ tag.text }}
                                    </template>
                                    <template #no-data>
                                        No Data
                                    </template>
                                    <template #select-item="tag">
                                        {{ tag.text }}
                                    </template>
                                </vue3-tags-input>
                            </div>

                            <div class="mb-3">
                                <label>Kategori(Layanan)</label>
                                <vue3-tags-input v-model:tags="selectedDeviceTags"
                                    v-model="tag"
                                    :select="true"
                                    :select-items="category_device"
                                    @on-select="handleSelectedDeviceTag"
                                    @on-tags-changed="handleChangeDeviceTag"
                                    placeholder="Select the tag">
                                    <template #item="{ tag, index }">
                                        {{ tag.text }}
                                    </template>
                                    <template #no-data>
                                        No Data
                                    </template>
                                    <template #select-item="tag">
                                        {{ tag.text }}
                                    </template>
                                </vue3-tags-input>


                                
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
                <div class="modal-content bg-crimson text-white">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Hapus Paket Layanan?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <form @submit.prevent="formDeleteService" class="form-modified">
                            <div class="mb-3" v-if="fieldDeleteService">
                                <h1>{{fieldDeleteService.name}}</h1>
                            </div>
                            <button v-if="deleteSuccessful===''" class="btn btn-crimson fs-5 fw-bold" :disabled="buttonFormDeleteService">
                                <span v-if="buttonFormDeleteService" class="spinner-border spinner-border-sm"></span>
                                {{ buttonTextFormDeleteService }}
                            </button>
                        </form>
                        <div>
                            <h1 v-if="deleteSuccessful==='True'" class="text-white fw-bold"><i class="fas fa-check-circle"></i> Success</h1>
                            <h1 v-if="deleteSuccessful==='False'" class="text-danger fw-bold"><i class="fas fa-times-circle"></i> Failed</h1>
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
import {reactive, onMounted, ref } from 'vue';
import Vue3TagsInput from 'vue3-tags-input';

export default {
    name: 'Services',
    components: {
        PrivateLayout,
        Vue3TagsInput
    },
    computed: {
        indexedServices() {
            return this.services.map((service, index) => ({ ...service, index }));
        },
        availableOptions() {
            return this.options.filter(opt => this.value.indexOf(opt) === -1)
        },

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
            } catch (error) {
                console.error(error);
            }
        };

        const fetchCategories = async () => {
            try {
                const response = await axios.get('/api/categories', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                });
                category_internetSpeed.value = response.data.filter(category => category.category_type === 'internet speed');
                category_device.value = response.data.filter(category => category.category_type === 'devices');

                console.log('successfully : fetchCategories()')
                
                // fetching category_internet in service.internetSpeed (only first tag)
                for (let i = 0; i < services.value.length; i++) {
                    if(services.value[i].category_internet){
                        // handling if service_internetTag got deleted in categories, the move the next service_internetTag
                        // example (1,2,3), 1 got deleted, we move to 2 until the tags are gone disappeared eaten by blackhole
                        const service_internetTags = services.value[i].category_internet.split(',');
                        for (let j = 0; j< service_internetTags.length; j++){
                            const service_internetTag = service_internetTags[j];
                            const tagData = category_internetSpeed.value.find(tag => String(tag.id) === service_internetTag);
                            if(tagData){
                                services.value[i].internetSpeed = tagData.name;
                                break
                            }
                        }
                    }

                    if(services.value[i].category_device){
                        const service_deviceTags = services.value[i].category_device.split(',');
                        for (let j = 0; j< service_deviceTags.length; j++){
                            const service_deviceTag = service_deviceTags[j];
                            const tagData = category_device.value.find(tag => String(tag.id) === service_deviceTag);
                            if(tagData){
                                services.value[i].device = tagData.name;
                                break
                            }
                        }
                    }
                }
               
                
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
                    duration: fieldAddService.value.duration,
                    text: fieldAddService.value.name,
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
        

        const tag = ref('');
        const selectedInternetSpeedTags = ref([]);
        const selectedDeviceTags = ref([]);
        const category_internetSpeed = ref([]);
        const category_device = ref([]);


        const handleChangeInternetSpeedTag = (newtags) => {
            selectedInternetSpeedTags.value = newtags;
        }
        const handleSelectedInternetSpeedTag = (tag) => {
            selectedInternetSpeedTags.value.push(tag);
        }

        const handleChangeDeviceTag = (newtags) => {
            selectedDeviceTags.value = newtags;
        }
        const handleSelectedDeviceTag = (tag) => {
            selectedDeviceTags.value.push(tag);
        }


       
        const editService = (service) => {
            fieldEditService.value = service;

            // redefine for open/close another edit
            tag.value = '';
            selectedInternetSpeedTags.value = [];
            selectedDeviceTags.value = [];

            console.log(':::>>>',fieldEditService.value.category_internet)
            console.log('category_internetSpeed : ', category_internetSpeed.value);
            console.log('category_device : ', category_device.value);
            
            if(fieldEditService.value.category_internet){
                console.log('splitted: ', fieldEditService.value.category_internet.split(','))
                for (let i = 0; i < category_internetSpeed.value.length; i++) {
                  const tag = category_internetSpeed.value[i];

                  // check if ['id1', 'id2', ...] in category_internetSpeedIDs(in db)
                  const included = fieldEditService.value.category_internet.split(',').includes(String(tag.id));
                  console.log(`tag.text: ${tag.text}, tag.name: ${tag.name}, tag.id: ${tag.id}, included: ${included}`);
                  if (included) {
                    selectedInternetSpeedTags.value.push(tag);
                  }
                }
            }

            if(fieldEditService.value.category_device){
                console.log('splitted: ', fieldEditService.value.category_device.split(','))
                for (let i = 0; i < category_device.value.length; i++) {
                  const tag = category_device.value[i];

                  // check if ['id1', 'id2', ...] in category_internetSpeedIDs(in db)
                  const included = fieldEditService.value.category_device.split(',').includes(String(tag.id));
                  console.log(`tag.text: ${tag.text}, tag.name: ${tag.name}, tag.id: ${tag.id}, included: ${included}`);
                  if (included) {
                    selectedDeviceTags.value.push(tag);
                  }
                }
            }
            
            new bootstrap.Modal(modalEditService.value).show();
        }
        const formEditService = async () => {
            buttonFormEditService.value = true;
            buttonTextFormEditService.value = "Loading..."
     
            const internetSpeedTagIDsToStore = ref('');
            for (const [key, tag] of Object.entries(selectedInternetSpeedTags.value)) {
                internetSpeedTagIDsToStore.value += tag.id + ',';
            }
            internetSpeedTagIDsToStore.value = internetSpeedTagIDsToStore.value.slice(0, -1)


            const deviceTagIDsToStore = ref('');
            for (const [key, tag] of Object.entries(selectedDeviceTags.value)) {
                deviceTagIDsToStore.value += tag.id + ',';
            }
            deviceTagIDsToStore.value = deviceTagIDsToStore.value.slice(0, -1)


            if(fieldEditService.value.name && fieldEditService.value.price && fieldEditService.value.duration){
                formEditIsValid.value = true;
                const serviceData = {
                    name: fieldEditService.value.name,
                    price: fieldEditService.value.price,
                    duration: fieldEditService.value.duration,
                    category_internet: internetSpeedTagIDsToStore.value,
                    category_device: deviceTagIDsToStore.value,
                };
                console.log('serviceData: ', serviceData);
                try {
                    const response = await axios.put(`/api/services/${fieldEditService.value.id}`, serviceData, {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token'),
                        }
                    });
                    editSuccessful.value = 'True';
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                    
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
            fetchCategories();
            
        });
        return {
            
            services,
            cardService, selectedService, selectService,
            modalAddService, fieldAddService, buttonTextFormAddService, formAddIsValid, buttonFormAddService, addSuccessful, addService, formAddService,
            modalEditService, fieldEditService, buttonTextFormEditService, formEditIsValid, buttonFormEditService, editSuccessful, editService, formEditService,

            tag, 
            category_internetSpeed, selectedInternetSpeedTags, handleChangeInternetSpeedTag, handleSelectedInternetSpeedTag, 
            category_device, selectedDeviceTags, handleChangeDeviceTag, handleSelectedDeviceTag,

            modalDeleteService, fieldDeleteService, buttonTextFormDeleteService, buttonFormDeleteService, deleteSuccessful, deleteService, formDeleteService
        };
    },
};
</script>

<style>
/* App-wide styles go here */
</style>
