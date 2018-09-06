<template>
    <loading :active.sync="isLoading" :can-cancel="false"></loading>
</template>

<script>
  import Loading from "vue-loading-overlay";

  import 'vue-loading-overlay/dist/vue-loading.min.css';

  const computed = {
    isLoading() {
      return this.$store.state.loading.isLoading;
    },
  };

  export default {
    computed,

    name: "loading-overlay",
    components: {
      Loading,
    }
  }
</script>

<style scoped>

</style>