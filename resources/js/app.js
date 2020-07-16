/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import vuetify from './vuetify'
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.prototype.$eventBus = new Vue();

Vue.component('category-selector', require('./components/CategorySelector.vue').default);
Vue.component('attribute-selector', require('./components/AttributeSelector.vue').default);
Vue.component('attribute-selector-edit', require('./components/AttributeSelectorEdit.vue').default);
Vue.component('image-uploader', require('./components/ImageUploader').default);
Vue.component('product-form', require('./components/ProductForm').default);
Vue.component('product-edit-form', require('./components/ProductEditForm').default);
Vue.component('products-table', require('./components/ProductsTable').default);
Vue.component('table-filter', require('./components/TableFilter').default);
Vue.component('table-pagination', require('./components/TablePagination').default);
Vue.component('category-form', require('./components/CategoryForm').default);
Vue.component('table-buttons', require('./components/TableButtons').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    vuetify,
    el: '#app',

});
