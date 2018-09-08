<template>
  <div class="flex flex-col max-h-screen">
    <app-menu selected="admin"></app-menu>

    <app-navbar></app-navbar>
    <SubVavBar></SubVavBar>

    <div class="flex flex-row w-full px-8">
      <div class="flex flex-col flex-grow px-4 max-h-full overflow-y-auto overflow-hidden">
        <div class="flex flex-row justify-between flex-no-shrink">
          <v2-table :data="usersList" border
                    :shown-pagination="true"
                    :loading="pagination.loading"
                    :total="pagination.total"
                    :pagination-info="pagination.paginationInfo"
                    @page-change="handlePageChange">
            <v2-table-column label="Actions">
              <template slot-scope="scope">
                <a class="bg-green-light hover:bg-green-dark text-white font-bold py-2 px-4 rounded"
                   @click="goToEditUser(scope.row.id)">Editar</a>
                <a class="bg-green-light hover:bg-green-dark text-white font-bold py-2 px-4 rounded"
                   @click="goToEditActivityUser(scope.row.id)">Permisos</a>
                <button
                   class="bg-red-light hover:bg-red-dark text-white font-bold py-2 px-4 rounded"
                   @click="userDelete(scope.row.id, scope.row.name)">Eliminar
                </button>
              </template>
            </v2-table-column>
            <v2-table-column label="Id" prop="id"></v2-table-column>
            <v2-table-column label="Nombre" prop="name"></v2-table-column>
            <v2-table-column label="Estado" prop="regStatus"></v2-table-column>
          </v2-table>
        </div>
        <div class="flex flex-row justify-between flex-no-shrink ">
          <button class="bg-blue hover:bg-blue-dark text-white py-2 px-4 rounded right" @click="goToEditUser(0)"> agregar usuario</button>
        </div>
        </div>
    </div>
  </div>
</template>
<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import SubVavBar from "../catalogsNav/nav";
  import {HOST_API} from "../../../js/utils/app-utils";
  import RouteUtils from "../../../js/utils/route-utils";

  import WebApi from "../../../js/services/web-api";
  import TokenUtils from "../../../js/utils/token-utils";

  const data = function () {
    let usersList = [];
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
      usersList,
    };
  };

  const methods = {
    goToEditUser(id) {
      localStorage.userToEdit = id;
      RouteUtils.adminSections(`/user/form/${id}`);
    },
    goToEditActivityUser(id) {
      localStorage.userToEdit = id;
      RouteUtils.adminSections(`/user/activities/${id}`);
    },
    async getUserList(page) {
      let usersData = await await this.$store.state.userStore.userService.getAllUsers();
      this.usersList = usersData.data;
      
    },
    handlePageChange(page) {
      this.getUserList(page);
    }
  };
  export default {
    data,
    methods,
    name: "users-content",
    components: {
      AppNavbar,
      AppMenu,
      SubVavBar,
    },
    mounted() {
      this.getUserList();
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