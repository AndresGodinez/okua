<template>
    <div class="flex flex-col">
        <app-menu selected="home"></app-menu>

        <app-navbar></app-navbar>

        <div class="flex flex-row w-full px-8">
            <div class="flex flex-col flex-grow px-4">
                <datetime-range-filters />

                <home-dashboard-indicators-cards />

                <div class="flex flex-col w-full mt-16 shadow-md">
                    <div class="text-left bg-theme-color-4 rounded-sm shadow-md py-4 px-4">
                        <span class="w-full text-left text-white text-3xl font-semibold">Informaci&oacute;n por categorías</span>
                        <div class="w-full inline-flex mt-4">
                            <ul class="list-reset flex">
                                <li class="mr-3">
                                    <div class="inline-block border hover:bg-theme-color-4-dark rounded-sm px-6 py-2 cursor-pointer text-white"
                                         :class="[groupFilter === 1 ? 'bg-theme-color-4-darker border-theme-color-4-darker' : 'border-white']"
                                         @click="groupFilter = 1">
                                        <font-awesome-icon :icon="iconGroupByClient"/>
                                        <span class="ml-2 uppercase text-sm">Cliente</span>
                                    </div>
                                </li>
                                <li class="mr-3">
                                    <div class="inline-block border hover:bg-theme-color-4-dark rounded-sm px-6 py-2 cursor-pointer text-white"
                                         :class="[groupFilter === 2 ? 'bg-theme-color-4-darker border-theme-color-4-darker' : 'border-white']"
                                         @click="groupFilter = 2">
                                        <font-awesome-icon :icon="iconGroupByCfdiUse"/>
                                        <span class="ml-2 uppercase text-sm">Uso CFDI</span>
                                    </div>
                                </li>
                                <li class="mr-3">
                                    <div class="inline-block border hover:bg-theme-color-4-dark rounded-sm px-6 py-2 cursor-pointer text-white"
                                         :class="[groupFilter === 3 ? 'bg-theme-color-4-darker border-theme-color-4-darker' : 'border-white']"
                                         @click="groupFilter = 3">
                                        <font-awesome-icon :icon="iconGroupByEmail"/>
                                        <span class="ml-2 uppercase text-sm">E-MAIL</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <table-group-by-client v-if="groupFilter === 1"/>
                <table-group-by-cfdi-use v-else-if="groupFilter === 2"/>
                <table-group-by-email v-else-if="groupFilter === 3"/>
            </div>

            <div class="w-1 h-full border-l-2 border-grey-red">
            </div>

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
        </div>
    </div>
</template>
<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import {faAt, faBoxes, faClock, faEnvelope, faMoneyBill, faUsers} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import TableGroupByClient from "./table-group-by-client";
  import TableGroupByCfdiUse from "./table-group-by-cfdi-use";
  import TableGroupByEmail from "./table-group-by-email";
  import RouteUtils from "../../../js/utils/route-utils";
  import DatetimeRangeFilters from "./datetime-range-filters";
  import HomeDashboardIndicatorsCards from "./HomeDashboardIndicatorsCards";

  const data = function () {
    return {
      groupFilter: 1,
    };
  };

  const methods = {
    goBills() {
      RouteUtils.goBills();
    },
  };

  const computed = {
    iconGroupByClient() {
      return faUsers;
    },
    iconGroupByCfdiUse() {
      return faBoxes;
    },
    iconGroupByEmail() {
      return faEnvelope;
    },

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
    data,
    methods,
    computed,

    name: "home-content",
    components: {
      HomeDashboardIndicatorsCards,
      DatetimeRangeFilters,
      TableGroupByEmail,
      TableGroupByCfdiUse,
      TableGroupByClient,
      AppNavbar,
      AppMenu,
      FontAwesomeIcon,
      },
    mounted() {
    },
  }
</script>
