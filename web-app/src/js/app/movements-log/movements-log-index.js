import Vue from "vue";
import Content from "../../../components/app/movements-log/movements-log-content.vue";
import store from "./movements-log-store";

new Vue({
  store,

  el: '#cit-content',
  render: h => h(Content),
  components: { Content },
});
