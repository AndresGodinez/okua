<template>
    <div class="flex flex-col w-1/5 flex-no-shrink mt-4 relative h-full">
        <div class="text-center bg-theme-color-4 rounded-sm shadow-md py-4 px-4">
            <span class="font-bold uppercase text-white w-full">&Uacute;ltimos correos</span>
        </div>
        <div class="w-full flex flex-col overflow-y-auto">
            <div class="flex flex-col w-full shadow p-4 mt-2 bg-theme-color-1 hover:bg-theme-color-1-dark">
                        <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmail"
                                                                                  class="mr-2"/>carlos.hernandez@connectit.com.mx</span>
                <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmailTime"
                                                                          class="mr-2"/>2018-08-02 12:25:00</span>
            </div>

            <div class="flex flex-col w-full shadow p-4 mt-2 bg-theme-color-1 hover:bg-theme-color-1-dark">
                        <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmail"
                                                                                  class="mr-2"/>carlos.hernandez@connectit.com.mx</span>
                <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmailTime"
                                                                          class="mr-2"/>2018-08-02 12:25:00</span>
            </div>

            <div class="flex flex-col w-full shadow p-4 mt-2 bg-theme-color-1 hover:bg-theme-color-1-dark">
                        <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmail"
                                                                                  class="mr-2"/>carlos.hernandez@connectit.com.mx</span>
                <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmailTime"
                                                                          class="mr-2"/>2018-08-02 12:25:00</span>
            </div>

            <div class="flex flex-col w-full shadow p-4 mt-2 bg-theme-color-1 hover:bg-theme-color-1-dark">
                        <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmail"
                                                                                  class="mr-2"/>carlos.hernandez@connectit.com.mx</span>
                <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmailTime"
                                                                          class="mr-2"/>2018-08-02 12:25:00</span>
            </div>

            <div class="flex flex-col w-full shadow p-4 mt-2 bg-theme-color-1 hover:bg-theme-color-1-dark">
                        <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmail"
                                                                                  class="mr-2"/>carlos.hernandez@connectit.com.mx</span>
                <span class="break-words text-sm py-2"><font-awesome-icon :icon="iconReceivedEmailTime"
                                                                          class="mr-2"/>2018-08-02 12:25:00</span>
            </div>

            <div class="w-full mt-4">
                <button v-ripple
                        class="w-full text-center h-10 px-4 bg-theme-color-4 hover:bg-theme-color-4-lighter text-white rounded"
                        @click="goBills">
                    <font-awesome-icon :icon="iconGoBills"/>
                    <span class="ml-2 uppercase">Ir a facturas</span>
                </button>
            </div>
        </div>
    </div>
</template>
<script>
  import {faAt, faClock, faMoneyBill} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import RouteUtils from "../../../js/utils/route-utils";

  const methods = {
    goBills() {
      RouteUtils.goBills();
    },
  };

  const computed = {
    iconReceivedEmail() {
      return faAt;
    },

    iconReceivedEmailTime() {
      return faClock;
    },

    iconGoBills() {
      return faMoneyBill;
    },
  };

  export default {
    methods,
    computed,

    name: 'home-dashboard-last-emails-panel',
    components: {
      FontAwesomeIcon,
    }
  }
</script>