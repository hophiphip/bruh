/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;


/**
 * Load bootstrap stuff
 */
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/NavbarUserMode.vue -> <example-component></example-component>
 */
Vue.component('paginate', require('vuejs-paginate'));
Vue.component('navbar-user-mode', require('./components/NavbarUserMode.vue').default);
Vue.component('sign-bar', require('./components/SignBar').default);
Vue.component('search-form', require('./components/SearchForm').default);

Vue.component('clients-page', require('./components/ui/ClientsPage').default);

Vue.component('offers', require('./components/Offers').default);
Vue.component('offer-form', require('./components/OfferForm').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
});
