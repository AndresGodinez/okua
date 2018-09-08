<template>
  <div class="flex flex-col text-center pt-8">
    <div class="bg-theme-color-4 w-1/3 m-auto mt-8 mb-8 p-6 rounded-lg">
      <h1 class="text-white font-sans font-normal">OKUA</h1>
    </div>
    <img src="https://www.google.com.mx/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwjwuN-ds6ndAhWIHjQIHen-CPQQjRx6BAgBEAU&url=https%3A%2F%2Fgiphy.com%2Fgifs%2Fapprenticenbc-2016-nbc-d4aTnvQuF6xyfgWI&psig=AOvVaw2q2F9jpVh1x-9M_8o00skm&ust=1536427125992244" alt="BYE">
    <div class="w-1/3 m-auto text-center py-4 font-bold">
      <span class="text-blue-darker font-sans font-normal">&copy; 2018 Connect IT</span>
    </div>
  </div>
</template>

<script>
  import TokenUtils from "../../../js/utils/token-utils";
  import RouteUtils from "../../../js/utils/route-utils";
  import AlertUtils from "../../../js/utils/alert-utils";
  import UserService from "../../../js/services/user-service";
  import {mapActions} from "vuex";



  const data = function () {
    return {};
  };
    const methods = {
      sayBye(){
        setTimeout(() => RouteUtils.getLogin(), 5000);
      }
    };

    const computed = {

    };

    export default {
      data,
      methods,
      computed,

      name: "logout-content",
      components: {
      },
      mounted() {
        this.sayBye();

      }
    };
</script>

<style scoped>
</style>