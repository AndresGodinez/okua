<template>
    <div class="flex flex-col">
        <app-navbar></app-navbar>

        <app-menu selected="warning"></app-menu>

        <div class="container w-full mx-auto">
            <warning-table-dates-filters/>

            <warning-table/>
        </div>
    </div>
</template>

<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import WarningTableFilters from "./warning-table-filters";
  import WarningTable from "./warning-table";
  import WarningTableDatesFilters from "./warning-table-dates-filters";

  const data = function () {
    return {};
  };

  const methods = {};

  const computed = {};

  export default {
    data,
    methods,
    computed,

    name: "warning-content",
    components: {
      WarningTableDatesFilters,
      WarningTable,
      WarningTableFilters,
      AppNavbar,
      AppMenu,
    },
  }
</script>

<style scoped>
</style>