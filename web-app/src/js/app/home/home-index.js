import Vue from "vue";
import Content from "../../../components/app/home/home-content.vue";
import store from "./home-store";

new Vue({
  store,

  el: '#cit-content',
  render: h => h(Content),
  components: { Content },
});
