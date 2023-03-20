<template>
    <PublicLayout>
        <div class="wave"></div>
        <div class="container">
            <section id="section-hero" class="mb-4">
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <h1 class="title fw-normal text-white">Selamat Datang di IndiHome</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        
                        <div id="myCarousel" class="carousel carousel-main slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>

                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="container">
                                        <div class="row">
                                            <img src="/img/carousel-1.png" style="object-fit: cover;" alt="Slide 1">
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="container">
                                        <div class="row">
                                            <img src="/img/carousel-1.png" style="object-fit: cover;" alt="Slide 2">
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="container">
                                        <div class="row">
                                            <img src="/img/carousel-1.png" style="object-fit: cover;" alt="Slide 3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <section id="section-service" class="mb-4">
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <h1 class="title">Layanan</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11 col-12 mx-auto text-center">
                        <div class="card services">
                            <div class="card-body my-5" v-if="isLoadingService">
                                <div class="spinner-border text-crimson" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <div class="card-body" v-else>
                                <div class="row mb-4">
                                    <h2 class="card-title">Pilihan Paket IndiHome</h2>
                                    <h5 class="card-title">Silahkan pilih paket yang Anda inginkan</h5>
                                </div>
                                <div class="row main-option mb-3">
                                    <div class="col text-center">      
                                        <a 
                                            @click="updateselectedInternetSpeedTags(internet.name)"
                                            :class="[isInternetSpeedTagSelected(internet.name) ? 'filter-btn-crimson' : 'btn-crimson-reverse', 'btn', 'm-1']" 
                                            v-for="(internet, index) in category_internetSpeed" :key="internet.id">
                                                {{internet.name}}
                                        </a>
                                    </div>
                                </div>
                                <div class="row sub-option mb-5">
                                    <div class="col text-center">
                                        <a 
                                            @click="updateSelectedDeviceTags(device.name)"
                                            :class="[isDeviceTagSelected(device.name) ? 'filter-btn-crimson' : 'btn-crimson-reverse', 'btn', 'm-1']" 
                                            v-for="(device, index) in category_device" :key="device.id">
                                                {{device.name}}
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-lg-6 col-xl-4 mb-4 d-flex" v-for="(service, index) in filteredServices" :key="service.id">
                                        <div class="card mx-auto border border-2 shadow p-3 service">
                                            <div class="card-body">
                                                <p class="card-title title-1 mt-1">{{service.name}}</p>
                                                <p class="card-title title-2">Bundling Gameqoo Diskon Biaya PSB</p>
                                                <p class="card-text detail">Detail paket</p>
                                                <p class="card-text internet">internet</p>
                                                <p class="card-text speed">{{service.internetSpeedToDisplay}}</p>
                                                <p class="card-text price">Rp. {{service.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}}/{{service.duration}}</p>
                                                <router-link :to="{ name: 'membershipCreate', params: { id: service.id } }" class="btn btn-crimson mt-3">Pilih Paket</router-link>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </section>
        </div>
        
    </PublicLayout>
</template>

<script>

import PublicLayout from './components/Public_Layout.vue';
import axios from 'axios'
import {onMounted, ref, computed } from 'vue';

export default {
    name: 'Home',
    extends: PublicLayout,
    setup() {
        const isLoadingService = ref(true);
        const services = ref([]);
        const fetchServices = async () => {
            try {
                const response = await axios.get('/api/services');
                services.value = response.data;
                console.log('successfully : fetchServices()')
            } catch (error) {
                console.error(error);
            }
        };

        const category_internetSpeed = ref([]);
        const category_device = ref([]);
        const fetchCategories = async () => {
            try {
                const response = await axios.get('/api/categories');
                category_internetSpeed.value = response.data.filter(category => category.category_type === 'internet speed');
                category_device.value = response.data.filter(category => category.category_type === 'devices');

                console.log('successfully : fetchCategories()')
                
                for (let i = 0; i < services.value.length; i++) {

                    services.value[i].internetSpeedTagNames = [];

                    if(services.value[i].category_internet){
                        const service_internetSpeedTags = services.value[i].category_internet.split(',');
                        for (let j = 0; j< service_internetSpeedTags.length; j++){
                            const service_internetSpeedTag = service_internetSpeedTags[j];
                            const tagData = category_internetSpeed.value.find(tag => String(tag.id) === service_internetSpeedTag);
                            if(tagData){
                                services.value[i].internetSpeedTagNames.push(tagData.name);
                                services.value[i].internetSpeedToDisplay = tagData.name;
                            }
                        }
                    }
                    services.value[i].deviceTagNames = [];
                    if(services.value[i].category_device){   
                        const service_deviceTags = services.value[i].category_device.split(',');
                        for (let j = 0; j< service_deviceTags.length; j++){
                            const service_deviceTag = service_deviceTags[j];
                            const tagData = category_device.value.find(tag => String(tag.id) === service_deviceTag);
                            if(tagData){
                                services.value[i].deviceTagNames.push(tagData.name);
                                services.value[i].deviceToDisplay = tagData.name;
                            }
                        }

                    }
                    isLoadingService.value = false;
                }
            } catch (error) {
                console.error(error);
            }
        };
        onMounted(async () => {
            await fetchServices()
            await fetchCategories();
            
        });

        
        const selectedInternetSpeedTags = ref([]);
        const updateselectedInternetSpeedTags = (tagName) => {
            const index = selectedInternetSpeedTags.value.indexOf(tagName);
            if (index === -1) {
                selectedInternetSpeedTags.value.push(tagName);
            } else {
                selectedInternetSpeedTags.value.splice(index, 1);
            }
        }
        const isInternetSpeedTagSelected = (tagName) => {
            return selectedInternetSpeedTags.value.includes(tagName);
        };

        const selectedDeviceTags = ref([]);
        const updateSelectedDeviceTags = (tagName) => {
            const index = selectedDeviceTags.value.indexOf(tagName);
            if (index === -1) {
                selectedDeviceTags.value.push(tagName);
            } else {
                selectedDeviceTags.value.splice(index, 1);
            }
        }
        const isDeviceTagSelected = (tagName) => {
            return selectedDeviceTags.value.includes(tagName);
        };

        const filteredServices = computed(() => {
            console.log('===================================================================')
            return services.value.filter(service => {
                console.log('============')
                console.log('service: ', service.name)
                console.log('service.deviceTagNames: ', service.deviceTagNames)
                console.log('service.internetSpeedTagNames: ', service.internetSpeedTagNames)
                console.log('filter(device) : ', selectedDeviceTags.value)
                console.log('filter(internetSpeed) : ', selectedInternetSpeedTags.value)

                if (
                  (selectedDeviceTags.value.length > 0 && service.deviceTagNames) &&
                  (selectedInternetSpeedTags.value.length > 0 && service.internetSpeedTagNames)
                ) {
                  return (
                    selectedDeviceTags.value.every(device => service.deviceTagNames.includes(device)) &&
                    selectedInternetSpeedTags.value.every(internet => service.internetSpeedTagNames.includes(internet))
                  )
                }
                
                else if (selectedDeviceTags.value.length > 0 && service.deviceTagNames) {
                    return selectedDeviceTags.value.every(device => service.deviceTagNames.includes(device));
                }

                else if (selectedInternetSpeedTags.value.length > 0 && service.internetSpeedTagNames) {
                    return selectedInternetSpeedTags.value.every(internet => service.internetSpeedTagNames.includes(internet));
                }



    

                return true;
            });
        });



        
        return { 
            isLoadingService, services, category_internetSpeed, category_device,
            updateselectedInternetSpeedTags, isInternetSpeedTagSelected,
            updateSelectedDeviceTags, isDeviceTagSelected,
            filteredServices

        }
    }
}
</script>

<style>
/* App-wide styles go here */
</style>
