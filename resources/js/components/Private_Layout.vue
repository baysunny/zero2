<template>
	<nav class="navbar navbar-private navbar-dark sticky-top bg-crimson flex-md-nowrap p-0 shadow">
        <a class="navbar-brand navbar-brand-private col-md-3 col-lg-2 me-0 px-3" href="/dashboard">IndiHome</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav d-none d-md-block">
            <div class="nav-item text-nowrap">
                <a href="#" class="nav-link px-3" @click.prevent="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="/dashboard">
                                <i class="fas fa-home feather"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="/dashboard/services">
                                <i class="fas fa-wifi feather"></i> <span>Paket Internet</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="/dashboard/categories">
                                <i class="fas fa-link feather"></i> <span>Kategori</span>
                            </a>
                        </li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Account</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard/settings">
                                <i class="fas fa-cog feather"></i> <span>Setting</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" @click.prevent="logout()">
                                <i class="fas fa-sign-out-alt feather"></i> <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
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