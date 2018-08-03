<template>
    <div class="flex flex-col">
        <app-menu selected="home"></app-menu>

        <app-navbar></app-navbar>

        <div class="flex flex-row w-full px-8">
            <div class="flex flex-col flex-grow px-4">
                <datetime-range-filters/>

                <home-dashboard-indicators-cards/>

                <home-dashboard-grouped-data-panel/>
            </div>

            <home-dashboard-last-emails-panel/>
        </div>
    </div>
</template>
<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import DatetimeRangeFilters from "./datetime-range-filters";
  import HomeDashboardIndicatorsCards from "./home-dashboard-indicators-cards";
  import HomeDashboardGroupedDataPanel from "./home-dashboard-grouped-data-panel";
  import HomeDashboardLastEmailsPanel from "./home-dashboard-last-emails-panel";


  export default {
    name: "home-content",
    components: {
      HomeDashboardLastEmailsPanel,
      HomeDashboardGroupedDataPanel,
      HomeDashboardIndicatorsCards,
      DatetimeRangeFilters,
      AppNavbar,
      AppMenu,
    },
    mounted() {
    },
  }
</script>
