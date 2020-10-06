import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'
import state from "./state";
import DataTable from 'laravel-vue-datatable';

Vue.use(Vuex);
Vue.use(DataTable);

export default new Vuex.Store({
    state,
    mutations,
    getters,
    actions
})
