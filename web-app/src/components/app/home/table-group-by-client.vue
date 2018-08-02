<template>
    <div class="flex flex-col w-full pt-4 pb-2 px-2 bg-white">
        <v2-table  :data="tableData"
                   :total="tableTotal"
                   :loading="tableLoading"
                   :shown-pagination="true"
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

  const data = function () {
    let tableData = [
      GroupByClientTableRow.makeFromObject({clientId: 1, clientName: 'Carlos Hernandez', clientRfc: 'HEBC930922HY0', amount: 1000}),
      GroupByClientTableRow.makeFromObject({clientId: 2, clientName: 'Carlos Hernandez', clientRfc: 'HEBC930922HY0', amount: 1000}),
      GroupByClientTableRow.makeFromObject({clientId: 3, clientName: 'Carlos Hernandez', clientRfc: 'HEBC930922HY0', amount: 1000}),
      GroupByClientTableRow.makeFromObject({clientId: 4, clientName: 'Carlos Hernandez', clientRfc: 'HEBC930922HY0', amount: 1000}),
      GroupByClientTableRow.makeFromObject({clientId: 5, clientName: 'Carlos Hernandez', clientRfc: 'HEBC930922HY0', amount: 1000}),
    ];
    let tableTotal = tableData.length;
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
  };

  export default {
    data,
    methods,

    name: "table-group-by-client"
  }
</script>

<style scoped>

</style>