<template>
    <div class="w-full flex-inline">
        <button v-ripple class="bg-theme-color-4 hover:bg-theme-color-4-lighter rounded-sm" title="Validar CFDI">
            <font-awesome-icon :icon="iconCfdiValidate" class="w-8 h-8 p-2 text-white text-lg"/>
        </button>
        <button v-ripple class="bg-theme-color-4 hover:bg-theme-color-4-lighter rounded-sm mx-2" title="DESCARGAR PDF">
            <font-awesome-icon :icon="iconCfdiDownloadPdf" class="w-8 h-8 p-2 text-white text-lg"/>
        </button>
        <button v-ripple class="bg-theme-color-4 hover:bg-theme-color-4-lighter rounded-sm" title="DESCARGAR XML">
            <font-awesome-icon :icon="iconCfdiDownloadXml" class="w-8 h-8 p-2 text-white text-lg"/>
        </button>
    </div>
</template>
<script>

  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import {faCheckDouble, faFileExcel, faFilePdf} from '@fortawesome/free-solid-svg-icons';

  const computed = {
    iconCfdiValidate() {
      return faCheckDouble;
    },

    iconCfdiDownloadPdf() {
      return faFilePdf;
    },

    iconCfdiDownloadXml() {
      return faFileExcel;
    },
  };

  export default {
    computed,

    name: 'bills-info-table-cell-options',
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