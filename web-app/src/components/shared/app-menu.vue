<!--suppress CheckEmptyScriptTag, HtmlUnknownTag -->
<template>
    <div v-if="open" class="fixed pin-t pin-l w-full h-full z-50">
        <div class="flex flex-row w-full h-full">
            <!--menu content-->
            <div class="h-full w-1/5 max-w-90vw flex flex-col bg-theme-color-1">
                <div class="text-center flex flex-col w-full mt-6 mb-4">
                    <span class="font-bold text-theme-color-4 text-4xl">OKUA</span>
                    <span class="border-b-2 border-grey-dark mx-6 mt-2"></span>
                </div>

                <div class="text-center w-full uppercase text-center font-bold text-xl">
                    <button class="w-full hover:bg-grey-light h-16" @click="goHome()">Inicio</button>
                </div>
                <hr class="w-full border-t-2 border-grey-darker m-0"/>
                <div class="text-center w-full uppercase text-center font-bold text-xl">
                    <button class="w-full hover:bg-grey-light h-16" @click="goBills()">Facturas</button>
                </div>
                <hr class="w-full border-t-2 border-grey-darker m-0"/>
                <div class="text-center w-full uppercase text-center font-bold text-xl">
                    <button class="w-full hover:bg-grey-light h-16" @click="goMovements()">Movimientos</button>
                </div>
                <hr class="w-full border-t-2 border-grey-darker m-0"/>
            </div>

            <!--grey overlay-->
            <div class="flex-grow bg-grey-darker opacity-50" @click="$store.dispatch('toggleSidebar')"></div>
        </div>
    </div>
</template>

<script>
  import RouteUtils from "../../js/utils/route-utils";

  const data = function () {
    return {};
  };

  const methods = {
    goHome() {
      RouteUtils.goHome();
    },

    goBills() {
      RouteUtils.goBills();
    },

    goMovements() {
      RouteUtils.goBills();
    }
  };

  const computed = {
    open() {
      return this.$store.state.menu.sidebarOpen;
    },
  };

  export default {
    data,
    methods,
    computed,

    name: 'app-menu',
  }
</script>

<style scoped>
</style>
