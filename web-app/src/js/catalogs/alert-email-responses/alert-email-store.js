import Vue from "vue";
import Vuex from "vuex";
import subMenu from "../../store-modules/subMenu-store-module";
import alertEmailResponseStore from "../../store-modules/alert-email-reponse-store-module";
import menu from "../../store-modules/app-menu-store-module";
import loading from "../../store-modules/loading-store-module";


Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    alertEmailResponseStore,
    menu,
    subMenu,
    loading
  },
});
