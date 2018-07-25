import Vue from "vue";
import Content from "../../../components/app/bills/bills-content.vue";
import store from "./bills-store";

new Vue({
  store,

  el: '#cit-content',
  render: h => h(Content),
  components: { Content },
});
