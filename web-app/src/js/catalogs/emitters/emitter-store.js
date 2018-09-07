import Vue from "vue";
import Vuex from "vuex";
import subMenu from "../../store-modules/subMenu-store-module";
import emitterStore from "../../store-modules/emitter-store-module";
import menu from "../../store-modules/app-menu-store-module";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    emitterStore,
    menu,
    subMenu
  },
});
