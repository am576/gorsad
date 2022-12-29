require('./bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify';

import VueTagsInput from '@johmun/vue-tags-input';
import CKEditor from '@ckeditor/ckeditor5-vue';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import * as ClassicEditor from '/public/ckcustom/build/ckeditor.js';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import PrettyCheckbox from 'pretty-checkbox-vue';
import 'leaflet/dist/leaflet.css';

import { BTable } from 'bootstrap-vue/esm/components/table'
import { BPagination } from "bootstrap-vue/esm/components/pagination";
import { BBadge } from "bootstrap-vue/esm/components/badge";
import { BCollapse } from "bootstrap-vue/esm/components/collapse";
import { VBToggle } from "bootstrap-vue/esm/directives/toggle";
import Flipbook from 'flipbook-vue/dist/vue2/flipbook.min';

Vue.prototype.$eventBus = new Vue();

Vue.use(Vuetify);
Vue.use(PrettyCheckbox);
Vue.use( CKEditor );
Vue.use( vSelect );
Vue.use( ClassicEditor );
Vue.use( Flipbook );

Vue.component('v-select', vSelect);
Vue.component('InfiniteLoading', require('vue-infinite-loading'));

Vue.component('b-table', BTable);
Vue.component('b-pagination', BPagination);
Vue.component('b-badge', BBadge);
Vue.component('b-collapse', BCollapse);
Vue.directive('b-toggle', VBToggle);

/** Client side components **/
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

Vue.component('projects-map', require('./components/frontend/projects/ProjectsMap').default);
Vue.component('services-page', require('./components/frontend/services/ServicesPage').default);
Vue.component('service-page', require('./components/frontend/services/ServicePage').default);

Vue.component('contact-form', require('./components/frontend/contacts/ContactForm').default);

/* Shop components */
Vue.component('products-list', require('./components/frontend/shop/ProductsList').default);
Vue.component('shop-page', require('./components/frontend/shop/ShopPage').default);
Vue.component('checkout-page', require('./components/frontend/shop/CheckoutPage').default);
Vue.component('product-page', require('./components/frontend/shop/ProductPage').default);
Vue.component('shop-filter', require('./components/frontend/shop/ShopFilter').default);
Vue.component('attribute-button', require('./components/frontend/shop/AttributeButton').default);
Vue.component('shop-navigation', require('./components/frontend/shop/ShopNavigation').default);
Vue.component('comparison-page', require('./components/frontend/shop/ComparisonPage').default);
/* End Shop components */

/* Account page components */
Vue.component('user-profile', require('./components/frontend/profile/UserProfile').default);
Vue.component('notifications-list', require('./components/frontend/profile/NotificationsList').default);
Vue.component('user-cabinet', require('./components/frontend/profile/UserCabinet').default);
Vue.component('favorites-list', require('./components/frontend/profile/FavoritesList').default);
Vue.component('review-form', require('./components/frontend/ReviewForm').default);
/* Account page components */

/* Shared components */
Vue.component('g-modal', require('./components/frontend/shared/GenericModal').default);
Vue.component('image-modal', require('./components/frontend/ImageModal').default);
Vue.component('account-dropdown', require('./components/frontend/shared/AccountDropdown').default);
Vue.component('guide-flipbook', require('./components/frontend/shared/GuideFlipbook').default);
Vue.component('g-banner', require('./components/frontend/shared/GenericBanner').default);
/* End Shared components */

/** End Client side components **/

const app = new Vue({
    VueTagsInput,
    el: '#app',
    vuetify: new Vuetify(),
});
