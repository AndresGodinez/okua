<template>
    <div class="w-full flex-inline">
        <button v-ripple class="bg-theme-color-4 hover:bg-theme-color-4-lighter rounded-sm mx-2" title="VER">
            <font-awesome-icon :icon="iconEye" class="w-8 h-8 p-2 text-white text-lg" @click="watchWarning()"/>
        </button>
    </div>
</template>
<script>

  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import {faEye, faFileExcel, faFilePdf} from '@fortawesome/free-solid-svg-icons';
  import AlertUtils from '../../../js/utils/alert-utils.js';

  const methods = {
    watchWarning() {
      let description = this.row.description;
      
      AlertUtils.showAlert(description, 'Alerta', 'info');
    },
  };

  const computed = {
    iconEye() {
      return faEye;
    },
  };

  export default {
    methods,
    computed,

    name: 'warning-panel-cell-options',
    props: {
      row: {
        type: Object,
        required: true,
      },
    },
    components: {
      FontAwesomeIcon,
    }
  }
</script>
<style scoped>
    input[type='checkbox'] {
        display: none;
    }

</style>