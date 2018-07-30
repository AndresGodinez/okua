<template>
    <div class="ct-flex ct-flex-col">
        <app-navbar></app-navbar>
        <div class="ct-inline-flex ct-w-1/5 ct-mt-4 ct-ml-48">
            <div class="ct-flex-1 ct-font-sans ct-mb-4 ct-mr-16">Fecha de Inicio: </div>
            <div class="ct-flex-1 ct-font-sans ct-mb-4">Fecha fin: </div>
        </div>
        <div class="ct-inline-flex ct-w-1/5 ct-ml-48">
            <div class="ct-flex-1 ct-font-sans ct-mb-4 ct-mr-16">
                <datetime input-class="ct-bg-white ct-shadow ct-border-2 ct-border-grey ct-py-2 ct-rounded-sm ct-font-sans" v-model="startDate"></datetime>
            </div>
            <div class="ct-flex-1 ct-font-sans ct-mb-4">
                <datetime input-class="ct-bg-white ct-shadow ct-border-2 ct-border-grey ct-py-2 ct-rounded-sm ct--ml-4 ct-font-sans" v-model="endDate" use12-hour></datetime>
            </div>
        </div>
        <div class="ct-flex ct-flex-col ct-m-auto ct-border-2 ct-p-4 ct-w-4/5 ct-border-black ct-mt-12">
            <div class="ct-flex-1 ct-text-2xl ct-uppercase ct-ml-4">Filtros</div>
            <div class="ct-inline-flex ct-mt-4 ct-ml-4">
                <div class="ct-flex-1 ct-font-sans ct-text-lg">Cliente:</div>
                <div class="ct-flex-1 ct-font-sans ct-text-lg">Estatus:</div>
                <div class="ct-flex-1 ct-font-sans ct-text-lg">Monto inicial:</div>
                <div class="ct-flex-1 ct-font-sans ct-text-lg">Monto final:</div>
            </div>
            <div class="ct-inline-flex ct-ml-4 ct-mt-4">
                <div class="ct-flex-1">
                    <input type="text" class="ct-shadow ct-appearance-none ct-border ct-rounded ct-w-32 ct-text-grey-darker ct-leading-tight" name="client" v-model="client">
                </div>
                <div class="ct-flex-1">
                    <input type="text" class="ct-shadow ct-appearance-none ct-border ct-rounded ct-w-32 ct-text-grey-darker ct-leading-tight" name="status" v-model="status">
                </div>
                <div class="ct-flex-1">
                    <input type="text" class="ct-shadow ct-appearance-none ct-border ct-rounded ct-w-32 ct-text-grey-darker ct-leading-tight" name="initial-amount" v-model="initialAmount">
                </div>
                <div class="ct-flex-1">
                    <input type="text" class="ct-shadow ct-appearance-none ct-border ct-rounded ct-w-32 ct-text-grey-darker ct-leading-tight" name="final-amount" v-model="finalAmount">
                </div>
            </div>
        </div>
        <div class="ct-flex ct-border-2 ct-border-black ct-p-24 ct-w-2/3 ct-mt-24 ct-m-auto">tabla</div>
    </div>
</template>

<script>
  import AppNavbar from "../../shared/app-navbar";
  import { Datetime } from 'vue-datetime';
  import 'vue-datetime/dist/vue-datetime.css';

  export default {
    data() {
      return {
        startDate: '',
        endDate: '',
        client: '',
        status: '',
        initialAmount: '',
        finalAmount: '',
      }
    },
    name: "bills-content",
    components: {
      AppNavbar,
      datetime: Datetime
    },
  }
</script>

<style scoped>
    
</style>