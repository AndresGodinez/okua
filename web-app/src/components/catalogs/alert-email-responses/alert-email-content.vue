<template>
  <div class="flex flex-col max-h-screen">
    <app-menu selected="admin"></app-menu>

    <app-navbar></app-navbar>
    <SubVavBar></SubVavBar>
    <div class="flex flex-row w-full px-8">
      <div class="flex flex-col flex-grow px-4 max-h-full overflow-y-auto overflow-hidden">
        <div class="flex flex-row justify-between flex-no-shrink">
          <v2-table :data="alertEmailResponses" border
                    :shown-pagination="true"
                    :loading="pagination.loading"
                    :total="pagination.total"
                    :pagination-info="pagination.paginationInfo"
                    @page-change="handlePageChange">
            <v2-table-column label="Actions">
              <template slot-scope="scope">
                <a class="bg-green-light hover:bg-green-dark text-white font-bold py-2 px-4 rounded"
                   @click="goToEditAlertEmailResponse(scope.row.id)">Editar</a>
              </template>
            </v2-table-column>
            <v2-table-column label="Código" prop="code"></v2-table-column>
            <v2-table-column label="Mensaje" prop="internalMsg"></v2-table-column>
            <v2-table-column label="email" prop="emailMsg"></v2-table-column>
          </v2-table>
        </div>
        </div>
    </div>
  </div>
</template>
<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import SubVavBar from "../catalogsNav/nav";
  import RouteUtils from "../../../js/utils/route-utils";
  const data = function () {
    let alertEmailResponses = [];
    let pagination = {
      currentPage: 1, //página actual
      total: 0, //Número de páginas habrá
      loading: false,
      paginationInfo: {
        // text: '<span>Total of <strong>200</strong>, <strong>10</strong> per page</span>'
      }
    };
    return {
      pagination,
      alertEmailResponses,
    };
  };

  const methods = {
    goToEditAlertEmailResponse(id) {
      localStorage.userToEdit = id;
      RouteUtils.adminSections(`/alert-email-response/form/${id}`);
    },
    async getAlertEmailResponses(page) {
      let dataAlertEmailResponse = await this.$store.state.alertEmailResponseStore.alertEmailResponseService.getAll();
      dataAlertEmailResponse = dataAlertEmailResponse.data;
      this.alertEmailResponses = dataAlertEmailResponse;
      this.pagination.loading = false;

    },
    handlePageChange(page) {
      this.getAlertEmailResponses(page);
    }
  };
  export default {
    data,
    methods,
    name: "alert-email-response-content",
    components: {
      AppNavbar,
      AppMenu,
      SubVavBar,
    },
    mounted() {
      this.pagination.loading = true;
      this.getAlertEmailResponses();
    },
  }
</script>
<style scoped>
  /* width */
  ::-webkit-scrollbar {
    width: 10px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.0);
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: rgba(180, 180, 180, 0.8);
  }
</style>