require('./bootstrap');

window.Vue = require('vue');
Vue.prototype.$eventBus = new Vue();

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { BCollapse } from "bootstrap-vue/esm/components/collapse";
import { VBToggle } from "bootstrap-vue/esm/directives/toggle";

// Vue.use(Vuetify);

Vue.component('b-collapse', BCollapse);
Vue.directive('b-toggle', VBToggle);
Vue.component('signin-form', require('./components/frontend/user/SigninForm').default);

/* Shop components */
Vue.component('products-list', require('./components/frontend/shop/ProductsList').default);
Vue.component('shop-page', require('./components/frontend/shop/ShopPage').default);
Vue.component('checkout-page', require('./components/frontend/shop/CheckoutPage').default);
Vue.component('product-page', require('./components/frontend/shop/ProductPage').default);
Vue.component('shop-filter', require('./components/frontend/shop/ShopFilter').default);
Vue.component('attribute-button', require('./components/frontend/shop/AttributeButton').default);
Vue.component('shop-navigation', require('./components/frontend/shop/ShopNavigation').default);
Vue.component('comparison-page', require('./components/frontend/shop/ComparisonPage').default);
Vue.component('product-images', require('./components/frontend/shop/ProductImages').default);
/* End Shop components */

/* Shared components */
Vue.component('g-banner', require('./components/frontend/shared/GenericBanner').default);
Vue.component('g-modal', require('./components/frontend/shared/GenericModal').default);
Vue.component('image-modal', require('./components/frontend/ImageModal').default);
Vue.component('account-dropdown', require('./components/frontend/shared/AccountDropdown').default);
/* End Shared components */

const app = new Vue({
    el: '#app.catalog',
});
