<template>
    <div class="inline-flex mt-4 mb-2">
        <ul class="list-reset flex">
            <li>
                <div class="inline-block border border-theme-color-4 rounded-l px-4 py-2 cursor-pointer"
                     :class="[rangeFilter === 1 ? 'bg-theme-color-4 text-white' : 'text-theme-color-4-darker']"
                     @click="setRangeFilter(1)">Semana
                </div>
            </li>
            <li>
                <div class="inline-block border border-theme-color-4 px-4 py-2 cursor-pointer"
                     :class="[rangeFilter === 2 ? 'bg-theme-color-4 text-white' : 'text-theme-color-4-darker']"
                     @click="setRangeFilter(2)">Mes
                </div>
            </li>
            <li>
                <div class="inline-block border border-theme-color-4 rounded-r px-4 py-2 cursor-pointer"
                     :class="[rangeFilter === 3 ? 'bg-theme-color-4 text-white' : 'text-theme-color-4-darker']"
                     @click="setRangeFilter(3)">Año
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
  const methods = {
    setRangeFilter(value) {
      this.$store.dispatch('changeDatetimeRangeFilter', value);
    },
  };

  const computed = {
    rangeFilter() {
      return this.$store.state.section.datetimeRangeFilter;
    }
  };

  export default {
    methods,
    computed,

    name: 'datetime-range-filters'
  }
</script>
