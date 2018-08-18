<template>
    <div class="flex flex-col w-2/5 mt-16 shadow-md mb-16 flex-no-shrink">
        <error-panel-topbar />
        <v2-table :data="tableData"
                  :total="tableTotal"
                  :loading="tableLoading"
                  :shown-pagination="true"
                  :pagination-info="tablePaginationInfo"
                  class="bg-theme-color-1">
            <v2-table-column label="OPCIONES" prop="id" align="center">
                <template slot-scope="scope">
                    <error-panel-cell-options :row="scope.row" />
                </template>
            </v2-table-column>
            <v2-table-column label="EMAIL" prop="email" align="left" >
                <template slot-scope="scope">
                    <span>{{scope.row.email}}</span>
                </template>
            </v2-table-column>
            <v2-table-column label="ERROR" prop="description" align="center" width="150">
                <template slot-scope="scope">
                    <span>{{scope.row.description}}</span>
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
  import ProcessErrorService from "../../../js/services/process-error-service";
  import ErrorPanelTopbar from "./error-panel-topbar";
  import ErrorPanelCellOptions from "./error-panel-cell-options";

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

    dispatchGetLastProcessErrors() {
      this.getLastProcessErrors()
        .then(response => {
          this.tableData = response.data;
        })
        .then(() => this.tableLoading = false);
    },

    async getLastProcessErrors(limit = 5) {
      let service = new ProcessErrorService();
      return await service.getLastProcessErrors(limit);
    },
  };

  const computed = {
  };

  export default {
    data,
    methods,
    computed,

    name: 'home-dashboard-error-panel',
    components: {
      ErrorPanelTopbar,
      ErrorPanelCellOptions,
    },
    mounted() {
      setTimeout(() => this.dispatchGetLastProcessErrors(), 500);
    },
  }
</script>