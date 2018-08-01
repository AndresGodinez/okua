<template>
    <div class="flex flex-col text-center pt-8">
        <loading :active.sync="isLoading" :can-cancel="false"></loading>

        <div class="bg-blue-light w-1/3 m-auto mt-8 mb-8 p-6 rounded-lg">
            <h1 class="text-white font-sans font-normal">OKUA</h1>
        </div>
        <form @submit.prevent="" class="login-form w-1/3 m-auto mt-8 border-2 p-6 rounded-sm">
            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-black font-bold text-right mb-1 mb-0 pr-4" for="inline-username">
                        Usuario
                    </label>
                </div>
                <div class="">
                    <input ref="usernameInput" v-model="username" @keyup.enter="$refs.passwordInput.focus()"
                           class="bg-grey-lighter appearance-none border-2 border-grey-lighter hover:border-orange rounded w-full py-2 px-4 text-grey-darker leading-tight"
                           id="inline-username" type="text" value="">
                </div>
            </div>
            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-black font-bold text-right mb-1 mb-0 pr-4" for="inline-password">
                        Contrase&ntilde;a
                    </label>
                </div>
                <div class="">
                    <input ref="passwordInput" v-model="pswd" @keyup.enter="dispatchAuthUser"
                           class="bg-grey-lighter appearance-none border-2 border-grey-lighter hover:border-orange rounded w-full py-2 px-4 text-grey-darker leading-tight"
                           id="inline-password" type="password" placeholder="******************">
                </div>
            </div>
            <div class="m-auto">
                <button @click="dispatchAuthUser"
                        class="pr-8 pl-8 shadow bg-blue hover:bg-blue-light text-white font-bold py-2 px-4 rounded"
                        type="button">
                    Login
                </button>
            </div>
        </form>
        <div class="w-1/3 m-auto text-center py-4 font-bold">
            <span class="text-blue-darker font-sans font-normal">&copy; 2018 Connect IT</span>
        </div>
    </div>
</template>

<script>
  import Loading from "vue-loading-overlay";

  import 'vue-loading-overlay/dist/vue-loading.min.css';
  import TokenUtils from "../../../js/utils/token-utils";
  import RouteUtils from "../../../js/utils/route-utils";
  import AlertUtils from "../../../js/utils/alert-utils";
  import UserService from "../../../js/services/user-service";


  const data = function () {
    return {
      username: '',
      pswd: '',
    };
  };

  const methods = {
    dispatchAuthUser() {
      this.$store.dispatch('setIsLoading');
      setTimeout(() => {
        this.authUser(this.username, this.pswd)
          .then(response => TokenUtils.setToken(response.token))
          .then(() => RouteUtils.goHome())
          .catch(error => {
            console.error(error);
            AlertUtils.showErrorWithAlert(error);
          })
          .then(() => this.$store.dispatch('unsetIsLoading'));
      }, 300);
    },

    async authUser(username, password) {
      let service = new UserService();
      return await service.auth(username, password);
    },
  };

  const computed = {
    isLoading() {
      return this.$store.state.section.isLoading;
    },
  };

  export default {
    data,
    methods,
    computed,

    name: "login-content",
    components: {
      Loading,
    },
    mounted() {
      this.$refs.usernameInput.focus();
    },
  }
</script>

<style scoped>
</style>