<template>
    <PrivateLayout>
        <div class="container-fluid">
            <div class="page-header pt-3">
                <h2>Dashboard</h2>
            </div>
            <p class="lead">Daftar Registrasi Pelanggan</p>
            <hr>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col" class="d-none d-sm-table-cell">Email</th>
                                <th scope="col" class="d-none d-md-table-cell">Hp</th>
                                <th scope="col" class="d-none d-xl-table-cell">Kota</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(membership, index) in memberships" :key="membership.id">
                                <th scope="row">{{ index + 1 }}</th>
                                <td @click="selectMembership(membership)">
                                    <a href="#" class="text-crimson">{{membership.name}}</a>
                                </td>
                                <td>{{membership.email}}</td>
                                <td class="d-none d-md-table-cell">{{membership.phone}}</td>
                                <td class="d-none d-xl-table-cell">{{membership.city}}</td>
                                
                                <td class="text-center">
                                    <a href="#" class="text-danger" @click="deleteMembership(membership)">
                                        <i class="fas fa-window-close"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="modalMembership">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-xxl-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-address-card"></i> Data Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="loadingMembershipData">
                            <div class="spinner-border text-crimson" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div v-else>
                            <div v-if="membership">
                                <div class="row mb-3">
                                    <div class="col-3 fw-bold">Nama:</div>
                                    <div class="col-9">{{membership.name}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 fw-bold">Email:</div>
                                    <div class="col-9">{{membership.email}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 fw-bold">Hp:</div>
                                    <div class="col-9">{{membership.phone}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 fw-bold">Hp2:</div>
                                    <div class="col-9">{{membership.phone2}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 fw-bold">Provinsi:</div>
                                    <div class="col-9">{{membership.province}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 fw-bold">Kota:</div>
                                    <div class="col-9">{{membership.city}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 fw-bold">Alamat Detail:</div>
                                    <div class="col-9">{{membership.detailAddress}}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3 fw-bold">Registrasi Layanan Paket:</div>
                                    <div class="col-6">
                                        <ul v-if="membership.service">
                                            <li>{{membership.service.name}}</li>
                                            <li>Rp. {{membership.service.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}} / {{membership.service.duration}}</li>
                                            <li>{{membership.service.internetSpeed}}</li>
                                            <li>{{membership.service.device}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="modalDeleteMembership">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-crimson text-white">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Hapus Paket Data Pelanggan?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <form @submit.prevent="formDeleteMembership" class="form-modified">
                            <div class="mb-3" v-if="fieldDeleteMembership">
                                <h1>{{fieldDeleteMembership.name}}</h1>
                            </div>
                            <button v-if="deleteSuccessful===''" class="btn btn-light fs-5 fw-bold" :disabled="buttonFormDeleteMembership">
                                <span v-if="buttonFormDeleteMembership" class="spinner-border spinner-border-sm"></span>
                                {{ buttonTextFormDeleteMembership }}
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

export default {
    name: 'Dashboard',
    extends: PrivateLayout,
    setup(){

        const memberships = ref([]);
        const membership = ref()
        const loadingMembershipData = ref(true);
        const fetchMemberships = async () => {
            try {
                const response = await axios.get('/api/memberships', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                });
                memberships.value = response.data;
            } catch (error) {
                console.error(error);
            }
        };

        const modalMembership = ref(null);
        const selectMembership = async (selectedMembership) => {
            loadingMembershipData.value = true;
            membership.value = selectedMembership
            new bootstrap.Modal(modalMembership.value).show();
            try {
                const response = await axios.get(`/api/services/${membership.value.service_id}`, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                });
                membership.value.service = response.data;
                if(membership.value.service.category_internet){
                    const categoryID = membership.value.service.category_internet.split(',')[0];
                    try{
                        const response = await axios.get(`/api/categories/${categoryID}`, {
                            headers: {
                                Authorization: 'Bearer ' + localStorage.getItem('token'),
                            }
                        });
                        membership.value.service.internetSpeed = response.data.name;
                    } catch (error) {
                        console.error(error);
                    }
                }else{
                    console.log('else')
                }
                if(membership.value.service.category_device){
                    const categoryID = membership.value.service.category_device.split(',')[0];
                    try{
                        const response = await axios.get(`/api/categories/${categoryID}`, {
                            headers: {
                                Authorization: 'Bearer ' + localStorage.getItem('token'),
                            }
                        });
                        membership.value.service.device = response.data.name;
                    } catch (error) {
                        console.error(error);
                    }
                }
                loadingMembershipData.value = false;
            } catch (error) {
                console.error(error);
            }
        };


// ========================= MODAL DELETE MEMBERSHIP
        const modalDeleteMembership = ref(null);
        const fieldDeleteMembership = ref([]);
        const buttonTextFormDeleteMembership = ref('Delete');
        const buttonFormDeleteMembership = ref(false);
        const deleteSuccessful = ref('');
        const deleteMembership = (membership) => {
            fieldDeleteMembership.value = membership;
            new bootstrap.Modal(modalDeleteMembership.value).show();
        }

        const formDeleteMembership = async () => {
            buttonFormDeleteMembership.value = true;
            buttonTextFormDeleteMembership.value = "Loading..."
            try {
                const response = await axios.delete(`/api/memberships/${fieldDeleteMembership.value.id}`, {
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
                buttonTextFormDeleteMembership.value = 'Delete';
            }
        };

        onMounted(() => {
            fetchMemberships(); 
        });

        return {
            memberships, membership, selectMembership, modalMembership, loadingMembershipData,
            modalDeleteMembership, fieldDeleteMembership, buttonTextFormDeleteMembership, buttonFormDeleteMembership, deleteSuccessful, deleteMembership, formDeleteMembership
        }

    }
}
</script>

<style>
/* App-wide styles go here */
</style>
