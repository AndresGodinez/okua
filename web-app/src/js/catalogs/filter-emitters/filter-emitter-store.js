import Vue from "vue";
import Vuex from "vuex";
import menu from "../../store-modules/app-menu-store-module";
import subMenu from "../../store-modules/subMenu-store-module";
import filterEmitterStore from "../../store-modules/filter-emitter-store-module";
import loading from "../../store-modules/loading-store-module";


Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    filterEmitterStore,
    menu,
    subMenu,
    loading
  },
});
