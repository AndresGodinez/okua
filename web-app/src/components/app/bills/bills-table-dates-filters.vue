<template>
    <div class="inline-flex w-full mt-4">
        <div class="flex items-center mb-6">
            <div class="md:w-2/3">
                <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4 text-theme-color-4-darkest"
                       for="cit-bills-filter-start-date">
                    Fecha de inicio (Factura)
                </label>
            </div>
            <div class="md:w-1/3">
                <datetime input-class="bg-white shadow border-2 border-grey p-2 rounded-sm"
                          v-model="startDate" type="datetime" id="cit-bills-filter-start-date" format="yyyy-MM-dd" value-zone="America/Monterrey"/>
            </div>
        </div>
        <div class="flex items-center mb-6 ml-12">
            <div class="md:w-2/3 mr-4">
                <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4 text-theme-color-4-darkest"
                       for="cit-bills-filter-end-date">
                    Fecha Fin (Factura)
                </label>
            </div>
            <div class="md:w-1/3">
                <datetime input-class="bg-white shadow border-2 border-grey p-2 rounded-sm -ml-4"
                          v-model="endDate" type="datetime" id="cit-bills-filter-end-date" format="yyyy-MM-dd" value-zone="America/Monterrey"/>
            </div>
        </div>
    </div>
</template>
<script>
  import {Datetime} from "vue-datetime";
  import "vue-datetime/dist/vue-datetime.css";
  import moment from "moment-es6";

  const data = function () {
    moment.locale('es-LA');
    const now = moment().format('YYYY-MM-DD');

    return {
      startDate: now,
      endDate: now,
    }
  };
  export default {
    data,

    name: 'bills-table-dates-filters',
    components: {
      datetime: Datetime,
    },
    mounted() {
    },
  }
</script>
<style scoped>
</style>