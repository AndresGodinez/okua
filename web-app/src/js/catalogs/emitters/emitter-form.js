import Vue from "vue";
import Content from "../../../components/catalogs/emitters/emitter-form";
import store from "./emitter-store";
import Ripple from "vue-ripple-directive";
import "v2-table/dist/index.css";
import V2Table from 'v2-table';
import "../../shared/currency-filter";

Vue.use(V2Table);

Vue.directive('ripple', Ripple);

new Vue({
  store,

  el: '#cit-content',
  render: h => h(Content),
  components: { Content },
});
