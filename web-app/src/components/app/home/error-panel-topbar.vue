<template>
        <div class="text-left bg-theme-color-4 rounded-sm shadow-md py-4 px-4">
            <div class="flex flex-row">
                <span class="flex-1 w-full text-left text-white text-3xl font-semibold">Errores</span>
            </div>
        </div>
</template>

<script>
  import RouteUtils from "../../../js/utils/route-utils";
  import {faMoneyBill} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

  const methods = {
  };

  const computed = {
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