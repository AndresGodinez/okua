<template>
  <nav class="flex items-center justify-between flex-wrap p-6" >

    <div class="block lg:hidden">
      <button class="flex items-center px-3 py-2 border rounded text-teal-lighter border-teal-light hover:text-white hover:border-white">
        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
      </button>
    </div>
    <div class="list-reset flex">
      <div class="mr-3 mx-10">
        <a v-for="section in sections" @click="goToSection(section)" class=" inline-block border rounded mx-3 py-2 px-3 bg-theme-color-4 hover:bg-theme-color-4-darker text-white" >
          {{section.name}}
        </a>
      </div>
    </div>
  </nav>
</template>

<script>

  const data = function () {
    return {
    };
  };

  const methods = {
    datlog: function ()
    {
    },
    goToSection(section) {
      this.$store.dispatch('changeSection', section);
    }
  };

  const computed = {
    sections() {
      return this.$store.state.subMenu.sections;
    },
  };



  export default {
    data,
    methods,
    computed,
    name: "SubVavBar",
    mounted() {
      this.datlog();
    }
  }
</script>

<style scoped>

</style>