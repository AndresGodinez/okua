<template>
    <div class="w-full flex-inline">
        <div class="inline bg-transparent border-0" :title="iconCfdiValidateTitle">
            <font-awesome-icon :icon="iconCfdiValidate" class="w-8 h-8 p-2 text-lg border-0" :class="iconCfdiValidateClass"/>
        </div>
        <button v-if="row.hasPdf === 1" v-ripple class="bg-theme-color-4 hover:bg-theme-color-4-lighter rounded-sm mx-2" title="DESCARGAR PDF">
            <font-awesome-icon :icon="iconCfdiDownloadPdf" class="w-8 h-8 p-2 text-white text-lg" @click="downloadPdf"/>
        </button>
        <button v-ripple class="bg-theme-color-4 hover:bg-theme-color-4-lighter rounded-sm" title="DESCARGAR XML">
            <font-awesome-icon :icon="iconCfdiDownloadXml" class="w-8 h-8 p-2 text-white text-lg" @click="downloadXml"/>
        </button>
    </div>
</template>
<script>

  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import {faCircle, faFileExcel, faFilePdf} from '@fortawesome/free-solid-svg-icons';
  //import {BILL_INFO_STAMP_STATUSES} from "../../../js/utils/models-utils";

  const methods = {
    downloadXml() {
      let id = this.row.id;
      window.open(`/api/warning-info/${id}/xml`);
    },

    downloadPdf() {
      let id = this.row.id;
      window.open(`/api/warning-info/${id}/pdf`);
    },
  };

  const computed = {
    iconCfdiValidate() {
      return faCircle;
    },

    iconCfdiDownloadPdf() {
      return faFilePdf;
    },

    iconCfdiDownloadXml() {
      return faFileExcel;
    },

    iconCfdiValidateClass() {
      /*
      if (this.row.stampStatus === WARNING_INFO_STAMP_STATUSES.NOT_DEFINED) {
        return 'text-grey';
      } else if (this.row.stampStatus === WARNING_INFO_STAMP_STATUSES.ACTIVE) {
        return 'text-green';
      } else if (this.row.stampStatus === WARNING_INFO_STAMP_STATUSES.NOT_FOUND) {
        return 'text-yellow';
      } else if (this.row.stampStatus === WARNING_INFO_STAMP_STATUSES.CANCELED) {
        return 'text-red';
      }
*/
      return 'text-white';
    },

    iconCfdiValidateTitle() {
      /*if (this.row.stampStatus === WARNING_INFO_STAMP_STATUSES.NOT_DEFINED) {
        return 'NO DEFINIDO';
      } else if (this.row.stampStatus === WARNING_INFO_STAMP_STATUSES.ACTIVE) {
        return 'ACTIVO';
      } else if (this.row.stampStatus === WARNING_INFO_STAMP_STATUSES.NOT_FOUND) {
        return 'NO ENCONTRADO';
      } else if (this.row.stampStatus === WARNING_INFO_STAMP_STATUSES.CANCELED) {
        return 'CANCELADO';
      }*/

      return 'ERROR';
    },
  };

  export default {
    methods,
    computed,

    name: 'warning-info-table-cell-options',
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