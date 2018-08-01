<template>
    <div class="flex flex-col">
        <app-menu></app-menu>

        <app-navbar></app-navbar>

        <div class="inline-flex w-48 mt-4 ml-32">
            <ul class="list-reset flex">
                <li class="mr-3">
                    <div class="inline-block border rounded py-1 px-3" style="cursor: pointer;"
                         v-bind:class="{'border-blue': rangeFilter === 1, 'bg-blue': rangeFilter === 1, 'text-white': rangeFilter === 1, 'text-blue': rangeFilter != 1}"
                         v-on:click="timeFilter('week')">Sem
                    </div>
                </li>
                <li class="mr-3">
                    <div class="inline-block border rounded py-1 px-3"
                         v-bind:class="{'border-blue': rangeFilter === 2, 'bg-blue': rangeFilter === 2, 'text-white': rangeFilter === 2, 'text-blue': rangeFilter != 2}"
                         style="cursor: pointer;" v-on:click="timeFilter('month')">Mes
                    </div>
                </li>
                <li class="mr-3">
                    <div class="inline-block border rounded py-1 px-3"
                         v-bind:class="{'border-blue': rangeFilter === 3, 'bg-blue': rangeFilter === 3, 'text-white': rangeFilter === 3, 'text-blue': rangeFilter != 3}"
                         style="cursor: pointer;" v-on:click="timeFilter('year')">Año
                    </div>
                </li>
            </ul>
        </div>
        <div class="flex flex-col m-auto border-2 p-4">
            <div class="flex-1 text-center mb-6 font-sans font-medium tracking-wide text-2xl">$0000</div>
            <div class="flex-1 text-center uppercase font-sans tracking-wide text-xl">Monto general en facturas</div>
        </div>
        <div class="flex flex-col mt-12">
            <div class="flex-1 w-48 ml-32 tracking-wide text-sm font-sans">Agrupar:</div>
            <div class="inline-flex w-1/6 mt-2 ml-32">
                <ul class="list-reset flex">
                    <li class="mr-3">
                        <div class="inline-block border rounded py-1 px-3"
                             v-bind:class="{'border-blue': groupFilter === 1, 'bg-blue': groupFilter === 1, 'text-white': groupFilter === 1, 'text-blue': groupFilter != 1}"
                             style="cursor: pointer;" v-on:click="groupBy('client')">Cliente
                        </div>
                    </li>
                    <li class="mr-3">
                        <div class="inline-block border rounded py-1 px-3"
                             v-bind:class="{'border-blue': groupFilter === 2, 'bg-blue': groupFilter === 2, 'text-white': groupFilter === 2, 'text-blue': groupFilter != 2}"
                             style="cursor: pointer;" v-on:click="groupBy('cfdi')">Uso CFDI
                        </div>
                    </li>
                    <li class="mr-3">
                        <div class="inline-block border rounded py-1 px-3"
                             v-bind:class="{'border-blue': groupFilter === 3, 'bg-blue': groupFilter === 3, 'text-white': groupFilter === 3, 'text-blue': groupFilter != 3}"
                             style="cursor: pointer;" v-on:click="groupBy('state')">Estados
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col m-auto border-2 mt-4 border-black w-5/6">
            <div class="flex inline-flex">
                <div class="flex-1 text-center border-r-2 p-8 border-b-2">Fecha de Registro</div>
                <div class="flex-1 text-center border-r-2 p-8 border-b-2">Cliente</div>
                <div class="flex-1 text-center border-r-2 p-8 border-b-2">RFC</div>
                <div class="flex-1 text-center border-r-2 p-8 border-b-2">Uso</div>
                <div class="flex-1 text-center border-r-2 p-8 border-b-2">Estatus</div>
                <div class="flex-1 text-center p-8 border-b-2 border-b-black">Monto</div>
            </div>
            <div class="flex inline-flex">
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center p-4 border-b-2 border-b-black"></div>
            </div>
            <div class="flex inline-flex">
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center p-4 border-b-2 border-b-black"></div>
            </div>
            <div class="flex inline-flex">
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center border-r-2 p-4 border-b-2"></div>
                <div class="flex-1 text-center p-4 border-b-2 border-b-black"></div>
            </div>
        </div>
    </div>
</template>
<script>
  import AppNavbar from "../../shared/app-navbar";
  import AppMenu from "../../shared/app-menu";

  const data = function () {
    return {
      rangeFilter: 1,
      groupFilter: 1,
    };
  };

  const methods = {
    timeFilter(range) {
      if (range === 'week') {
        this.rangeFilter = 1
      } else if (range === 'month') {
        this.rangeFilter = 2
      } else if (range === 'year') {
        this.rangeFilter = 3
      }
    },

    groupBy(property) {
      if (property === 'client') {
        this.groupFilter = 1
      } else if (property === 'cfdi') {
        this.groupFilter = 2
      } else if (property === 'state') {
        this.groupFilter = 3
      }
    },
  };

  export default {
    data,
    methods,

    name: "home-content",
    components: {
      AppNavbar,
      AppMenu,
    },
  }
</script>
<style scoped>
</style>