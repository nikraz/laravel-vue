import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'
import state from "./state";
import boostrap from "bootstrap-vue"

//Registered globally currently vuex is useless but is first attempt so I don't remove it
Vue.use(Vuex);
Vue.use(boostrap);

export default new Vuex.Store({
    state,
    mutations,
    getters,
    actions
})
