<template>
    <div class="flex flex-col w-full pt-4 pb-2 px-2 bg-white mt-8 rounded-sm shadow-md">
        <v2-table :data="tableData"
                  :total="tableTotal"
                  :loading="tableLoading"
                  :shown-pagination="true"
                  :pagination-info="tablePaginationInfo"
                  class="bg-theme-color-1"
                  @page-change="onPageChange">
            <v2-table-column label="OPCIONES" prop="id" align="center">
                <template slot-scope="scope">
                    <bills-info-table-cell-options :row="scope.row"/>
                </template>
            </v2-table-column>
            <v2-table-column label="#" prop="id" align="center"/>
            <v2-table-column label="EMISOR" prop="clientName" align="left"/>
            <v2-table-column label="R.F.C." prop="clientRfc" align="left"/>
            <v2-table-column label="USO CFDI" prop="cfdiUseSatCode" align="left"/>
            <v2-table-column label="CANTIDAD" prop="total" align="left">
                <template slot-scope="scope">
                    <span>{{scope.row.total | currency}}</span>
                </template>
            </v2-table-column>
            <v2-table-column v-if="filterDateType === 1" label="FECHA/HORA (FACTURA)" prop="documentDatetime" align="left"/>
            <v2-table-column v-if="filterDateType === 2" label="FECHA/HORA (TIMBRADO)" prop="stampDatetime" align="left"/>
            <v2-table-column v-if="filterDateType === 3" label="FECHA/HORA (CORREO)" prop="emailDatetime" align="left"/>
            <v2-table-column v-if="filterDateType === 4" label="FECHA/HORA (PROCESADO)" prop="regDatetime" align="left"/>
        </v2-table>

        <div class="flex justify-end mt-4">
            <button v-ripple
                    class="text-left h-16 px-4 bg-theme-color-4 hover:bg-theme-color-4-darker text-white rounded mr-6"
                    @click="downloadZip">
                <font-awesome-icon :icon="iconDownloadZipFooterBtn"/>
                <span class="ml-2 uppercase">Comprimir y Descargar archivos</span>
            </button>
            <button v-ripple
                    class="text-left h-16 px-4 bg-theme-color-4 hover:bg-theme-color-4-darker text-white rounded"
                    @click="downloadXlsx">
                <font-awesome-icon :icon="iconDownloadXlsxFooterBtn"/>
                <span class="ml-2 uppercase">Exportar a Excel</span>
            </button>
        </div>
    </div>
</template>
<script>
  import BillsInfoTableCellOptions from "./bills-info-table-cell-options"
  import BillsInfoTableRow from "../../../js/models/bills-info-table-row";
  import BillInfoService from "../../../js/services/bill-info-service";
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import {faFileArchive, faFileExcel} from '@fortawesome/free-solid-svg-icons';
  import TokenUtils from "../../../js/utils/token-utils";

  const data = function () {
    let tableData = [];
    let tableTotal = tableData.length;
    let tableLoading = true;
    let tablePage = 1;
    let tableLimit = 5;
    let tablePaginationInfo = {
      text: '',
      pageSize: tableLimit,
      nextPageText: 'Sig',
      prevPageText: 'Ant'
    };

    return {
      tableData,
      tableTotal,
      tableLoading,
      tablePage,
      tableLimit,
      tablePaginationInfo,
    };
  };

  const methods = {
    onPageChange(newPage) {
      this.tablePage = newPage;

      this.dispatchGetTableData();
    },

    downloadZip() {
      let startDatetime = this.startDatetime;
      let endDatetime = this.endDatetime;
      let filterDateType = this.filterDateType;
      let clientRfc = this.clientRfc;
      let initialAmount = this.initialAmount;
      let finalAmount = this.finalAmount;

      let url = "/api/cfdi/zip-files";
      let tmpData = TokenUtils.appendAesTokenToData({});

      let data = `a=${tmpData.a}&startDatetime=${startDatetime}&endDatetime=${endDatetime}&clientRfc=${clientRfc}&initialAmount=${initialAmount}&finalAmount=${finalAmount}&filterDateType=${filterDateType}`;

      window.open(`${url}?${data}`);
    },

    downloadXlsx() {
      let startDatetime = this.startDatetime;
      let endDatetime = this.endDatetime;
      let filterDateType = this.filterDateType;
      let clientRfc = this.clientRfc;
      let initialAmount = this.initialAmount;
      let finalAmount = this.finalAmount;

      let url = "/api/cfdi/xlsx";
      let tmpData = TokenUtils.appendAesTokenToData({});

      let data = `a=${tmpData.a}&startDatetime=${startDatetime}&endDatetime=${endDatetime}&clientRfc=${clientRfc}&initialAmount=${initialAmount}&finalAmount=${finalAmount}&filterDateType=${filterDateType}`;

      window.open(`${url}?${data}`);
    },

    dispatchGetTableData() {
      let page = this.tablePage;
      let limit = this.tableLimit;
      let startDatetime = this.startDatetime;
      let endDatetime = this.endDatetime;
      let filterDateType = this.filterDateType;
      let clientRfc = this.clientRfc;
      let initialAmount = this.initialAmount;
      let finalAmount = this.finalAmount;

      if (isNaN(Number(initialAmount)) || initialAmount === '') {
        initialAmount = 0.00;
      }

      if (isNaN(Number(finalAmount)) || finalAmount === '') {
        initialAmount = 0.00;
      }

      this.tableLoading = true;

      this.getTableData(page, limit, startDatetime, endDatetime, clientRfc, initialAmount, finalAmount, filterDateType)
        .then(() => {
          if (this.tableTotal === 0) {
            this.tablePaginationInfo.text = 'Mostrando 0 de 0 resultados.';
          } else if (this.tableTotal > 0) {
            let pluralTextInclude = this.tableTotal > 1 ? 's' : '';
              this.tablePaginationInfo.text = `Mostrando ${this.tableLimit} de ${this.tableTotal} registro${pluralTextInclude}`;
          } else {
            this.tablePaginationInfo.text = '';
          }
        })
        .catch(error => console.error(error))
        .then(() => this.tableLoading = false);
    },

    async getTableData(page, limit, startDatetime, endDatetime, clientRfc = '', initialAmount = 0.00, finalAmount = 0.00, filterDateType = 1) {
      // throw exception if invalid page
      if (page <= 0) throw 'Invalid page number';

      let service = new BillInfoService();

      if (page === 1 || !this.tableData) {
        this.tableData = [];
        let {count} = await service.getFilteredRegistersCount(startDatetime, endDatetime, clientRfc, initialAmount, finalAmount, filterDateType);
        this.tableTotal = count;
      }

      if (this.tableTotal === 0) return;

      let offset = limit * (page - 1);

      let response = await service.getFilteredRegisters(limit, offset, startDatetime, endDatetime, clientRfc, initialAmount, finalAmount, filterDateType);

      this.tableData = response.data;
      return response;
    },
  };

  const computed = {
    startDatetime() {
      return this.$store.state.section.startDatetime;
    },

    endDatetime() {
      return this.$store.state.section.endDatetime;
    },

    clientRfc() {
      return this.$store.state.section.clientRfc;
    },

    initialAmount() {
      return this.$store.state.section.initialAmount;
    },

    finalAmount() {
      return this.$store.state.section.finalAmount;
    },

    dispatchBillsTableRefresh() {
      return this.$store.state.section.dispatchBillsTableRefresh;
    },

    filterDateType() {
      return this.$store.state.section.filterDateType;
    },

    iconDownloadZipFooterBtn() {
      return faFileArchive;
    },

    iconDownloadXlsxFooterBtn() {
      return faFileExcel;
    },
  };

  const watch = {
    startDatetime() {
      this.tablePage = 1;
      this.dispatchGetTableData();
    },

    endDatetime() {
      this.tablePage = 1;
      this.dispatchGetTableData();
    },

    dispatchBillsTableRefresh() {
      this.tablePage = 1;
      this.dispatchGetTableData();
    },

    filterDateType() {
      this.tablePage = 1;
      this.dispatchGetTableData();
    }
  };

  export default {
    data,
    methods,
    computed,
    watch,

    name: 'bills-table',
    components: {
      FontAwesomeIcon,
      BillsInfoTableCellOptions,
    },
    mounted() {
      setTimeout(() => {
        this.dispatchGetTableData();
      }, 500);
    },
  }
</script>
<style scoped>
    input[type='checkbox'] {
        display: none;
    }

</style>