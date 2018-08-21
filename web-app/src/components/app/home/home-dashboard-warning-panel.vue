<template>
    <div class="flex flex-col flex-1 mt-16 shadow-md mb-16 flex-no-shrink">
        <warning-panel-topbar />

        <v2-table :data="tableData"
                  :total="tableTotal"
                  :loading="tableLoading"
                  :shown-pagination="false"
                  class="bg-theme-color-1">
            <v2-table-column label="OPCIONES" prop="id" align="center">
                <template slot-scope="scope">
                    <warning-panel-cell-options :row="scope.row" />
                </template>
            </v2-table-column>
            <v2-table-column label="EMAIL" prop="email" align="left" >
                <template slot-scope="scope">
                    <span>{{scope.row.email}}</span>
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
  import ProcessWarningService from "../../../js/services/process-warning-service";
  import WarningPanelTopbar from "./warning-panel-topbar";
  import WarningPanelCellOptions from "./warning-panel-cell-options";
  import {delay} from "../../../js/utils/app-utils";

  const data = function () {
    let tableData = [];
    let tableTotal = 0;
    let tableLoading = true;
    let tablePage = 1;
    let tableLimit = 5;

    return {
      tableData,
      tableTotal,
      tableLoading,
      tablePage,
      tableLimit,
    };
  };

  const methods = {
    dispatchGetLastProcessWarnings() {
      this.tableLoading = true;
      this.getLastProcessWarnings()
        .then(response => {
          this.tableData = !!response.data ? response.data : [];
          this.tableTotal = !!this.tableData ? this.tableData.length : 0;
        })
        .then(() => this.tableLoading = false);
    },

    async getLastProcessWarnings(limit = 5) {
      let service = new ProcessWarningService();
      return await service.getLastProcessWarnings(limit);
    },
  };

  const computed = {
    forceUpdateByNewRegisters() {
      return this.$store.state.section.forceUpdateByNewRegisters;
    },
  };

  const watch = {
    forceUpdateByNewRegisters() {
      delay(500).then(() => this.dispatchGetLastProcessWarnings());
    },
  };

  export default {
    data,
    methods,
    computed,
    watch,

    name: 'home-dashboard-warning-panel',
    components: {
      WarningPanelTopbar,
      WarningPanelCellOptions,
    },
    mounted() {
      delay(500).then(() => this.dispatchGetLastProcessWarnings());
    },
  }
</script>