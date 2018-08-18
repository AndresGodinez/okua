<template>
    <div class="flex flex-col w-1/2 mt-16 shadow-md mb-16">
      <cfdi-panel-topbar />
          <v2-table :data="tableData" :total="tableTotal" :loading="tableLoading" :shown-pagination="true" :pagination-info="tablePaginationInfo" class="bg-theme-color-1">
              <v2-table-column label="OPCIONES" prop="id" align="center">
                  <template slot-scope="scope">
                      <bills-info-table-cell-options :row="scope.row" />
                  </template>
              </v2-table-column>
              <v2-table-column label="#" prop="id" align="center" />
              <v2-table-column label="CLIENTE" prop="emitterName" align="left" />
              <v2-table-column label="R.F.C." prop="emitterRfc" align="left" />
              <v2-table-column label="USO CFDI" prop="cfdiUseSatCode" align="left" />
              <v2-table-column label="CANTIDAD" prop="total" align="left">
                  <template slot-scope="scope">
                      <span>{{scope.row.total | currency}}</span>
                  </template>
              </v2-table-column>
              <v2-table-column label="FECHA/HORA (CORREO)" prop="emailDatetime" align="left" />
          </v2-table>
    </div>
</template>

<script>
  import RouteUtils from "../../../../js/utils/route-utils";
  import BillInfoService from "../../../../js/services/bill-info-service";
  import CfdiPanelTopbar from "./cfdi-panel-topbar";
  import BillsInfoTableCellOptions from "../../bills/bills-info-table-cell-options"
  import BillsInfoTableRow from "../../../../js/models/bills-info-table-row";

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
    groupFilter() {
      return this.$store.state.section.groupedDataFilter;
    },

    iconGroupByClient() {
      return faUsers;
    },
    iconGroupByCfdiUse() {
      return faBoxes;
    },
    iconGroupByEmail() {
      return faEnvelope;
    },
  };

  export default {
    data,
    methods,
    computed,

    name: 'home-dashboard-last-cfdi-panel',
    components: {
      CfdiPanelTopbar,
      BillsInfoTableCellOptions,
    },
    mounted() {
      setTimeout(() => this.dispatchGetLastRegisters(), 500);
    },
  }
</script>