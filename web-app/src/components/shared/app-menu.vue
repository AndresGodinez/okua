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

                <div class="w-full uppercase text-center font-bold text-xl px-6">
                    <button class="text-left w-full h-16 px-4" :class="[selected === 'home' ? 'text-white bg-theme-color-3 hover:bg-theme-color-3-dark rounded-sm shadow-md' : 'text-grey-darker hover:bg-grey-light']" @click="goHome()">
                        <font-awesome-icon :icon="iconMenuHome" />
                        <span class="ml-2 uppercase">Inicio</span>
                    </button>
                </div>

                <div class="w-full uppercase text-center font-bold text-xl px-6 mt-2">
                    <button class="text-left w-full h-16 px-4" :class="[selected === 'bills' ? 'text-white bg-theme-color-3 hover:bg-theme-color-3-dark rounded-sm shadow-md' : 'text-grey-darker hover:bg-grey-light']" @click="goBills()">
                        <font-awesome-icon :icon="iconMenuBills" />
                        <span class="ml-2 uppercase">Facturas</span>
                    </button>
                </div>

                <!--<div class="w-full uppercase text-center font-bold text-xl px-6 mt-2">-->
                    <!--<button class="text-left w-full hover:bg-grey-light h-16 px-4" :class="[selected === 'movements' ? 'text-white bg-theme-color-3 hover:bg-theme-color-3-dark rounded-sm shadow-md' : 'text-grey-darker hover:bg-grey-light']" @click="goMovements()">-->
                        <!--<font-awesome-icon :icon="iconMenuMovements" />-->
                        <!--<span class="ml-2 uppercase">Movimientos</span>-->
                    <!--</button>-->
                <!--</div>-->
            </div>

            <!--grey overlay-->
            <div class="flex-grow bg-grey-darker opacity-50" @click="$store.dispatch('toggleSidebar')"></div>
        </div>
    </div>
</template>

<script>
  import RouteUtils from "../../js/utils/route-utils";
  import {faHome, faMoneyBill, faExchangeAlt} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

  const props = {
    selected: {
      type: String,
      required: true,
    },
  };

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

    iconMenuHome() {
      return faHome;
    },

    iconMenuBills() {
      return faMoneyBill;
    },

    iconMenuMovements() {
      return faExchangeAlt;
    },
  };

  export default {
    props,
    data,
    methods,
    computed,

    name: 'app-menu',
    components: {
      FontAwesomeIcon,
    }
  }
</script>

<style scoped>
</style>
