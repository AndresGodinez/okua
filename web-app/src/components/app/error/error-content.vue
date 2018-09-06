<template>
    <div class="flex flex-col">
        <app-navbar></app-navbar>

        <app-menu selected="error"></app-menu>

        <div class="container w-full mx-auto">
            <error-table-dates-filters/>

            <error-table/>
        </div>
    </div>
</template>

<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import ErrorTableFilters from "./error-table-filters";
  import ErrorTable from "./error-table";
  import ErrorTableDatesFilters from "./error-table-dates-filters";

  const data = function () {
    return {};
  };

  const methods = {};

  const computed = {};

  export default {
    data,
    methods,
    computed,

    name: "error-content",
    components: {
      ErrorTableDatesFilters,
      ErrorTable,
      ErrorTableFilters,
      AppNavbar,
      AppMenu,
    },
  }
</script>

<style scoped>
</style>