require('./bootstrap');

window.Vue = require('vue');

import vuetify from './vuetify';
import VueTagsInput from '@johmun/vue-tags-input';
import CKEditor from '@ckeditor/ckeditor5-vue';


Vue.prototype.$eventBus = new Vue();

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use( CKEditor );
Vue.use( BootstrapVue );
Vue.use( IconsPlugin );
Vue.use( vSelect );

Vue.component('v-select', vSelect)

                                            /* Admin side components */
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
Vue.component('attribute-form', require('./components/AttributeForm').default);
Vue.component('attribute-values', require('./components/AttributeValues').default);
Vue.component('iconset-form', require('./components/IconsetForm').default);
Vue.component('user-query-editor', require('./components/UserQueryEditor').default);

Vue.component('vue-tags-input', require('@johmun/vue-tags-input').default);

                                            /*Client side components*/
Vue.component('site-navigation', require('./components/frontend/SiteNavigation').default);
Vue.component('account-links', require('./components/frontend/AccountLinks').default);
Vue.component('home-slider', require('./components/frontend/HomeSlider').default);
Vue.component('filter-small', require('./components/frontend/FilterSmall').default);
Vue.component('products-list', require('./components/frontend/ProductsList').default);
Vue.component('product-bar', require('./components/frontend/ProductBar').default);
Vue.component('product-images', require('./components/frontend/ProductImages').default);
Vue.component('product-page', require('./components/frontend/ProductPage').default);
Vue.component('shopping-cart', require('./components/frontend/ShoppingCart').default);
Vue.component('checkout-page', require('./components/frontend/CheckoutPage').default);

                                            /* Account page components */
Vue.component('user-profile', require('./components/frontend/profile/UserProfile').default);
Vue.component('notifications-list', require('./components/frontend/profile/NotificationsList').default);
Vue.component('user-cabinet', require('./components/frontend/profile/UserCabinet').default);

const app = new Vue({
    vuetify,
    VueTagsInput,
    el: '#app',
});
