import Vue from "vue";
import Vuex from "vuex";
import section from "../../../store-modules/home-store-module";
import menu from "../../../store-modules/app-menu-store-module";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    section,
    menu,
  },
});
