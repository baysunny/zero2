<template>
    <PrivateLayout>
        <div class="container-fluid">
            <div class="page-header pt-3">
                <h2>Kategori</h2>
            </div>
            <p class="lead text-warning"><i class="fas fa-exclamation-circle"></i> Setelah menambahkan kategori, masukan <span class="text-danger text-decoration-underline">Paket Internet</span> kedalam kategori dengan cara <span class="text-danger text-decoration-underline">edit</span> Paket Internet</p>
            <a href="#" class="btn btn-crimson" @click="addCategory"><i class="fas fa-plus"></i> Tambah Kategori</a>
            <hr>
            <hr>
            <div class="row">
                <div class="col-12 col-xl-8">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kecepatan Internet</th>
                                <th colspan="2" class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category, index) in categories.category_internetSpeed.value" :key="category.id">
                                <th scope="row">{{index+1}}</th>
                                <td class="text-crimson">{{category.name}}</td>
                                <td class="text-center">
                                    <a href="#" class="text-primary" @click="editCategory(category)">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-danger" @click="deleteCategory(category)">
                                        <i class="fas fa-window-close"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-8">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Layanan</th>
                                <th colspan="2" class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category, index) in categories.category_devices.value" :key="category.id">
                                <th scope="row">{{index+1}}</th>
                                <td class="text-crimson">{{category.name}}</td>
                                <td class="text-center">
                                    <a href="#" class="text-primary" @click="editCategory(category)">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-danger" @click="deleteCategory(category)">
                                        <i class="fas fa-window-close"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-xl-4">
                    
                </div>
            </div>
        </div>

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="modalAddCategory">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="formAddCategory" class="form-modified" :class="{ 'was-validated': formAddIsValid }">
                            <div class="mb-3">
                                <label class="text-warning form-text-helper"><i class="fas fa-exclamation-circle"></i> contoh: <span class="text-danger">(30Mbps, 40Mbps,...)</span> atau <span class="text-danger">(2P Internet + TV, 2P Internet + Telepon,...)</span></label>
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="name" placeholder="Nama Kategori" required v-model="fieldAddCategory.name">
                                    <label for="name">Nama Kategori</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-warning form-text-helper"><i class="fas fa-exclamation-circle"></i> Jika nama kategori (30Mbps, 40Mbps,..) silahkan pilih <span class="text-danger">Kecepatan Internet</span>, dan sebaliknya</label>
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="fieldAddCategory.category_type">
                                        <option value="internet speed">Kecepatan Internet</option>
                                        <option value="devices">Devices</option>
                                    </select>
                                    <label for="floatingSelect">Kategori Tipe</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-crimson fs-5 fw-bold" :disabled="buttonFormAddCategory">
                                    <span v-if="buttonFormAddCategory" class="spinner-border spinner-border-sm"></span>
                                    {{ buttonTextFormAddCategory }}
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

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="modalEditCategory">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-lg-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="formEditCategory" class="form-modified" :class="{ 'was-validated': formEditIsValid }">
                            <div class="mb-3">
                                <label class="text-warning form-text-helper"><i class="fas fa-exclamation-circle"></i> contoh: <span class="text-danger">(30Mbps, 40Mbps,...)</span> atau <span class="text-danger">(2P Internet + TV, 2P Internet + Telepon,...)</span></label>
                                <div class="form-floating">
                                    <input type="text" class="form-control form-control-sm" id="name" placeholder="Nama Kategori" required v-model="fieldEditCategory.name">
                                    <label for="name">Nama Kategori</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-warning form-text-helper"><i class="fas fa-exclamation-circle"></i> Jika nama kategori (30Mbps, 40Mbps,..) silahkan pilih <span class="text-danger">Kecepatan Internet</span>, dan sebaliknya</label>
                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="fieldEditCategory.category_type">
                                        <option value="internet speed">Kecepatan Internet</option>
                                        <option value="devices">Devices</option>
                                    </select>
                                    <label for="floatingSelect">Kategori Tipe</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-crimson fs-5 fw-bold" :disabled="buttonFormEditCategory">
                                    <span v-if="buttonFormEditCategory" class="spinner-border spinner-border-sm"></span>
                                    {{ buttonTextFormEditCategory }}
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

        <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" ref="modalDeleteCategory">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-crimson text-white">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Hapus Kategori?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <form @submit.prevent="formDeleteCategory" class="form-modified">
                            <div class="mb-3" v-if="fieldDeleteCategory">
                                <h1>{{fieldDeleteCategory.name}}</h1>
                            </div>
                            <button v-if="deleteSuccessful===''" class="btn btn-crimson fs-5 fw-bold" :disabled="buttonFormDeleteCategory">
                                <span v-if="buttonFormDeleteCategory" class="spinner-border spinner-border-sm"></span>
                                {{ buttonTextFormDeleteCategory }}
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
import { reactive, ref, onMounted } from 'vue';

export default {
    name: 'Categories',
    extends: PrivateLayout,
    computed: {
        indexedInternet() {
          return this.categories.category_internetSpeed.map((category, index) => ({ ...category, index }));
        },
    },
    setup() {

        // fetch the categories to display
        const categories = reactive({
            category_internetSpeed: ref([]),
            category_devices: ref([]),
        });
        const fetchCategories = async () => {
            try {
                const response = await axios.get('/api/categories', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    }
                });
                categories.category_internetSpeed.value = response.data.filter(category => category.category_type === 'internet speed');
                categories.category_devices.value = response.data.filter(category => category.category_type === 'devices');
            } catch (error) {
                console.error(error);
            }
        };


        // ========================= MODAL ADD CATEGORY
        const modalAddCategory = ref(null);
        const fieldAddCategory = ref([]);
        const buttonTextFormAddCategory = ref('Tambah');
        const formAddIsValid = ref(false);
        const buttonFormAddCategory = ref(false);
        const addSuccessful = ref('');
        const addCategory = () => {
            new bootstrap.Modal(modalAddCategory.value).show();
        };
        const formAddCategory = async () => {
            buttonFormAddCategory.value = true;
            buttonTextFormAddCategory.value = "Loading..."
            if(fieldAddCategory.value.name && ['internet speed', 'devices'].indexOf(fieldAddCategory.value.category_type > -1) ){
                formAddIsValid.value = true;
                const categoryData = {
                    name: fieldAddCategory.value.name,
                    category_type: fieldAddCategory.value.category_type,
                    text: fieldAddCategory.value.name
                };
                try {
                    const response = await axios.post('/api/categories', categoryData, {
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
                    buttonFormAddCategory.value = false;
                    buttonTextFormAddCategory.value = 'Tambah';
                }
            }else{
                formAddIsValid.value = false;
                buttonFormAddCategory.value = false;
                buttonTextFormAddCategory.value = 'Tambah';
            } 
        };


        // ========================= MODAL EDIT CATEGORY
        const modalEditCategory = ref(null);
        const fieldEditCategory = ref([]);
        const buttonTextFormEditCategory = ref('Save');
        const formEditIsValid = ref(false);
        const buttonFormEditCategory = ref(false);
        const editSuccessful = ref('');
        const editCategory = (category) => {
            fieldEditCategory.value = category;
            new bootstrap.Modal(modalEditCategory.value).show();
        }
        const formEditCategory = async () => {
            buttonFormEditCategory.value = true;
            buttonTextFormEditCategory.value = "Loading..."
            if(fieldEditCategory.value.name && ['internet speed', 'devices'].indexOf(fieldEditCategory.value.category_type > -1) ){
                formEditIsValid.value = true;
                const categoryData = {
                    name: fieldEditCategory.value.name,
                    category_type: fieldEditCategory.value.category_type,
                    text: fieldEditCategory.value.name
                };
                try {
                    const response = await axios.put(`/api/categories/${fieldEditCategory.value.id}`, categoryData, {
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
                    buttonFormEditCategory.value = false;
                    buttonTextFormEditCategory.value = 'Save';
                }
            }else{
                formEditIsValid.value = false;
                buttonFormEditCategory.value = false;
                buttonTextFormEditCategory.value = 'Save';
            } 
        };


        // ========================= MODAL DELETE CATEGORY
        const modalDeleteCategory = ref(null);
        const fieldDeleteCategory = ref([]);
        const buttonTextFormDeleteCategory = ref('Delete');
        const buttonFormDeleteCategory = ref(false);
        const deleteSuccessful = ref('');
        const deleteCategory = (service) => {
            fieldDeleteCategory.value = service;
            new bootstrap.Modal(modalDeleteCategory.value).show();
        }

        const formDeleteCategory = async () => {
            buttonFormDeleteCategory.value = true;
            buttonTextFormDeleteCategory.value = "Loading..."
            try {
                const response = await axios.delete(`/api/categories/${fieldDeleteCategory.value.id}`, {
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
                buttonTextFormDeleteCategory.value = 'Delete';
            }
        };

        onMounted(() => {
            fetchCategories();
        });
        return {
            categories,
            modalAddCategory, fieldAddCategory, buttonTextFormAddCategory, formAddIsValid, buttonFormAddCategory, addSuccessful, addCategory, formAddCategory,
            modalEditCategory, fieldEditCategory, buttonTextFormEditCategory, formEditIsValid, buttonFormEditCategory, editSuccessful, editCategory, formEditCategory,
            modalDeleteCategory, fieldDeleteCategory, buttonTextFormDeleteCategory, buttonFormDeleteCategory, deleteSuccessful, deleteCategory, formDeleteCategory
        };
    }
}
</script>

<style>
/* App-wide styles go here */
</style>
