<template>
    <div class="flex flex-col w-1/5 flex-no-shrink mt-4 relative h-full">
        <div class="text-center bg-theme-color-4 rounded-sm shadow-md py-4 px-4">
            <span class="font-bold uppercase text-white w-full">&Uacute;ltimos correos</span>
        </div>
        <div class="w-full flex flex-col overflow-y-auto">
            <div v-for="item in lastEmailsData"
                 class="flex flex-col w-full shadow p-4 mt-2 bg-theme-color-1 hover:bg-theme-color-1-dark">
                <span class="break-words text-sm py-2">
                    <font-awesome-icon :icon="iconReceivedEmail" class="mr-2"/>
                    {{item.email}}
                </span>

                <span class="break-words text-sm py-2">
                    <font-awesome-icon :icon="iconReceivedEmailTime" class="mr-2"/>
                    {{item.emailDatetime}}
                </span>
            </div>
        </div>
    </div>
</template>
<script>
  import {faAt, faClock, faMoneyBill} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import RouteUtils from "../../../js/utils/route-utils";
  import BillInfoService from "../../../js/services/bill-info-service";

  const data = function () {
    let lastEmailsData = [];
    return {
      lastEmailsData,
    };
  };

  const methods = {
    dispatchGetLastEmails() {
      this.getLastEmails()
        .then(response => {
          let newData = response.data;

          if (!!newData && !!this.lastEmailsData && newData.length > 0 && this.lastEmailsData.length > 0) {
            let oldItem = this.lastEmailsData[0];
            let newItem = newData[0];

            if (oldItem.email !== newItem.email || oldItem.emailDatetime !== newItem.emailDatetime) {
              this.$store.dispatch('toggleForceUpdateByNewRegisters');
            }
          } else if (!!newData && (!this.lastEmailsData || !this.lastEmailsData.length)) {
            this.$store.dispatch('toggleForceUpdateByNewRegisters');
          }

          this.lastEmailsData = response.data;
        });
    },

    async getLastEmails(limit = 5) {
      let service = new BillInfoService();
      return await service.getLastRegisters(limit);
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
    data,
    methods,
    computed,

    name: 'home-dashboard-last-emails-panel',
    components: {
      FontAwesomeIcon,
    },
    mounted() {
      setTimeout(() => {
        this.dispatchGetLastEmails();

        setInterval(() => {
          this.dispatchGetLastEmails();
        }, 10000);
      }, 500);
    },
  }
</script>