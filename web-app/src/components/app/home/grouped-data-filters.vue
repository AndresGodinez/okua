<template>
    <div class="flex flex-col w-full mt-16 shadow-md">
        <div class="text-left bg-theme-color-4 rounded-sm shadow-md py-4 px-4">
            <span class="w-full text-left text-white text-3xl font-semibold">Informaci&oacute;n por categorías</span>
            <div class="w-full inline-flex mt-4">
                <ul class="list-reset flex">
                    <li class="mr-3">
                        <div class="inline-block border hover:bg-theme-color-4-dark rounded-sm px-6 py-2 cursor-pointer text-white"
                             :class="[groupFilter === 1 ? 'bg-theme-color-4-darker border-theme-color-4-darker' : 'border-white']"
                             @click="setGroupFilter(1)">
                            <font-awesome-icon :icon="iconGroupByClient"/>
                            <span class="ml-2 uppercase text-sm">Cliente</span>
                        </div>
                    </li>
                    <li class="mr-3 disabled" :disabled="true">
                        <div class="inline-block border hover:bg-theme-color-4-dark rounded-sm px-6 py-2 cursor-pointer text-white disabled"
                             :class="[groupFilter === 2 ? 'bg-theme-color-4-darker border-theme-color-4-darker' : 'border-white']"
                             @click="">
                            <font-awesome-icon :icon="iconGroupByCfdiUse"/>
                            <span class="ml-2 uppercase text-sm">Uso CFDI</span>
                        </div>
                    </li>
                    <li class="mr-3 disabled" :disabled="true">
                        <div class="inline-block border hover:bg-theme-color-4-dark rounded-sm px-6 py-2 cursor-pointer text-white disabled"
                             :class="[groupFilter === 3 ? 'bg-theme-color-4-darker border-theme-color-4-darker' : 'border-white']"
                             @click="">
                            <font-awesome-icon :icon="iconGroupByEmail"/>
                            <span class="ml-2 uppercase text-sm">E-MAIL</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
  import {faBoxes, faEnvelope, faUsers} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

  const methods = {
    setGroupFilter(value) {
      this.$store.dispatch('changeGroupedDataFilter', value);
    },
  };

  const computed = {
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

    name: 'grouped-data-filters',
    components: {
      FontAwesomeIcon
    },
  }
</script>