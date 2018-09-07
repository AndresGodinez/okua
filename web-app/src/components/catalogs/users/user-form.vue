<template>
  <div class="flex flex-col max-h-screen">
    <app-menu selected="admin"></app-menu>

    <app-navbar></app-navbar>
    <SubVavBar></SubVavBar>

    <div class="flex flex-row w-full px-8 py-4 justify-center">
      <div class="flex flex-col flex-grow px-4 max-h-full overflow-y-auto overflow-hidden">
        <div class="flex flex-row justify-center flex-no-shrink my-3">
          <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
              <div class="mb-4 ">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                  Emisor
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Emisor" v-model="name">
              </div>
              <div class="mb-6 inline-block">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                  Estado
                </label>
                <input class=" border border-red rounded w-full    focus:outline-none focus:shadow-outline" id="password" type="checkbox" v-model="regStatus">
              </div>
              <div class="flex items-center justify-between">
                <button class="bg-red hover:bg-red-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="goToIndex">
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

  const data = function () {
    let name = '';
    let regStatus = 0;
    let registerId = 0;
    return {
      name,
      regStatus,
      registerId,
    };
  };

  const methods = {
    saveData() {
    },
    goToIndex() {
      RouteUtils.adminSections('/emitters');
    },
    async getDataEmitter() {
      let id = localStorage.userToEdit;
      let userData = await this.$store.state.emitterStore.emitterService.getById(id);
      this.name = userData.name;
      this.regStatus = userData.regStatus;
    },
  };
  export default {
    data,
    methods,
    name: "emitter-form",
    components: {
      AppNavbar,
      AppMenu,
      SubVavBar,
    },
    mounted() {
      const registerId = Number(AppUtils.getIdMeta());
      this.registerId = registerId;
      this.getDataEmitter();
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