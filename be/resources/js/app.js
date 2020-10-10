require('./bootstrap');
window.Vue = require('vue');

import store from './store/index'

Vue.component('transactions', require('./components/Transactions.vue').default)

const app = new Vue({
    el: '#app',
    store
});
