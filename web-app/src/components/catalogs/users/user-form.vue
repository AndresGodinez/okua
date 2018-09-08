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
                <float-label>
                  <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Nombre" v-model="atest">
                </float-label>
                <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
                  Nombre
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Nombre" v-model="name">
              </div>
              <div class="mb-4 ">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="userName">
                  Nombre de usuario
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="userName" type="text" placeholder="Nombre de usuario" v-model="userName">
              </div>
              <div class="mb-4 ">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                  Correo electrónico
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email@email.com" v-model="email">
              </div>
              <div class="mb-4 ">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="pswd">
                  Contraseña
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" id="pswd" type="password" placeholder="*********" v-model="pswd">
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
  import FloatLabel from "vue-float-label/components/FloatLabel";


  const data = function () {
    let name = '',
       username = '',
       email = '',
       pswd = '',
       regStatus = 0;
    let registerId = 0;
    return {
      name,
      username,
      email,
      pswd,
      regStatus,
      registerId
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
      let userData = await this.$store.state.userStore.userService.getById(id);
      this.name = userData.name;
      this.username = userData.username;
      this.email = userData.email;
      this.pswd = userData.pswd;
      this.regStatus = userData.regStatus;
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
      FloatLabel
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