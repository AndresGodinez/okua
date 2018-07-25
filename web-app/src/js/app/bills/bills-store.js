import Vue from "vue";
import Vuex from "vuex";
import section from "../../store-modules/bills-store-module";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    section,
  },
});
