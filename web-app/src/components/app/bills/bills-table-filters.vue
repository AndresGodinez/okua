<template>
    <div class="wrap-collabsible w-full bg-transparent">
        <input id="cit-filters-container" class="cit-collapsible-toggle" type="checkbox">
        <label for="cit-filters-container"
               class="cit-collapsible-lbl-toggle hover:text-grey-light block text-2xl text-white font-bold uppercase bg-theme-color-3 p-4 text-center rounded-sm">Filtros</label>

        <div class="cit-collapsible-content overflow-hidden">
            <div class="cit-collapsible-content-inner bg-white shadow-lg pt-2 pb-2">
                <div class="flex flex-col m-auto p-4 w-4/5">
                    <div class="inline-flex mt-4 ml-4">
                        <div class="flex-1 font-sans text-lg uppercase text-center">Cliente</div>
                        <div class="flex-1 font-sans text-lg uppercase text-center">Monto inicial</div>
                        <div class="flex-1 font-sans text-lg uppercase text-center">Monto final</div>
                    </div>
                    <div class="inline-flex mt-4 ml-4">
                        <div class="flex-1 flex justify-center relative mx-2 shadow">
                            <select class="block appearance-none w-full bg-white border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight uppercase"
                                    id="cit-filters-client" v-model="client">
                                <option value="" class="uppercase">Seleccionar</option>
                                <option v-for="item in clientsData" v-bind:value="item.rfc" class="uppercase">{{
                                    item.name }}
                                </option>
                            </select>
                            <select-caret/>
                        </div>
                        <div class="flex-1 flex justify-center mx-2">
                            <input type="number"
                                   class="shadow appearance-none border rounded w-full text-grey-darker leading-tight text-right px-4"
                                   name="initial-amount" v-model="initialAmount">
                        </div>
                        <div class="flex-1 flex justify-center mx-2">
                            <input type="number"
                                   class="shadow appearance-none border rounded w-full text-grey-darker leading-tight text-right px-4"
                                   name="final-amount" v-model="finalAmount">
                        </div>
                    </div>
                    <div class="flex justify-end px-4 mt-4">
                        <button v-ripple
                                class="text-left h-16 px-4 bg-theme-color-3 hover:bg-theme-color-3-lighter text-white rounded"
                                @click="dispatchGetFilteredTableData">
                            <font-awesome-icon :icon="iconFilterBtn"/>
                            <span class="ml-2 uppercase">Filtrar Datos</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  import SelectCaret from "../../shared/select-caret"
  import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
  import {faFilter} from '@fortawesome/free-solid-svg-icons';


  const data = function () {
    let clientsData = [
      {rfc: 'TOSI830410YYY', name: 'Israel Torres'},
      {rfc: 'MOYA000000YYY', name: 'Adán Morales'},
    ];

    return {
      clientsData,

      client: '',
      initialAmount: 0,
      finalAmount: 0,
    }
  };

  const methods = {
    dispatchGetFilteredTableData() {

    },
  };

  const computed = {
    iconFilterBtn() {
      return faFilter;
    },
  };

  export default {
    data,
    methods,
    computed,

    name: 'bills-table-filters',
    components: {
      SelectCaret,
      FontAwesomeIcon,
    },
  }
</script>
<style scoped>
    input[type='checkbox'] {
        display: none;
    }

    .cit-collapsible-lbl-toggle {
        transition: all 0.25s ease-out;
    }

    .cit-collapsible-lbl-toggle::before {
        content: ' ';
        display: inline-block;

        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        border-left: 5px solid currentColor;

        vertical-align: middle;
        margin-right: .7rem;
        transform: translateY(-2px);

        transition: transform .2s ease-out;
    }

    .cit-collapsible-content {
        max-height: 0;
        transition: max-height .25s ease-in-out;
    }

    .cit-collapsible-toggle:checked + .cit-collapsible-lbl-toggle + .cit-collapsible-content {
        max-height: 350px;
    }

    .cit-collapsible-toggle:checked + .cit-collapsible-lbl-toggle::before {
        transform: rotate(90deg) translateX(-3px);
    }

    .cit-collapsible-toggle:checked + .cit-collapsible-lbl-toggle {
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>