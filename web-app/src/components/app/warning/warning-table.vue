<template>
   <div class="flex flex-col w-full pt-4 pb-2 px-2 bg-white">
        <v2-table  :data="tableData"
                   :total="tableTotal"
                   :loading="tableLoading"
                   :shown-pagination="true"
                   class="bg-theme-color-1"
                   @page-change="onPageChange">
            <v2-table-column label="ID" prop="id" align="left" />
            <v2-table-column label="ADVERTENCIA" prop="description" align="left" />
            <v2-table-column label="EMAIL" prop="email" align="left" />
            <v2-table-column v-if="filterDateType === 1" label="FECHA/HORA (EMAIL)" prop="emailDatetime" align="left"/>
            <v2-table-column v-if="filterDateType === 2" label="FECHA/HORA (PROCESADO)" prop="regDatetime" align="left"/>
        </v2-table>
    </div>
</template>
<script>
  import WarningInfoTableCellOptions from "./warning-info-table-cell-options";
  import WarningInfoTableRow from "../../../js/models/warning-table-row";
  import ProcessWarningService from "../../../js/services/process-warning-service";

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

    dispatchGetTableData() {
      let page = this.tablePage;
      let limit = this.tableLimit;
      let startDatetime = this.startDatetime;
      let endDatetime = this.endDatetime;
      let filterDateType = this.filterDateType;

      this.tableLoading = true;

      this.getTableData(page, limit, startDatetime, endDatetime, filterDateType)
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

    async getTableData(page, limit, startDatetime, endDatetime, filterDateType = 1) {
      // throw exception if invalid page
      if (page <= 0) throw 'Invalid page number';

      let service = new ProcessWarningService();

      if (page === 1 || !this.tableData) {
        this.tableData = [];
        let {count} = await service.getFilteredRegistersCount(startDatetime, endDatetime, filterDateType);
        this.tableTotal = count;
      }

      if (this.tableTotal === 0) return;

      let offset = limit * (page - 1);
      let response = await service.getFilteredRegisters(limit, offset, startDatetime, endDatetime, filterDateType);

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

    dispatchWarningTableRefresh() {
      return this.$store.state.section.dispatchWarningTableRefresh;
    },
    filterDateType() {
      return this.$store.state.section.filterDateType;
    }
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

    dispatchWarningTableRefresh() {
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

    name: 'warning-table',
    components: {WarningInfoTableCellOptions},
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