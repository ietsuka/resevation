require('./bootstrap');
window.Vue = require('vue');
import Vue from 'vue'
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);


Vue.component('index-component', require('./components/IndexComponent.vue').default);
const app = new Vue({
    el: '#app',
})
