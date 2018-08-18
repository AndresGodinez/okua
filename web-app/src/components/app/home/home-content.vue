<template>
    <div class="flex flex-col max-h-screen">
        <app-menu selected="home"></app-menu>

        <app-navbar></app-navbar>

        <div class="flex flex-row w-full px-8">
            <div class="flex flex-col flex-grow px-4 max-h-full overflow-y-auto overflow-hidden">
                <home-dashboard-last-cfdis-panel/>

                <div class="flex flex-row justify-between flex-no-shrink">
                  <home-dashboard-warning-panel />
                  <home-dashboard-error-panel />
                </div>
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
  import HomeDashboardLastCfdisPanel from "./home-dashboard-last-cfdis-panel";
  import HomeDashboardWarningPanel from "./home-dashboard-warning-panel";
  import HomeDashboardErrorPanel from "./home-dashboard-error-panel";


  export default {
    name: "home-content",
    components: {
      HomeDashboardLastEmailsPanel,
      HomeDashboardLastCfdisPanel,
      HomeDashboardGroupedDataPanel,
      HomeDashboardIndicatorsCards,
      HomeDashboardWarningPanel,
      HomeDashboardErrorPanel,
      DatetimeRangeFilters,
      AppNavbar,
      AppMenu,
    },
    mounted() {
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