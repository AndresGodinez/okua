import Vue from "vue";
import Vuex from "vuex";
import section from "../../store-modules/admin-config-email-service-store-module";
import loading from "../../store-modules/loading-store-module";
import menu from "../../store-modules/app-menu-store-module";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    section,
    menu,
    loading,
  },
});
