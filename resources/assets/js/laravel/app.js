
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// vue global event bus

Vue.prototype.$eventBus = new Vue();

// custom mixin

import Commons from '../../../assets/js/mixins/Commons';
Vue.mixin(Commons);

import Permissions from '../../../assets/js/mixins/Permissions';
Vue.mixin(Permissions);

import ShowHideLoading from '../../../assets/js/mixins/ShowHideLoading';
Vue.mixin(ShowHideLoading);

// use Laravel Localization to Vue

import Lang from 'lang.js';

const default_locale = window.default_locale;
const fallback_locale = window.fallback_locale;
const messages = window.messages;

Vue.prototype.trans = new Lang( { messages: messages, locale: default_locale, fallback: fallback_locale } );

// use Vue Bootstrap

import BootstrapVue from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue.use(BootstrapVue);

// use VeeValidate

const VeeValidate = require('vee-validate');

window.Vue.use(VeeValidate);

// use Vue Sweet Alert

import VueSweetalert2 from 'vue-sweetalert2';

window.Vue.use(VueSweetalert2);

// use Vue Multi Select

import Multiselect from 'vue-multiselect';

Vue.component('multiselect', Multiselect);

// use Vue Flatpickr Date Picker

import VueFlatPickr from 'vue-flatpickr-component';

Vue.use(VueFlatPickr);

// use Vue loading

import loading from 'vue-full-loading';

Vue.component('loading', loading);

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
Vue.component('edit-user-component', require('../../../components/admin/users/EditUserComponent.vue'));
Vue.component('show-user-component', require('../../../components/admin/users/ShowUserComponent.vue'));

Vue.component('index-role-component', require('../../../components/admin/roles/IndexRoleComponent.vue'));
Vue.component('create-role-component', require('../../../components/admin/roles/CreateRoleComponent.vue'));
Vue.component('edit-role-component', require('../../../components/admin/roles/EditRoleComponent.vue'));

/*
 End of Admin Components
 */

/*
 Common Components here
 */

Vue.component('v-text', require('../../../components/common/forms/InputTextComponent.vue'));
Vue.component('v-number', require('../../../components/common/forms/InputNumberComponent.vue'));
Vue.component('v-textarea', require('../../../components/common/forms/InputTextareaComponent.vue'));
Vue.component('v-unique', require('../../../components/common/forms/InputUniqueTextComponent.vue'));
Vue.component('v-ajax-select', require('../../../components/common/forms/AjaxMultiSelectInputComponent.vue'));
Vue.component('v-select', require('../../../components/common/forms/MultiSelectInputComponent.vue'));
Vue.component('v-child-select', require('../../../components/common/forms/MultiSelectInputChildComponent.vue'));
Vue.component('v-date', require('../../../components/common/forms/DatepickerInputComponent.vue'));
Vue.component('v-datetime', require('../../../components/common/forms/DatetimepickerInputComponent.vue'));
Vue.component('v-time', require('../../../components/common/forms/TimepickerInputComponent.vue'));
Vue.component('v-upload', require('../../../components/common/forms/UploadInputComponent.vue'));
Vue.component('v-money', require('../../../components/common/forms/MoneyInputComponent.vue'));
Vue.component('v-year', require('../../../components/common/forms/YearInputComponent.vue'));
Vue.component('v-month', require('../../../components/common/forms/MonthInputComponent.vue'));

Vue.component('v-validation-alert', require('../../../components/common/forms/ValidationAlertComponent.vue'));
Vue.component('v-parent-validation-alert', require('../../../components/common/forms/ParentValidationAlertComponent.vue'));

Vue.component('v-search-field', require('../../../components/common/filters/SearchFieldFilterComponent.vue'));

Vue.component('v-stats-widget', require('../../../components/common/widgets/StatsWidgetComponent.vue'));
Vue.component('v-media-widget', require('../../../components/common/widgets/MediaWidgetComponent.vue'));
Vue.component('v-media-light-widget', require('../../../components/common/widgets/MediaLightWidgetComponent.vue'));
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('v-ajax-loading', require('../../../components/common/loaders/AjaxLoadingComponent.vue'));

Vue.component('v-html-list', require('../../../components/common/lists/HtmlListComponent.vue'));
Vue.component('v-index-notification', require('../../../components/common/notifications/IndexNotificationComponent.vue'));
Vue.component('v-header-notification', require('../../../components/common/notifications/HeaderNotificationComponent.vue'));

/*
 End of Common Components
 */

/*
 Common Filters here
 */

import '../../../filters/common/v-currency';

/*
 End of Common Filters
 */

/*
 Example Components here
 */

Vue.component('v-example-multiform-parent', require('../../../components/examples/forms/MultiFormParentComponent.vue'));
Vue.component('v-example-multiform-child', require('../../../components/examples/forms/MultiFormChildComponent.vue'));

Vue.component('v-example-invoice-parent', require('../../../components/examples/invoices/InvoiceParentComponent.vue'));
Vue.component('v-example-invoice-child', require('../../../components/examples/invoices/InvoiceChildComponent.vue'));

Vue.component('v-example-upload-form', require('../../../components/examples/forms/UploadFormComponent.vue'));
Vue.component('v-example-edit-upload-form', require('../../../components/examples/forms/EditUploadFormComponent.vue'));

Vue.component('v-example-vuepagination', require('../../../components/examples/vuepaginations/VuePaginationIndexComponent.vue'));

/*
 End of Example Components
 */

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#page-container'
});
