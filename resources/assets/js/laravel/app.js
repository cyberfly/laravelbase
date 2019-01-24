
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// use VeeValidate

const VeeValidate = require('vee-validate');

window.Vue.use(VeeValidate);

// use Vue Sweet Alert

import VueSweetalert2 from 'vue-sweetalert2';

window.Vue.use(VueSweetalert2);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

/*
Admin Components here
 */

Vue.component('create-user-component', require('../../../components/admin/users/CreateUserComponent.vue'));

/*
 End of Admin Components
 */

/*
 Common Components here
 */

Vue.component('v-text', require('../../../components/common/forms/InputTextComponent.vue'));
Vue.component('v-select', require('../../../components/common/forms/SelectInputComponent.vue'));
Vue.component('v-validation-alert', require('../../../components/common/forms/ValidationAlertComponent.vue'));

/*
 End of Common Components
 */

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#page-container'
});
