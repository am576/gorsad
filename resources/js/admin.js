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

import { BTable } from 'bootstrap-vue/esm/components/table'
import { BPagination } from "bootstrap-vue/esm/components/pagination";
import { BBadge } from "bootstrap-vue/esm/components/badge";
import { BCollapse } from "bootstrap-vue/esm/components/collapse";
import { BTooltip } from "bootstrap-vue/esm/components/tooltip";
import { VBToggle } from "bootstrap-vue/esm/directives/toggle";
import { VBTooltip } from "bootstrap-vue/esm/directives/tooltip";

Vue.prototype.$eventBus = new Vue();

Vue.use(Vuetify);
Vue.use(PrettyCheckbox);
Vue.use( CKEditor );
Vue.use( vSelect );
Vue.use( ClassicEditor );

Vue.component('v-select', vSelect);

Vue.component('b-table', BTable);
Vue.component('b-pagination', BPagination);
Vue.component('b-badge', BBadge);
Vue.component('b-collapse', BCollapse);
Vue.component('b-tooltip', BTooltip);
Vue.directive('b-toggle', VBToggle);
Vue.directive('b-tooltip', VBTooltip);

/** Admin side components **/
Vue.component('category-selector', require('./components/admin/CategorySelector.vue').default);
Vue.component('attribute-selector', require('./components/admin/attributes/AttributeSelector.vue').default);
// Vue.component('attribute-selector-edit', require('./components/admin/attributes/AttributeSelectorEdit.vue').default);
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
Vue.component('b-cancel-query', require('./components/admin/orders/CancelQueryButton').default);

Vue.component('projects-table', require('./components/admin/projects/ProjectsTable').default);
Vue.component('project-form', require('./components/admin/projects/ProjectForm').default);

Vue.component('services-table', require('./components/admin/services/ServicesTable').default);
Vue.component('service-form', require('./components/admin/services/ServiceForm').default);
Vue.component('service-group-form', require('./components/admin/services/ServiceGroupForm').default);

Vue.component('vue-tags-input', require('@johmun/vue-tags-input').default);

Vue.component('messages-table', require('./components/admin/messages/MessagesTable').default);
/** END Admin side components **/

/** Client side components **/

/* Shared components */
Vue.component('g-modal', require('./components/frontend/shared/GenericModal').default);
Vue.component('image-modal', require('./components/frontend/ImageModal').default);
/* End Shared components */

/** END Client side components **/

const app = new Vue({
    VueTagsInput,
    el: '#app-admin',
    vuetify: new Vuetify(),
});
