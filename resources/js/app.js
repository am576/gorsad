require('./bootstrap');

window.Vue = require('vue');

import vuetify from './vuetify';
import VueTagsInput from '@johmun/vue-tags-input';
import CKEditor from '@ckeditor/ckeditor5-vue';


Vue.prototype.$eventBus = new Vue();

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

import * as ClassicEditor from '/public/ckcustom/build/ckeditor.js';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import PrettyCheckbox from 'pretty-checkbox-vue';

Vue.use(PrettyCheckbox);

Vue.use( CKEditor );
Vue.use( BootstrapVue );
Vue.use( IconsPlugin );
Vue.use( vSelect );
Vue.use( ClassicEditor );

Vue.component('v-select', vSelect)

/* Admin side components */
Vue.component('category-selector', require('./components/admin/CategorySelector.vue').default);
Vue.component('attribute-selector', require('./components/admin/attributes/AttributeSelector.vue').default);
Vue.component('attribute-selector-edit', require('./components/admin/attributes/AttributeSelectorEdit.vue').default);
Vue.component('image-uploader', require('./components/admin/ImageUploader').default);

Vue.component('product-form', require('./components/admin/products/ProductForm').default);
Vue.component('product-edit-form', require('./components/admin/products/ProductEditForm').default);
Vue.component('products-table', require('./components/admin/products/ProductsTable').default);
Vue.component('product-variants', require('./components/admin/products/ProductVariants').default);

Vue.component('table-filter', require('./components/admin/TableFilter').default);
Vue.component('table-pagination', require('./components/admin/TablePagination').default);
Vue.component('category-form', require('./components/admin/CategoryForm').default);
Vue.component('table-buttons', require('./components/admin/TableButtons').default);
Vue.component('attribute-form', require('./components/admin/attributes/AttributeForm').default);
Vue.component('attribute-values', require('./components/admin/attributes/AttributeValues').default);
Vue.component('iconset-form', require('./components/admin/IconsetForm').default);
Vue.component('user-query-editor', require('./components/admin/UserQueryEditor').default);

Vue.component('projects-table', require('./components/admin/projects/ProjectsTable').default);
Vue.component('project-form', require('./components/admin/projects/ProjectForm').default);

Vue.component('vue-tags-input', require('@johmun/vue-tags-input').default);

/* Client side components */
Vue.component('site-navigation', require('./components/frontend/SiteNavigation').default);
Vue.component('account-links', require('./components/frontend/AccountLinks').default);
Vue.component('home-slider', require('./components/frontend/HomeSlider').default);
Vue.component('filter-small', require('./components/frontend/FilterSmall').default);
Vue.component('services-list', require('./components/frontend/ServicesList').default);
Vue.component('projects-list', require('./components/frontend/ProjectsList').default);
Vue.component('project-images', require('./components/frontend/ProjectImages').default);

Vue.component('product-bar', require('./components/frontend/ProductBar').default);
Vue.component('product-images', require('./components/frontend/ProductImages').default);

Vue.component('shopping-cart', require('./components/frontend/ShoppingCart').default);
Vue.component('signin-form', require('./components/frontend/user/SigninForm').default);


/* Shop components */
Vue.component('products-list', require('./components/frontend/shop/ProductsList').default);
Vue.component('shop-page', require('./components/frontend/shop/ShopPage').default);
Vue.component('checkout-page', require('./components/frontend/shop/CheckoutPage').default);
Vue.component('product-page', require('./components/frontend/shop/ProductPage').default);
Vue.component('shop-filter', require('./components/frontend/shop/ShopFilter').default);
Vue.component('attribute-button', require('./components/frontend/shop/AttributeButton').default);
Vue.component('shop-navigation', require('./components/frontend/shop/ShopNavigation').default);
/* End Shop components */

/* End Client side components */

/* Account page components */
Vue.component('user-profile', require('./components/frontend/profile/UserProfile').default);
Vue.component('notifications-list', require('./components/frontend/profile/NotificationsList').default);
Vue.component('user-cabinet', require('./components/frontend/profile/UserCabinet').default);
Vue.component('favorites-list', require('./components/frontend/profile/FavoritesList').default);
Vue.component('review-form', require('./components/frontend/ReviewForm').default)

const app = new Vue({
    vuetify,
    VueTagsInput,
    el: '#app',
});
