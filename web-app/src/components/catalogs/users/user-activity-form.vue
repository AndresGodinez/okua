<template>
  <div class="flex flex-col max-h-screen">
    <app-menu selected="admin"></app-menu>

    <app-navbar></app-navbar>
    <SubVavBar></SubVavBar>

    <div class="flex flex-row w-full px-8 h-full flex-no-shrink">
      <div class="flex flex-col flex-grow px-4 max-h-full overflow-y-auto overflow-hidden items-center pt-4">
        <div class="text-left bg-theme-color-4 rounded-sm shadow-md py-4 px-4 w-2/5">
          <div class="flex flex-row">
            <span class="flex-1 w-full text-left text-white text-3xl font-semibold">Accesos de menú</span>
          </div>
        </div>

        <div class="flex flex-row justify-center flex-no-shrink mb-3 w-2/5">
          <div class="w-full">
            <table class="table-striped">
              <tr v-for="item in userActivities">
                <td>
                  <label >{{item.label}}</label>
                </td>
                <td>
                  <input type="checkbox" v-model="item.active">
                </td>

              </tr>
            </table>
          </div>
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
  import AppUtils from "../../../js/utils/app-utils";
  import FloatLabel from "vue-float-label/components/FloatLabel";


  const data = function () {
    let userActivities = [];
    return {
      userActivities
    };
  };

  const methods = {
    saveData() {
    },
    goToIndex() {
      RouteUtils.adminSections('/emitters');
    },
    async getUserActivities() {
      let id = localStorage.userToEdit;
      let userActivities = await this.$store.state.userStore.userService.getUserActivities();
      this.userActivities = userActivities;
    },
  };
  export default {
    data,
    methods,
    name: "user-activity-form",
    components: {
      AppNavbar,
      AppMenu,
      SubVavBar,
      FloatLabel
    },
    mounted() {
      const registerId = Number(AppUtils.getIdMeta());
      this.registerId = registerId;
      this.getUserActivities();
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
  .table-striped>tr:nth-of-type(odd){
    background-color:#C31E2A;
    color: #fff;
  }
</style>