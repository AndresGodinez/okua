<template>
    <nav class="ct-flex ct-justify-between ct-flex-wrap ct-bg-brown-light ct-p-6">
        <div class="ct-flex ct-items-center ct-flex-no-shrink ct-text-black ct-text-center">
            <i class="fas fa-bars fa-2x"></i>
        </div>
        <div class="ct-flex ct-items-center ct-flex-no-shrink ct-text-black ct-text-center">
            <span class="ct-font-normal ct-text-5xl ct-tracking-tight">OKUA</span>
        </div>

        <div class="ct-flex ct-items-center ct-flex-no-shrink ct-text-black ct-text-center">
            <i class="fas fa-user fa-2x ct-m-2"></i>
            <i class="fas fa-sign-out-alt fa-2x ct-m-2"></i>
        </div>
    </nav>
</template>

<script>
  export default {
    name: "app-navbar",
  }
</script>

<style scoped>
    button {
        outline: none;
    }
</style>