<template>
    <div class="flex flex-col">
        <app-menu selected="home"></app-menu>

        <app-navbar></app-navbar>

        <div class="container w-full mx-auto">
            <div class="inline-flex mt-4 mb-2">
                <ul class="list-reset flex">
                    <li>
                        <div class="inline-block border border-theme-color-4 rounded-l px-4 py-2 cursor-pointer"
                             :class="[rangeFilter === 1 ? 'bg-theme-color-4 text-white' : 'text-theme-color-4-darker']"
                             @click="rangeFilter = 1">Semana
                        </div>
                    </li>
                    <li>
                        <div class="inline-block border border-theme-color-4 px-4 py-2 cursor-pointer"
                             :class="[rangeFilter === 2 ? 'bg-theme-color-4 text-white' : 'text-theme-color-4-darker']"
                             @click="rangeFilter = 2">Mes
                        </div>
                    </li>
                    <li>
                        <div class="inline-block border border-theme-color-4 rounded-r px-4 py-2 cursor-pointer"
                             :class="[rangeFilter === 3 ? 'bg-theme-color-4 text-white' : 'text-theme-color-4-darker']"
                             @click="rangeFilter = 3">Año
                        </div>
                    </li>
                </ul>
            </div>

            <div class="flex flex-row w-full justify-center mt-4">
                <div class="shadow-md bg-theme-color-1 relative p-4 w-1/3">
                    <div class="absolute pin-t">
                        <a class="no-underline p-4 text-3xl bg-theme-color-4 text-white shadow-md">
                            <font-awesome-icon :icon="iconBillstTotal" />
                        </a>
                    </div>
                    <div class="text-right text-grey-ligh text-sm tracking-wide uppercase select-none">Monto total en facturas</div>
                    <div class="w-full flex justify-end">
                        <animated-number
                                :value="totalBills"
                                :duration="700"
                                :formatValue="formatTotalBills"
                                easing="easeInOutCubic"
                                class="text-right mb-6 text-theme-color-4 tracking-wide text-3xl pt-2 select-none" />
                    </div>
                    <hr class="w-full border-b-2">
                    <div class="text-left tracking-wide text-xs text-grey">&Uacute;ltima actualizaci&oacute;n: {{updatedDate}}</div>
                </div>
            </div>

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

            <table-group-by-client v-if="groupFilter === 1" />
            <table-group-by-cfdi-use v-else-if="groupFilter === 2" />
            <table-group-by-email v-else-if="groupFilter === 3" />
        </div>
    </div>
</template>
<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import {faMoneyBill, faUsers, faBoxes, faThLarge} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import moment from 'moment-es6';
  import AnimatedNumber from "animated-number-vue";
  import {formatMoney} from "accounting-js";
  import TableGroupByClient from "./table-group-by-client";
  import TableGroupByCfdiUse from "./table-group-by-cfdi-use";
  import TableGroupByEmail from "./table-group-by-email";

  const data = function () {
    let updatedDate = moment().format('lll');
    return {
      updatedDate,
      totalBills: 0,

      rangeFilter: 1,
      groupFilter: 1,
    };
  };

  const methods = {
    formatTotalBills(value) {
      return formatMoney(value, { precision: 2, thousand: ',', decimal: '.', symbol: '$' });
    },
  };

  const computed = {
    iconBillstTotal() {
      return faMoneyBill;
    },

    iconGroupByClient() {
      return faUsers;
    },
    iconGroupByCfdiUse() {
      return faBoxes;
    },
    iconGroupByEmail() {
      return faThLarge;
    },
  };

  export default {
    data,
    methods,
    computed,

    name: "home-content",
    components: {
      TableGroupByEmail,
      TableGroupByCfdiUse,
      TableGroupByClient,
      AppNavbar,
      AppMenu,
      FontAwesomeIcon,
      AnimatedNumber,
    },
    mounted() {
      setTimeout(() => this.totalBills = 1000, 1000);
    },
  }
</script>
<style scoped>
</style>