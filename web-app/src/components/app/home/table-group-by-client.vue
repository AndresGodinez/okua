<template>
    <div class="flex flex-col w-full pt-4 pb-2 px-2 bg-white">
        <v2-table  :data="tableData"
                   :total="tableTotal"
                   :loading="tableLoading"
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
  import GroupByClientTableRow from "../../../js/models/group-by-client-table-row";
  import BillInfoService from "../../../js/services/bill-info-service";

  const data = function () {
    let tableData = [
    ];
    let tableTotal = 0;
    let tableLoading = false;

    return {
      tableData,
      tableTotal,
      tableLoading,
    };
  };

  const methods = {
    onPageChange(newPage) {
    },

    dispatchGetTableData() {
      let filter = '';

      if (this.datetimeRangeFilter === 1) {
        filter = 'week';
      } else if (this.datetimeRangeFilter === 2) {
        filter = 'month';
      } else if (this.datetimeRangeFilter === 3) {
        filter = 'year';
      }

      this.tableLoading = true;

      this.getTableData(filter)
        .catch(error => console.error(error))
        .then(() => this.tableLoading = false);
    },

    async getTableData(filter) {
      let service = new BillInfoService();
      let response = await service.getDataGroupedByClientAndFilter(filter);

      this.tableData = response.data;
      this.tableTotal = this.tableData.length;

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