<template>
        <div class="text-left bg-theme-color-4 rounded-sm shadow-md py-4 px-4">
            <div class="flex flex-row">
                <span class="flex-1 w-full text-left text-white text-3xl font-semibold">Errores</span>
                <div class="inline-block border hover:bg-theme-color-4-dark rounded-sm px-6 py-2 cursor-pointer text-white disabled" @click="goErrors()">
                        <font-awesome-icon :icon="iconGoToErrors" />
                        <span class="ml-2 uppercase text-sm">Filtrar</span>
                </div>
            </div>

        </div>
</template>

<script>
  import RouteUtils from "../../../js/utils/route-utils";
  import {faFilter} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

  const methods = {
     goErrors() {
      //RouteUtils.goBills();
    },
  };

  const computed = {
     iconGoToErrors() {
      return faFilter;
    },
  };

  export default {
    methods,
    computed,

    name: 'error-panel-topbar',
    components: {
      FontAwesomeIcon,
    },
  }
</script>