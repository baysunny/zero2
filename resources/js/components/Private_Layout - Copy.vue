<template>
	<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto px-0">
            <div id="sidebar" class="collapse collapse-horizontal show border-end">
                <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-100">
                    <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar">
                        <i class="fas fa-home"></i> <span>Dashboard</span>
                    </a>
                    <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar">
                        <i class="fas fa-cog"></i> <span>Setting</span>
                    </a>
                    <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate" data-bs-parent="#sidebar">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </a>
                    
                </div>
            </div>
        </div>
        <main class="col ps-md-2 pt-2">
            <a href="#" data-bs-target="#sidebar" style="width:5rem" data-bs-toggle="collapse" class="btn border rounded-3 p-1 mb-2 text-decoration-none" @click="toggleSidebar">
                <i class="fas fa-angle-right fa-lg py-2 p-1"></i> Menu</a>
            <slot></slot>
        </main>
    </div>
</div>
</template>

<script>
	import axios from 'axios';
    export default {
        name: 'PrivateLayout',
        methods: {
            logout() {
                axios.post('/api/authentication/logout', null, {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(() => {
                    localStorage.removeItem("token");
                    this.$router.push("/login");
                
                }).catch((error) => {
                    this.errorMessage = error.response.data.message;
                });      
            },
        },
    };
</script>