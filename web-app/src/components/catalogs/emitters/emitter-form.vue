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
                <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
                  Emisor
                </label>
                <input
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                   id="name" type="text" placeholder="Username" v-model="name">
              </div>
              <div class="mb-4 ">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="rfc">
                  RFC
                </label>
                <input
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                   id="rfc" type="text" placeholder="rfc" v-model="rfc">
              </div>
              <div class="mb-4 ">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                  Email
                </label>
                <input
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                   id="email" type="text" placeholder="rfc" v-model="email">
              </div>
              <div class="flex items-center justify-between">
                <button
                   class="bg-red hover:bg-red-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                   type="button" @click="goToEmittersIndex">
                  Cancelar
                </button>
                <button
                   class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                   type="button" @click="saveData">
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
  import FloatLabel from "vue-float-label/components/FloatLabel";
  import AppUtils from "../../../js/utils/app-utils";

  const data = function () {
    let id = '';
    let name = '';
    let rfc = '';
    let email = '';
    return {
      id,
      name,
      rfc,
      email
    };
  };

  const methods = {
    async saveData() {
      let data = {
        name : this.name,
        rfc : this.rfc,
        email : this.email
      };

      if(this.registerId === 0) {
        let createNewEmitter = await this.$store.state.emitterStore.emitterService.create(data);
        RouteUtils.adminSections('/emitters');
      }

      let resposneDateUpdate = await this.$store.state.emitterStore.emitterService.updateData(this.registerId,data);
      RouteUtils.adminSections('/emitters');
    },
    goToEmittersIndex() {
      RouteUtils.adminSections('/emitters');
    },
    async getUserData() {
      if (this.registerId === 0)
        return true;

      let dataEmitter = await this.$store.state.emitterStore.emitterService.getById(this.registerId);

      this.id = dataEmitter.id;
      this.name = dataEmitter.name;
      this.rfc = dataEmitter.rfc;
      this.email = dataEmitter.email;

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
      FloatLabel,
    },
    mounted() {
      const registerId = Number(AppUtils.getIdMeta());
      this.registerId = registerId;
      this.getUserData();
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