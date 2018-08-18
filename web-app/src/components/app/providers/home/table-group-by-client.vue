<template>
    <div class="flex flex-col w-full pt-4 pb-2 px-2 bg-white">
        <v2-table  :data="tableData"
                   :total="tableTotal"
                   :loading="tableLoading"
                   :shown-pagination="true"
                   :pagination-info="tablePaginationInfo"
                   class="bg-theme-color-1"
                   @page-change="onPageChange">
            <v2-table-column label="CLIENTE" prop="clientName" align="left" />
            <v2-table-column label="R.F.C." prop="clientRfc" align="left" />
            <v2-table-column label="CANTIDAD" prop="amount" align="left" >
                <template slot-scope="scope">
                    <span>{{scope.row.amount | currency}}</span>
                </template>
            </v2-table-column>
        </v2-table>
    </div>
</template>

<script>
  import BillInfoService from "../../../../js/services/bill-info-service";

  const data = function () {
    let tableData = [];
    let tableTotal = 0;
    let tableLoading = false;
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
      let filter = '';
      let page = this.tablePage;
      let limit = this.tableLimit;

      if (this.datetimeRangeFilter === 1) {
        filter = 'week';
      } else if (this.datetimeRangeFilter === 2) {
        filter = 'month';
      } else if (this.datetimeRangeFilter === 3) {
        filter = 'year';
      }

      this.tableLoading = true;

      this.getTableData(page, limit, filter)
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

    async getTableData(page, limit, filter) {
      // throw exception if invalid page
      if (page <= 0) throw 'Invalid page number';

      let service = new BillInfoService();

      if (page === 1 || !this.tableData) {
        this.tableData = [];
        let {count} = await service.getDataGroupedByClientAndFilterCount(filter);
        this.tableTotal = count;
      }

      if (this.tableTotal === 0) return;

      let offset = limit * (page - 1);

      let response = await service.getDataGroupedByClientAndFilter(limit, offset, filter);

      this.tableData = response.data;

      return response;
    },
  };

  const computed = {
    forceUpdateByNewRegisters() {
      return this.$store.state.section.forceUpdateByNewRegisters;
    },

    datetimeRangeFilter() {
      return this.$store.state.section.datetimeRangeFilter;
    },
  };

  const watch = {
    datetimeRangeFilter() {
      this.dispatchGetTableData();
    },

    forceUpdateByNewRegisters() {
      this.dispatchGetTableData();
    },
  };

  export default {
    data,
    methods,
    computed,
    watch,

    name: "table-group-by-client",
    mounted() {
      setTimeout(() => this.dispatchGetTableData(), 500);
    }
  }
</script>

<style scoped>

</style>