require('./bootstrap');
window.Vue = require('vue');

import store from './store/index'

Vue.component('transactions', require('./components/Transactions.vue').default)
Vue.component('createTransaction', require('./components/CreateTransaction.vue').default)

const app = new Vue({
    el: '#app',
    store
});
