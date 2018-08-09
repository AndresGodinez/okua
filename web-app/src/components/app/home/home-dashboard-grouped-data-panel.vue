<template>
    <div class="flex flex-col flex-no-shrink">
        <grouped-data-filters />

        <table-group-by-client v-if="groupFilter === 1"/>
        <table-group-by-cfdi-use v-else-if="groupFilter === 2"/>
        <table-group-by-email v-else-if="groupFilter === 3"/>
    </div>
</template>
<script>
  import TableGroupByCfdiUse from "./table-group-by-cfdi-use";
  import TableGroupByClient from "./table-group-by-client";
  import TableGroupByEmail from "./table-group-by-email";
  import GroupedDataFilters from "./grouped-data-filters";

  const computed = {
    groupFilter() {
      return this.$store.state.section.groupedDataFilter;
    },
  };

  export default {
    computed,

    name: 'home-dashboard-grouped-data-panel',
    components: {
      GroupedDataFilters,
      TableGroupByCfdiUse,
      TableGroupByClient,
      TableGroupByEmail,
    },
  }
</script>