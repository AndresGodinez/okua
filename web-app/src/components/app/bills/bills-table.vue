<template>
    <div class="flex flex-col w-full pt-4 pb-2 px-2 bg-white mt-8 rounded-sm shadow-md">
        <v2-table :data="tableData"
                  :total="tableTotal"
                  :loading="tableLoading"
                  :shown-pagination="true"
                  class="bg-theme-color-1"
                  @page-change="onPageChange">
            <v2-table-column label="OPCIONES" prop="id" align="center">
                <template slot-scope="scope">
                    <bills-info-table-cell-options :row="scope.row"/>
                </template>
            </v2-table-column>
            <v2-table-column label="#" prop="id" align="center"/>
            <v2-table-column label="CLIENTE" prop="clientName" align="left"/>
            <v2-table-column label="R.F.C." prop="clientRfc" align="left"/>
            <v2-table-column label="USO CFDI" prop="cfdiUseName" align="left"/>
            <v2-table-column label="CANTIDAD" prop="total" align="left">
                <template slot-scope="scope">
                    <span>{{scope.row.total | currency}}</span>
                </template>
            </v2-table-column>
        </v2-table>
    </div>
</template>
<script>
  import BillsInfoTableCellOptions from "./bills-info-table-cell-options"
  import BillsInfoTableRow from "../../../js/models/bills-info-table-row";

  const data = function () {
    let tableData = [
      BillsInfoTableRow.makeFromObject({
        id: 1,
        clientName: 'Israel Torres',
        clientRfc: 'TOSI840410YYY',
        uuid: '14686E5B-FC7D-8E81-DE55-F2DFA458EF5D',
        cfdiUseName: 'Adquisición de mercancias',
        cfdiUseSatCode: 'G01',
        documentDatetime: '2018-08-02 09:14:00',
        emailDatetime: '2018-08-02 09:14:00',
        stampDatetime: '2018-08-02 09:14:00',
        total: 1000,
        currency: 'MXN'
      }),
      BillsInfoTableRow.makeFromObject({
        id: 2,
        clientName: 'Israel Torres',
        clientRfc: 'TOSI840410YYY',
        uuid: '14686E5B-FC7D-8E81-DE55-F2DFA458EF5D',
        cfdiUseName: 'Adquisición de mercancias',
        cfdiUseSatCode: 'G01',
        documentDatetime: '2018-08-02 09:14:00',
        emailDatetime: '2018-08-02 09:14:00',
        stampDatetime: '2018-08-02 09:14:00',
        total: 1000,
        currency: 'MXN'
      }),
      BillsInfoTableRow.makeFromObject({
        id: 3,
        clientName: 'Israel Torres',
        clientRfc: 'TOSI840410YYY',
        uuid: '14686E5B-FC7D-8E81-DE55-F2DFA458EF5D',
        cfdiUseName: 'Adquisición de mercancias',
        cfdiUseSatCode: 'G01',
        documentDatetime: '2018-08-02 09:14:00',
        emailDatetime: '2018-08-02 09:14:00',
        stampDatetime: '2018-08-02 09:14:00',
        total: 1000,
        currency: 'MXN'
      }),
      BillsInfoTableRow.makeFromObject({
        id: 4,
        clientName: 'Israel Torres',
        clientRfc: 'TOSI840410YYY',
        uuid: '14686E5B-FC7D-8E81-DE55-F2DFA458EF5D',
        cfdiUseName: 'Adquisición de mercancias',
        cfdiUseSatCode: 'G01',
        documentDatetime: '2018-08-02 09:14:00',
        emailDatetime: '2018-08-02 09:14:00',
        stampDatetime: '2018-08-02 09:14:00',
        total: 1000,
        currency: 'MXN'
      }),
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

    name: 'bills-table',
    components: {BillsInfoTableCellOptions},
  }
</script>
<style scoped>
    input[type='checkbox'] {
        display: none;
    }

</style>