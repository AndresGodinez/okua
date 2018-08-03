<template>
    <div class="flex flex-row w-full justify-center mt-4">
        <div class="shadow-md bg-theme-color-1 relative p-4 w-1/3">
            <div class="absolute pin-t">
                <a class="no-underline p-4 text-3xl bg-theme-color-4 text-white shadow-md">
                    <font-awesome-icon :icon="iconBillstTotal"/>
                </a>
            </div>
            <div class="text-right text-grey-ligh text-sm tracking-wide uppercase select-none">Monto total
                en facturas
            </div>
            <div class="w-full flex justify-end">
                <animated-number
                        :value="billsTotal"
                        :duration="700"
                        :formatValue="formatTotalBills"
                        easing="easeInOutCubic"
                        class="text-right mb-6 text-theme-color-4 tracking-wide text-3xl pt-2 select-none"/>
            </div>
            <hr class="w-full border-b-2">
            <div class="text-left tracking-wide text-xs text-grey">&Uacute;ltima actualizaci&oacute;n:
                {{updatedDate}}
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

    async getBillsTotal(filter) {
      let service = new BillInfoService();
      let response = await service.getBillsTotal(filter);
      return response;
    },

    updateUpdatedDate() {
      this.updatedDate = moment().format('lll');
    },
  };

  const computed = {
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
      setTimeout(() => this.dispatchGetBillsTotal(), 50);
    },
  }
</script>
