<template>
    <div class="flex flex-col">
        <app-navbar></app-navbar>
        <app-menu></app-menu>
        <div class="inline-flex w-1/5 mt-4 ml-48">
            <div class="flex-1 font-sans mb-4 mr-16">Fecha de Inicio:</div>
            <div class="flex-1 font-sans mb-4">Fecha fin:</div>
        </div>
        <div class="inline-flex w-1/5 ml-48">
            <div class="flex-1 font-sans mb-4 mr-16">
                <datetime input-class="bg-white shadow border-2 border-grey py-2 rounded-sm font-sans"
                          v-model="startDate" type="datetime"></datetime>
            </div>
            <div class="flex-1 font-sans mb-4">
                <datetime input-class="bg-white shadow border-2 border-grey py-2 rounded-sm -ml-4 font-sans"
                          v-model="endDate" type="datetime"></datetime>
            </div>
        </div>
        <div class="flex flex-col m-auto border-2 p-4 w-4/5 border-black mt-12">
            <div class="flex1">
                <font-awesome-icon :icon="iconToggleFilters" class="mb-2 pointer-events-auto"/>
            </div>
            <div class="flex-1 text-2xl uppercase ml-4">Filtros</div>
            <div class="inline-flex mt-4 ml-4">
                <div class="flex-1 font-sans text-lg">Cliente:</div>
                <div class="flex-1 font-sans text-lg">Estatus:</div>
                <div class="flex-1 font-sans text-lg">Monto inicial:</div>
                <div class="flex-1 font-sans text-lg">Monto final:</div>
            </div>
            <div class="inline-flex ml-4 mt-4">
                <div class="flex-1">
                    <input type="text" class="shadow appearance-none border rounded w-32 text-grey-darker leading-tight"
                           name="client" v-model="client">
                </div>
                <div class="flex-1">
                    <input type="text" class="shadow appearance-none border rounded w-32 text-grey-darker leading-tight"
                           name="status" v-model="status">
                </div>
                <div class="flex-1">
                    <input type="text" class="shadow appearance-none border rounded w-32 text-grey-darker leading-tight"
                           name="initial-amount" v-model="initialAmount">
                </div>
                <div class="flex-1">
                    <input type="text" class="shadow appearance-none border rounded w-32 text-grey-darker leading-tight"
                           name="final-amount" v-model="finalAmount">
                </div>
            </div>
        </div>
        <div class="flex border-2 border-black p-24 w-2/3 mt-24 m-auto">tabla</div>
    </div>
</template>

<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";
  import {Datetime} from 'vue-datetime';
  import 'vue-datetime/dist/vue-datetime.css';
  import {faTimes} from '@fortawesome/free-solid-svg-icons';
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

  const data = function () {
    return {
      startDate: '',
      endDate: '',
      client: '',
      status: '',
      initialAmount: '',
      finalAmount: '',
    };
  };

  const methods = {};

  const computed = {
    iconToggleFilters() {
      return faTimes;
    },
  };

  export default {
    data,
    methods,
    computed,

    name: "bills-content",
    components: {
      AppNavbar,
      AppMenu,
      FontAwesomeIcon,
      datetime: Datetime,
    },
  }
</script>

<style scoped>

</style>