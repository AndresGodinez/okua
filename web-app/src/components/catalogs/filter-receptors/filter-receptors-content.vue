<template>
  <div class="flex flex-col max-h-screen">
    <app-menu selected="admin"></app-menu>
    <app-navbar></app-navbar>
    <SubVavBar></SubVavBar>

    <div class="flex flex-row w-full px-8">
      <div class="flex flex-col flex-grow px-4 max-h-full overflow-y-auto overflow-hidden">
        <div class="flex flex-row justify-between flex-no-shrink">
          <v2-table :data="receptorsList" border
                    :shown-pagination="true"
                    :loading="pagination.loading"
                    :total="pagination.total"
                    :pagination-info="pagination.paginationInfo"
                    @page-change="handlePageChange">
            <v2-table-column label="Actions">
              <template slot-scope="scope">
                <a class="bg-green-light hover:bg-green-dark text-white font-bold py-2 px-4 rounded"
                   @click="goToEditFilterReceptor(scope.row.id)">Editar</a>
                <button
                   class="bg-red-light hover:bg-red-dark text-white font-bold py-2 px-4 rounded"
                   @click="filterReceptorDelete(scope.row.id)">Eliminar
                </button>
              </template>
            </v2-table-column>
            <v2-table-column label="Id" prop="id"></v2-table-column>
            <v2-table-column label="RFC" prop="rfc"></v2-table-column>
            <v2-table-column label="Estado" prop="valid">
              <template slot-scope="scope">
                <span v-if="scope.row.valid === 1">
                  <font-awesome-icon class="text-green" :icon="iconValidOk" />
                </span>
                <span v-else-if="scope.row.valid === 0">
                  <font-awesome-icon class="text-red" :icon="iconValidBad" />
                </span>
                <span v-else="">ERROR</span>
              </template>
            </v2-table-column>
          </v2-table>
        </div>
        <div class="flex flex-row justify-between flex-no-shrink ">
          <button class="bg-blue hover:bg-blue-dark text-white py-2 px-4 rounded right"
                  @click="goToEditFilterReceptor(0)"> Agregar receptor
          </button>
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
  import {faTimes, faCheck} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

  const data = function () {
    let receptorsList = [];
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
      receptorsList,
    };
  };

  const methods = {
    async filterReceptorDelete(id) {
      let responseApi = await this.$store.state.filterReceptorStore.filterReceptorService.delete(id);
      RouteUtils.adminSections(`/filter-receptors`);
    },
    goToEditFilterReceptor(id) {
      localStorage.userToEdit = id;
      RouteUtils.adminSections(`/filter-receptor/form/${id}`);
    },
    async getReceptorsList(page) {
      let responseApi = await this.$store.state.filterReceptorStore.filterReceptorService.getAll();
      responseApi = responseApi.data;
      this.receptorsList = responseApi;
      this.pagination.loading = false;
    },
    handlePageChange(page) {
      this.getReceptorsList(page);
    }
  };
  const computed = {
    iconValidOk() {
      return faCheck;
    },
    iconValidBad() {
      return faTimes;
    }
  };
  export default {
    data,
    methods,
    computed,
    name: "filter-receptor-content",
    components: {
      AppNavbar,
      AppMenu,
      SubVavBar,
      FontAwesomeIcon
    },
    mounted() {
      this.pagination.loading = true;
      this.getReceptorsList();
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