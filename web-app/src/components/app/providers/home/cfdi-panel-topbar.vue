<template>
        <div class="text-left bg-theme-color-4 rounded-sm shadow-md py-4 px-4">
            <div class="flex flex-row">
                <span class="flex-1 w-full text-left text-white text-3xl font-semibold">Últimas Facturas</span>
                <div class="inline-block border hover:bg-theme-color-4-dark rounded-sm px-6 py-2 cursor-pointer text-white disabled" :class="[groupFilter === 2 ? 'bg-theme-color-4-darker border-theme-color-4-darker' : 'border-white']" @click="goBills()">
                    <font-awesome-icon :icon="iconGroupByCfdiUse" />
                    <span class="ml-2 uppercase text-sm">Ir a facturas</span>
                </div>
            </div>
        </div>
</template>

<script>
  import RouteUtils from "../../../../js/utils/route-utils";
  import {faBoxes, faEnvelope, faUsers} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

  const methods = {
    setGroupFilter(value) {
      this.$store.dispatch('changeGroupedDataFilter', value);
    },
  };

  const computed = {
    goBills() {
      RouteUtils.goBills();
    },

    groupFilter() {
      return this.$store.state.section.groupedDataFilter;
    },

    iconGroupByClient() {
      return faUsers;
    },
    iconGroupByCfdiUse() {
      return faBoxes;
    },
    iconGroupByEmail() {
      return faEnvelope;
    },
  };

  export default {
    methods,
    computed,

    name: 'cfdi-panel-topbar',
    components: {
      FontAwesomeIcon
    },
  }
</script>