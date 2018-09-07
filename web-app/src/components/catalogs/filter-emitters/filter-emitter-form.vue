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
                <label class="block text-grey-darker text-sm font-bold mb-2" for="rfcEmitter">
                  RFC
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="rfcEmitter" type="text" placeholder="Username" v-model="rfc">
              </div>
              <div class="mb-6 inline-block">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="valid">
                  Estado
                </label>
                <input class=" border border-red rounded w-full    focus:outline-none focus:shadow-outline" id="valid" type="checkbox" v-model="valid">
              </div>
              <div class="flex items-center justify-between">
                <button class="bg-red hover:bg-red-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="goToFilterEmittersIndex">
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
    let id = '';
    let rfc = '';
    let valid = '';
    
    return {
      id,
      rfc,
      valid,
    };
  };

  const methods = {
    ...mapActions([
      'showLoading',
      'hideLoading',
    ]),
    async saveData() {
      this.showLoading();
      if(this.valid === true || this.valid === 1) {
        this.valid = 1;
      }else{
        this.valid =0;
      }
      let data = {
        rfc : this.rfc,
        valid : this.valid
      };
      let responseFromApi = '';
      if(this.registerId === 0) {
        responseFromApi = await this.$store.state.filterEmitterStore.filterEmitterService.create(data);
      }else{
        responseFromApi = await this.$store.state.filterEmitterStore.filterEmitterService.updateData(this.id, data);
      }
      RouteUtils.adminSections("/filter-emitters")
    },
    goToFilterEmittersIndex() {
      RouteUtils.adminSections('/filter-emitters');
    },
    async getFilterEmitterData() {
      if(this.registerId === 0) {
        return true;
      }
      let filterEmitterData = await this.$store.state.filterEmitterStore.filterEmitterService.getById(this.registerId);
      this.id = filterEmitterData.id;
      this.rfc = filterEmitterData.rfc;
      this.valid = filterEmitterData.valid;
      this.hideLoading();
    },
  };
  export default {
    data,
    methods,
    name: "user-form",
    components: {
      AppNavbar,
      AppMenu,
      SubVavBar,
      LoadingOverlay,
    },
    mounted() {
      this.showLoading();
      const registerId = Number(AppUtils.getIdMeta());
      this.registerId = registerId;
      this.getFilterEmitterData();
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