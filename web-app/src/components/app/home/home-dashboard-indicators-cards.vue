<template>
    <div class="flex flex-row w-full justify-around mt-4 flex-no-shrink">
        <div class="shadow-md bg-theme-color-1 relative p-4 w-1/3 mx-4">
            <div class="absolute pin-t">
                <a class="no-underline p-4 text-3xl bg-theme-color-4 text-white shadow-md">
                    <font-awesome-icon :icon="iconBillstTotal" />
                </a>
            </div>
            <div class="text-right text-sm tracking-wide uppercase select-none">Monto total en facturas
            </div>
            <div class="w-full flex justify-end">
                <animated-number :value="billsTotal" :duration="700" :formatValue="formatTotalBills" easing="easeInOutCubic" class="text-right mb-6 text-theme-color-4 tracking-wide text-3xl pt-2 select-none" />
            </div>
            <hr class="w-full border-b-2">
            <div class="text-left tracking-wide text-xs text-grey">&Uacute;ltima actualizaci&oacute;n: {{updatedDate}}
            </div>
        </div>
        <div class="shadow-md bg-theme-color-1 relative p-4 w-1/3 mx-4">
            <div class="absolute pin-t">
                <a class="no-underline p-4 text-3xl bg-theme-color-2 text-white shadow-md">
                    <font-awesome-icon :icon="iconBillstTotal" />
                </a>
            </div>
            <div class="text-right text-sm tracking-wide uppercase select-none">Impuestos para traslado
            </div>
            <div class="w-full flex justify-end">
                <animated-number :value="billsTransferTotal" :duration="700" :formatValue="formatTotalBills" easing="easeInOutCubic" class="text-right mb-6 text-theme-color-2 tracking-wide text-3xl pt-2 select-none" />
            </div>
            <hr class="w-full border-b-2">
            <div class="text-left tracking-wide text-xs text-grey">&Uacute;ltima actualizaci&oacute;n: {{updatedDate}}
            </div>
        </div>
        <div class="shadow-md bg-theme-color-1 relative p-4 w-1/3 mx-4">
            <div class="absolute pin-t">
                <a class="no-underline p-4 text-3xl bg-theme-color-3 text-white shadow-md">
                    <font-awesome-icon :icon="iconBillstTotal" />
                </a>
            </div>
            <div class="text-right text-sm tracking-wide uppercase select-none">Impuestos para retención
            </div>
            <div class="w-full flex justify-end">
                <animated-number :value="billsWithheldTotal" :duration="700" :formatValue="formatTotalBills" easing="easeInOutCubic" class="text-right mb-6 text-theme-color-3 tracking-wide text-3xl pt-2 select-none" />
            </div>
            <hr class="w-full border-b-2">
            <div class="text-left tracking-wide text-xs text-grey">&Uacute;ltima actualizaci&oacute;n: {{updatedDate}}
            </div>
        </div>
    </div>
</template>

<script>
  import AnimatedNumber from "animated-number-vue"
  import moment from 'moment-es6';
  import {faMoneyBill} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import {formatMoney} from "accounting-js";
  import BillInfoService from "../../../js/services/bill-info-service";

  const data = function () {
    let updatedDate = moment().format('lll');

    return {
      updatedDate,

      billsTotal: 0,
      billsTransferTotal: 0,
      billsWithheldTotal: 0,

    };
  };

  const methods = {
    formatTotalBills(value) {
      return formatMoney(value, {precision: 2, thousand: ',', decimal: '.', symbol: '$'});
    },

    dispatchGetBillsTotal() {
      let filter = '';

      if (this.datetimeRangeFilter === 1) {
        filter = 'week';
      } else if (this.datetimeRangeFilter === 2) {
        filter = 'month';
      } else if (this.datetimeRangeFilter === 3) {
        filter = 'year';
      }

      this.getBillsTotal(filter)
        .then((response) => {
          this.billsTotal = response.total;
          this.updateUpdatedDate();
        });
    },

    dispatchGetBillsTransferTotal(){
      let filter = '';

      if (this.datetimeRangeFilter === 1) {
        filter = 'week';
      } else if (this.datetimeRangeFilter === 2) {
        filter = 'month';
      } else if (this.datetimeRangeFilter === 3) {
        filter = 'year';
      }

      this.getBillsTransferTotal(filter)
        .then((response) => {
          this.billsTransferTotal = response.total;
          this.updateUpdatedDate();
        });
    },

    dispatchGetBillsWithheldTotal(){
      let filter = '';

      if (this.datetimeRangeFilter === 1) {
        filter = 'week';
      } else if (this.datetimeRangeFilter === 2) {
        filter = 'month';
      } else if (this.datetimeRangeFilter === 3) {
        filter = 'year';
      }

      this.getBillsWithheldTotal(filter)
        .then((response) => {
          this.billsWithheldTotal = response.total;
          this.updateUpdatedDate();
        });
    },

    async getBillsTotal(filter) {
      let service = new BillInfoService();
      let response = await service.getBillsTotal(filter);
      return response;
    },

    async getBillsTransferTotal(filter) {
      let service = new BillInfoService();
      let response = await service.getBillsTransferTotal(filter);
      return response;
    },

    async getBillsWithheldTotal(filter) {
      let service = new BillInfoService();
      let response = await service.getBillsWithheldTotal(filter);
      return response;
    },

    updateUpdatedDate() {
      this.updatedDate = moment().format('lll');
    },
  };

  const computed = {
    forceUpdateByNewRegisters() {
      return this.$store.state.section.forceUpdateByNewRegisters;
    },

    datetimeRangeFilter() {
      return this.$store.state.section.datetimeRangeFilter;
    },

    iconBillstTotal() {
      return faMoneyBill;
    },
  };

  const watch = {
    datetimeRangeFilter() {
      this.dispatchGetBillsTotal();
      this.dispatchGetBillsTransferTotal();
      this.dispatchGetBillsWithheldTotal();
    },

    forceUpdateByNewRegisters() {
      this.dispatchGetBillsTotal();
      this.dispatchGetBillsTransferTotal();
      this.dispatchGetBillsWithheldTotal();
    },
  };

  export default {
    data,
    methods,
    computed,
    watch,

    name: 'home-dashboard-indicators-cards',
    components: {
      AnimatedNumber,
      FontAwesomeIcon,
    },
    mounted() {
      setTimeout(() => {
        this.dispatchGetBillsTotal();
        this.dispatchGetBillsTransferTotal();
        this.dispatchGetBillsWithheldTotal();
      } , 50);
    },
  }
</script>
