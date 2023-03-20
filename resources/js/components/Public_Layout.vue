<template>
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light navbar-public">
            <a class="navbar-brand main-logo m-3" href="/">
                <img src="/img/main-logo.png" alt="Logo">
            </a>
            <button class="navbar-toggler bg-white mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active nav-text">
                        <a class="nav-link menu-text mx-3 fw-normal" href="#">Beranda</a>
                    </li>
                    <li class="nav-item nav-text">
                        <a class="nav-link menu-text mx-3 fw-normal" href="#">Layanan</a>
                    </li>
                    <li class="nav-item nav-text">
                        <a class="nav-link menu-text mx-3 fw-normal" href="#">Promo</a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav flex-row flex-wrap me-auto">
                    <li class="nav-item">
                        <a class="nav-link menu-icon mx-5" href="/login">
                            <img src="/img/user-icon.svg" class="filter-green" alt="icon" width="32" height="32">
                        </a>
                    </li>
                </ul>
            </div>
        </nav>


        <main class="mb-5 page-content">
            <slot></slot>
        </main>

        <footer class="page-footer footer mt-auto d-flex flex-wrap justify-content-between align-items-center border-top bg-crimson">
            
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <p class="text-white">&copy; 2023 Company, Inc</p>
                    </div>
                    <div class="col-md-4 text-end text-md-center">
                        <text class="fs-6 text-white fw-light">&copy; Copyright <span class="text-white fw-bold">rewang.id</span> All Rights Reserved</text>
                    </div>
                </div>
            </div>

            
        </footer>
    </div>
</template>
