require('./bootstrap');
import Vue from "vue";

Vue.config.productionTip = false;
import VueRouter from "vue-router";
import {Routes} from "./Routes/Routes";
import {GridPlugin} from "@syncfusion/ej2-vue-grids";
import CKEditor from 'ckeditor4-vue';
import FileReader from "vue-filereader";

// Validation With V Form
import VForm from "vform";
// Import Moment Js
import moment from "moment";
// Start Filter Set-Up
import "./Filter/Filters";
// End Filter Set-up
require('toastr/toastr.scss')
window.VForm = VForm;
import Vuex from "vuex";
import DataStore from "./Store/DataStore";
// Use App Plugins
Vue.use(Vuex);
Vue.use(GridPlugin);
Vue.use(CKEditor);


// Vue Component

Vue.component(FileReader.name, FileReader)

const store = new Vuex.Store(DataStore)
Vue.use(VueRouter);
const Router = new VueRouter({
    routes: Routes,
    mode: "history"
});


const app = new Vue({
    router: Router,
    store,
}).$mount('#app');

Router.beforeEach((toRoute, fromRoute, next) => {
    window.document.title = toRoute.meta && toRoute.meta.title ? toRoute.meta.title : 'Home';
    next();
})
