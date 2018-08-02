<template>
    <div class="flex flex-col w-full pt-4 pb-2 px-2 bg-white">
        <v2-table  :data="tableData"
                   :total="tableTotal"
                   :loading="tableLoading"
                   :shown-pagination="true"
                   class="bg-theme-color-1"
                   @page-change="onPageChange">
            <v2-table-column label="CÓDIGO" prop="cfdiUseSatCode" align="left" />
            <v2-table-column label="USO CFDI" prop="cfdiUseName" align="left" />
            <v2-table-column label="CANTIDAD" prop="amount" align="left" >
                <template slot-scope="scope">
                    <span>{{scope.row.amount | currency}}</span>
                </template>
            </v2-table-column>
        </v2-table>
    </div>
</template>

<script>
  import GroupByCfdiUseTableRow from "../../../js/models/group-by-cfdi-use-table-row";

  const data = function () {
    let tableData = [
      GroupByCfdiUseTableRow.makeFromObject({cfdiUseId: 1, cfdiUseName: 'Adquisición de mercancias', cfdiUseSatCode: 'G01', amount: 1000}),
      GroupByCfdiUseTableRow.makeFromObject({cfdiUseId: 2, cfdiUseName: 'Por definir', cfdiUseSatCode: 'P01', amount: 1000}),
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

    name: "table-group-by-cfdi-use"
  }
</script>

<style scoped>

</style>