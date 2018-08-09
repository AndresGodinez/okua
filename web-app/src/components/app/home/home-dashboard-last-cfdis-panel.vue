<template>
    <div class="flex flex-col w-3/4 mt-16 shadow-md mb-16 flex-no-shrink">
        <last-cfdis-panel-topbar />
        <v2-table :data="tableData"
                  :total="tableTotal"
                  :loading="tableLoading"
                  :shown-pagination="true"
                  :pagination-info="tablePaginationInfo"
                  class="bg-theme-color-1">
            <v2-table-column label="OPCIONES" prop="id" align="center">
                <template slot-scope="scope">
                    <bills-info-table-cell-options :row="scope.row" />
                </template>
            </v2-table-column>
            <v2-table-column label="CLIENTE" prop="clientName" align="left" >
                <template slot-scope="scope">
                    <span>{{scope.row.clientName}}</span>
                </template>
            </v2-table-column>
            <v2-table-column label="CANTIDAD" prop="total" align="center" width="150">
                <template slot-scope="scope">
                    <span>{{scope.row.total | currency}}</span>
                </template>
            </v2-table-column>
            <v2-table-column label="FECHA/HORA (CORREO)" prop="emailDatetime" align="center" >
                <template slot-scope="scope">
                    <span>{{scope.row.emailDatetime}}</span>
                </template>
            </v2-table-column>
        </v2-table>
    </div>
</template>

<script>
  import RouteUtils from "../../../js/utils/route-utils";
  import BillInfoService from "../../../js/services/bill-info-service";
  import LastCfdisPanelTopbar from "./last-cfdis-panel-topbar";
  import BillsInfoTableCellOptions from "../bills/bills-info-table-cell-options"

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
    goBills() {
      RouteUtils.goBills();
    },

    dispatchGetLastRegisters() {
      this.getLastRegisters()
        .then(response => {
          this.tableData = response.data;
        })
        .then(() => this.tableLoading = false);
    },

    async getLastRegisters(limit = 5) {
      let service = new BillInfoService();
      return await service.getLastRegisters(limit);
    },
  };

  const computed = {
  };

  export default {
    data,
    methods,
    computed,

    name: 'home-dashboard-last-cfdis-panel',
    components: {
      LastCfdisPanelTopbar,
      BillsInfoTableCellOptions,
    },
    mounted() {
      setTimeout(() => this.dispatchGetLastRegisters(), 500);
    },
  }
</script>