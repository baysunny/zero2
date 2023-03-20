import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import Home from './Home.vue';
import PublicLayout from './components/Public_Layout.vue';
import Login from './authentication/Login.vue';
import MembershipCreate from './memberships/MembershipCreate.vue';


import PrivateLayout from './components/Private_Layout.vue';
import Dashboard from './dashboard/Dashboard.vue';
import Settings from './users/Settings.vue';
import Services from './services/Services.vue';
import Categories from './categories/Categories.vue';


const router = createRouter({
  history: createWebHistory(),
  routes: [
  	{ path: '/', name: 'home', component: Home },
    { path: '/login', name: 'login', component: Login },
    { path: '/membership/:id/register', name: 'membershipCreate', component: MembershipCreate },

    { path: '/dashboard', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/dashboard/settings', name: 'settings', component: Settings, meta: { requiresAuth: true } },
    { path: '/dashboard/services', name: 'services', component: Services, meta: { requiresAuth: true } },
    { path: '/dashboard/categories', name: 'categories', component: Categories, meta: { requiresAuth: true } },
  ]
});
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('token');
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else {
    next();
  }
});
const app = createApp(App);
app.component('PublicLayout', PublicLayout).component('PrivateLayout', PrivateLayout).use(router);

app.mount('#app');
