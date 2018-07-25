import Vue from "vue";
import Content from "../../../components/app/login/login-content";
import store from "./login-store";

new Vue({
  store,

  el: '#cit-content',
  render: h => h(Content),
  components: { Content },
});
