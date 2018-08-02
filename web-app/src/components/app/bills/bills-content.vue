<template>
    <div class="flex flex-col">
        <app-navbar></app-navbar>

        <app-menu selected="bills"></app-menu>

        <div class="container w-full mx-auto">
            <bills-table-dates-filters/>

            <bills-table-filters/>

            <bills-table/>
        </div>
    </div>
</template>

<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import BillsTableFilters from "./bills-table-filters";
  import BillsTable from "./bills-table";
  import BillsTableDatesFilters from "./bills-table-dates-filters";

  const data = function () {
    return {};
  };

  const methods = {};

  const computed = {};

  export default {
    data,
    methods,
    computed,

    name: "bills-content",
    components: {
      BillsTableDatesFilters,
      BillsTable,
      BillsTableFilters,
      AppNavbar,
      AppMenu,
    },
  }
</script>

<style scoped>
</style>