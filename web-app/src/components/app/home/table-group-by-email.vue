<template>
    <div class="flex flex-col w-full pt-4 pb-2 px-2 bg-white">
        <v2-table  :data="tableData"
                   :total="tableTotal"
                   :loading="tableLoading"
                   :shown-pagination="true"
                   class="bg-theme-color-1"
                   @page-change="onPageChange">
            <v2-table-column label="E-MAIL" prop="email" align="left" />
            <v2-table-column label="CANTIDAD" prop="amount" align="left" >
                <template slot-scope="scope">
                    <span>{{scope.row.amount | currency}}</span>
                </template>
            </v2-table-column>
        </v2-table>
    </div>
</template>

<script>
  import GroupByEmailTableRow from "../../../js/models/group-by-email-table-row";

  const data = function () {
    let tableData = [
      GroupByEmailTableRow.makeFromObject({email: 'israel.torres@connectit.com.mx', amount: 1000}),
      GroupByEmailTableRow.makeFromObject({email: 'adan.morales@connectit.com.mx', amount: 1000}),
      GroupByEmailTableRow.makeFromObject({email: 'carlos.hernandez@connectit.com.mx', amount: 1000}),
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

    name: "table-group-by-email"
  }
</script>

<style scoped>

</style>