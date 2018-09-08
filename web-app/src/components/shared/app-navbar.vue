<template>
    <nav class="flex justify-between flex-wrap bg-brown-light px-6 py-3 bg-theme-color-1">
        <div class="flex items-center flex-no-shrink text-black text-center text-theme-color-4 hover:text-theme-color-4-darker">
            <font-awesome-icon :icon="iconMenu" size="2x" @click="openMenu()" class="cursor-pointer"/>
        </div>
        <div class="flex items-center flex-no-shrink text-black text-center">
            <a href="/app" class="font-bold text-5xl tracking-tight text-theme-color-4 no-underline">
                <img class="w-32" src="../../assets/okua.svg" alt="okua">
            </a>
        </div>

        <div class="flex items-center flex-no-shrink text-black text-center">
            <button v-ripple class="rounded-full hover:bg-grey-light text-theme-color-4 hover:text-theme-color-4-darker">
                <!--<font-awesome-icon :icon="iconUser" class="my-2 mx-3 text-2xl cursor-pointer" />-->
            </button>
            <button v-ripple class="rounded-full hover:bg-grey-light text-theme-color-4 hover:text-theme-color-4-darker">
                <font-awesome-icon :icon="iconSignOut" class="my-2 mx-3 text-2xl cursor-pointer" @click="logout"/>
            </button>

        </div>
    </nav>
</template>

<script>
  import {faBars, faSignOutAlt, faUser} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import RouteUtils from "../../js/utils/route-utils";

  const methods = {
    openMenu() {
      this.$store.dispatch('toggleSidebar');
    },
    logout(){
      RouteUtils.getlogOut();
    }
  };

  const computed = {
    open() {
      return this.$store.state.section.sidebarOpen;
    },

    clearListMarkersFlag() {
      return this.$store.state.ui.clearListMarkersFlag;
    },

    iconMenu() {
      return faBars;
    },

    iconUser() {
      return faUser;
    },

    iconSignOut() {
      return faSignOutAlt;
    },
  };

  export default {
    methods,
    computed,

    name: "app-navbar",

    components: {
      FontAwesomeIcon,
    },
  }
</script>

<style scoped>
    button {
        outline: none;
    }
</style>