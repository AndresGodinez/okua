import Vue from "vue";
import Content from "../../../components/admin/config/config-email-service-content";
import store from "./email-service-store";
import Ripple from "vue-ripple-directive";
import "v2-table/dist/index.css";
import V2Table from 'v2-table';
import "../../shared/currency-filter";
import { Settings } from 'luxon'
import moment from "moment-es6";

Settings.defaultLocale = 'es';
moment.locale('es-LA');

Vue.directive('ripple', Ripple);

new Vue({
  store,

  el: '#cit-content',
  render: h => h(Content),
  components: { Content },
});
