<template>
  <div class="flex flex-col max-h-screen">
    <app-menu selected="admin"></app-menu>

    <app-navbar></app-navbar>
    <SubVavBar></SubVavBar>
    <loading-overlay></loading-overlay>

    <div class="flex flex-row w-full px-8 py-4 justify-center">
      <div class="flex flex-col flex-grow px-4 max-h-full overflow-y-auto overflow-hidden">
        <div class="flex flex-row justify-center flex-no-shrink my-3">
          <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
              <div class="mb-4 ">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="alert-response">
                  Alerta de respuesta código: {{code}}
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="alert-response" rows="5" placeholder="Alerta de Respuesta" v-model="internalMsg">
                </textarea>
              </div>
              <div class="mb-4 ">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="email-response">
                  Mensaje de correo
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="email-response" rows="5" placeholder="Mensaje de email" v-model="emailMsg">
                </textarea>
              </div>

              <div class="flex items-center justify-between">
                <button class="bg-red hover:bg-red-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="goToAlertEmailIndex">
                  Cancelar
                </button>
                <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="saveData">
                  Guardar
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
  import SubVavBar from "../catalogsNav/nav";
  import RouteUtils from "../../../js/utils/route-utils";
  import AppUtils from "../../../js/utils/app-utils";
  import LoadingOverlay from "../../shared/loading-overlay";
  import {mapActions} from "vuex";

  const data = function () {
    let id = 0;
    let code = 0;
    let internalMsg = '';
    let emailMsg = "";
    return {
      internalMsg,
      id,
      code,
      emailMsg
    };
  };

  const methods = {
    ...mapActions([
      'showLoading',
      'hideLoading',
    ]),
    async saveData() {
      this.showLoading();
      let data = {
        internalMsg : this.internalMsg,
        code : this.code,
        emailMsg : this.emailMsg
      };
      let alertEmailResponse = await this.$store.state.alertEmailResponseStore.alertEmailResponseService.updateData(this.registerId, data);
      RouteUtils.adminSections('/alert-email-responses');
    },
    goToAlertEmailIndex() {
      RouteUtils.adminSections('/alert-email-responses');
    },
    async getDataAlertEmailResponses(id) {
      let alertEmailResponse = await this.$store.state.alertEmailResponseStore.alertEmailResponseService.getById(id);
      this.internalMsg = alertEmailResponse.internalMsg;
      this.code = alertEmailResponse.code;
      this.emailMsg = alertEmailResponse.emailMsg;
      this.id = alertEmailResponse.id;
      this.hideLoading();
    },
  };
  export default {
    data,
    methods,
    internalMsg: "alert-email-response-form",
    components: {
      AppNavbar,
      AppMenu,
      SubVavBar,
      LoadingOverlay
    },
    mounted() {
      this.showLoading();
      const registerId = Number(AppUtils.getIdMeta());
      this.registerId = registerId;
      this.getDataAlertEmailResponses(this.registerId);
    },
  }
</script>
<style scoped>
  /* width */
  ::-webkit-scrollbar {
    width: 10px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.0);
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: rgba(180, 180, 180, 0.8);
  }
</style>