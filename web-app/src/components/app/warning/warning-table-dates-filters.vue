<template>
    <div class="inline-flex w-full mt-4">
        <div class="flex items-center mb-6">
            <div class="md:w-2/3">
                <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4 text-theme-color-4-darkest"
                       for="cit-warning-filter-start-date">
                    Fecha de inicio
                </label>
            </div>
            <div class="md:w-1/3">
                <datetime input-class="bg-white shadow border-2 border-grey p-2 rounded-sm"
                          v-model="startDate" type="date" id="cit-warning-filter-start-date" format="yyyy-MM-dd" value-zone="America/Monterrey"
                          @input="onInputStartDate"
                />
            </div>
        </div>
        <div class="flex items-center mb-6 ml-12">
            <div class="md:w-2/3 mr-4">
                <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4 text-theme-color-4-darkest"
                       for="cit-warning-filter-end-date">
                    Fecha Fin
                </label>
            </div>
            <div class="md:w-1/3">
                <datetime input-class="bg-white shadow border-2 border-grey p-2 rounded-sm -ml-4"
                          v-model="endDate" type="date" id="cit-warning-filter-end-date" format="yyyy-MM-dd" value-zone="America/Monterrey"
                          @input="onInputEndDate"
                />
            </div>
        </div>
        <div class="flex items-center mb-6 ml-12">
            <div class="md:w-2/3 mr-4">
              <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4 text-theme-color-4-darkest" for="filter-date-type">
                Tipo de Fecha
              </label>
            </div>
            <div class="md:w-1/3">
                <select class="bg-white shadow border-grey border-2 p-2 rounded-sm -ml-4 font-sans" v-model="dateType" @change="changeDateType">
                  <option :value="1">Fecha Correo</option>
                  <option :value="2">Fecha Procesado</option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
  import {Datetime} from "vue-datetime";
  import "vue-datetime/dist/vue-datetime.css";
  import moment from "moment-es6";

  const data = function () {
    const now = moment().format('YYYY-MM-DD');

    return {
      startDate: now,
      endDate: now,
      dateType: 1,
    }
  };

  const methods = {
    onInputStartDate(value) {
      let newDate = moment(value).hour(0).minute(0).second(0).format('YYYY-MM-DD HH:mm:ss');

      if (newDate !== this.startDatetime) {
        this.$store.dispatch('changeStartDatetimeFilter', newDate);
      }
    },

    onInputEndDate(value) {
      let newDate = moment(value).hour(23).minute(59).second(59).format('YYYY-MM-DD HH:mm:ss');

      if (newDate !== this.endDatetime) {
        this.$store.dispatch('changeEndDatetimeFilter', newDate);
      }
    },

    changeDateType(){
      this.$store.dispatch('changeFilterDateType', this.dateType);
    }
  };

  const computed = {
    startDatetime() {
      return this.$store.state.section.startDatetime;
    },

    endDatetime() {
      return this.$store.state.section.endDatetime;
    },

    filterDateType(){
      return this.$store.state.section.filterDateType;
    }
  };

  export default {
    data,
    methods,
    computed,

    name: 'warning-table-dates-filters',
    components: {
      datetime: Datetime,
    },
  }
</script>
<style scoped>
</style>