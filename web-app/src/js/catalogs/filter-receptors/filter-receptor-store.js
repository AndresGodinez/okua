import Vue from "vue";
import Vuex from "vuex";
import menu from "../../store-modules/app-menu-store-module";
import subMenu from "../../store-modules/subMenu-store-module";
import filterReceptorStore from "../../store-modules/filter-receptor-store-module";
import loading from "../../store-modules/loading-store-module";


Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    filterReceptorStore,
    menu,
    subMenu,
    loading
  },
});
