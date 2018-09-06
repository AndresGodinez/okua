<template>
    <div class="flex flex-col max-h-screen">
        <loading-overlay></loading-overlay>

        <app-menu selected="admin"></app-menu>

        <app-navbar></app-navbar>

        <div class="flex flex-row w-full px-8">
            <div class="flex flex-col flex-grow px-4 max-h-full overflow-y-auto overflow-hidden items-center pt-4">
                <div class="text-left bg-theme-color-4 rounded-sm shadow-md py-4 px-4 w-2/5">
                    <div class="flex flex-row">
                        <span class="flex-1 w-full text-left text-white text-3xl font-semibold">Configuraci&oacute;n del Servicio de Correos</span>
                    </div>
                </div>

                <div class="flex flex-row justify-center flex-no-shrink mb-3 w-2/5">
                    <div class="w-full">
                        <form
                                @submit.prevent=""
                                class="bg-white shadow-md rounded-b-sm px-8 pt-6 pb-8 mb-4">
                            <div class="mb-4 pt-4">
                                <float-label class="text-2xl">
                                    <input
                                            id="okua-form-hostname"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline text-lg"
                                            placeholder="Host del servidor de correos"
                                            type="text"
                                            v-model="hostname"
                                            name="hostname">
                                </float-label>
                            </div>

                            <div class="mb-4 pt-4">
                                <float-label class="text-2xl">
                                    <input
                                            id="okua-form-username"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline text-lg"
                                            placeholder="Usuario"
                                            type="text"
                                            v-model="username"
                                            name="username">
                                </float-label>
                            </div>

                            <div class="mb-4 pt-4">
                                <float-label class="text-2xl">
                                    <input
                                            id="okua-form-pswd"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline text-lg"
                                            placeholder="Contraseña"
                                            type="password"
                                            v-model="pswd"
                                            name="password">
                                </float-label>
                            </div>

                            <div class="flex justify-end">
                                <button v-ripple
                                        type="button"
                                        class="text-left h-16 px-4 bg-theme-color-3 hover:bg-theme-color-3-lighter text-white rounded"
                                        @click="dispatchSaveData">
                                    <font-awesome-icon :icon="iconSaveBtn"/>
                                    <span class="ml-2 uppercase">Guardar</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import FloatLabel from "vue-float-label/components/FloatLabel";
  import {faSave} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import AlertUtils from "../../../js/utils/alert-utils";
  import AdminConfigService from "../../../js/services/admin-config-service";
  import {delay} from "../../../js/utils/app-utils";
  import LoadingOverlay from "../../shared/loading-overlay";
  import {mapActions} from "vuex";

  const data = function () {
    let hostname = '';
    let username = '';
    let pswd = '';

    return {
      hostname,
      username,
      pswd,
    };
  };

  const methods = {
    ...mapActions([
      'showLoading',
      'hideLoading',
    ]),

    dispatchSaveData() {
      this.showLoading();

      let hostname = this.hostname;
      let username = this.username;
      let pswd = this.pswd;

      this.saveData(hostname, username, pswd)
        .then(response => AlertUtils.showSuccessAlert(response.msg))
        .catch(error => AlertUtils.showApiErrorMsgAlert(error))
        .then(async () => {
          await delay(500);
          await this.loadData();
        })
        .then(() => this.hideLoading());
    },

    async saveData(hostname, username, pswd) {
      let service = new AdminConfigService();
      return await service.updateEmailConfigService(hostname, username, pswd);
    },

    dispatchLoadData() {
      this.loadData()
        .then((response) => {
          this.hostname = response.hostname;
          this.username = response.username;
        })
        .then(() => this.hideLoading());
    },

    async loadData() {
      let service = new AdminConfigService();
      return await service.readEmailConfigService();
    },
  };

  const computed = {
    iconSaveBtn() {
      return faSave;
    },
  };

  export default {
    data,
    methods,
    computed,

    name: "config-email-service-content",
    components: {
      LoadingOverlay,
      AppNavbar,
      AppMenu,
      FloatLabel,
      FontAwesomeIcon,
    },
    mounted() {
      this.showLoading();
      delay(200).then(() => this.dispatchLoadData());
    },
  }
</script>
<style scoped>
</style>