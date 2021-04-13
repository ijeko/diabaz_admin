/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import store from './store/store';
import VueRouter from "vue-router";
require('./bootstrap');

import router from "./router/index";

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//wrappers
Vue.component('home-wrapper-component', require('./components/HomeWrapperComponent.vue').default);
Vue.component('admin-wrapper-component', require('./components/AdminWrapperComponent.vue').default);
Vue.component('reports-wrapper-component', require('./components/ReportsWrapperComponent.vue').default);

//inputdata
Vue.component('materials-component', require('./components/MaterialsComponent.vue').default);
Vue.component('motor-component', require('./components/MotorComponent.vue').default);
Vue.component('production-component', require('./components/ProductionComponent.vue').default);
Vue.component('enter-produced', require('./components/popup/addProduction.vue').default);
Vue.component('enter-sold', require('./components/popup/addSold.vue').default);
Vue.component('show-norm-norm', require('./components/popup/ShowNorm.vue').default);
Vue.component('show-incomes', require('./components/popup/ShowIncomes.vue').default);
Vue.component('add-incomes', require('./components/popup/AddIncomeForm.vue').default);
Vue.component('enter-motohour', require('./components/popup/addMotohours.vue').default);

//admin
Vue.component('admin-production-component', require('./components/admin/production.vue').default);
Vue.component('admin-edit-production-component', require('./components/admin/popup/editProduction.vue').default);
Vue.component('admin-new-production-component', require('./components/admin/popup/newProduction.vue').default);
Vue.component('admin-materials-component', require('./components/admin/materials.vue').default);
Vue.component('admin-edit-material-component', require('./components/admin/popup/editMaterial.vue').default);
Vue.component('admin-new-material-component', require('./components/admin/popup/newMaterial.vue').default);
Vue.component('admin-machines-component', require('./components/admin/machines.vue').default);
Vue.component('admin-edit-machine-component', require('./components/admin/popup/editMachine.vue').default);
Vue.component('admin-new-machine-component', require('./components/admin/popup/newMachine.vue').default);
Vue.component('admin-edit-inputs-component', require('./components/admin/popup/editInputs.vue').default);
Vue.component('add-mat-norm', require('./components/admin/popup/AddMatNorm.vue').default);
Vue.component('admin-user-component', require('./components/admin/users.vue').default);
Vue.component('admin-edit-user-component', require('./components/admin/popup/editUser.vue').default);
Vue.component('admin-new-user-component', require('./components/admin/popup/newUser.vue').default);
Vue.component('component-loader', require('./components/loaders/componentLoader').default);

//reports
Vue.component('production-month-component', require('./components/reports/ProductionMonth.vue').default);
Vue.component('product-upload-component', require('./components/reports/ProductUploadReport.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueRouter)
const app = new Vue({
    el: '#app',
    store: new Vuex.Store(store),
    router
});
