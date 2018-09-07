<template>
    <div class="wrap-collabsible w-full bg-transparent">
        <input id="cit-filters-container" class="cit-collapsible-toggle" type="checkbox">
        <label for="cit-filters-container"
               class="cit-collapsible-lbl-toggle hover:text-grey-light block text-2xl text-white font-bold uppercase bg-theme-color-3 p-4 text-center rounded-sm">Filtros</label>
        <div class="cit-collapsible-content overflow-hidden">
            <div class="cit-collapsible-content-inner bg-white shadow-lg pt-2 pb-2">
                <div class="flex flex-col m-auto p-4 w-4/5">
                    <div class="inline-flex mt-4 ml-4">
                        <div class="flex-1 font-sans text-lg uppercase text-center">Codigo</div>
                        <div class="flex-1 font-sans text-lg uppercase text-center">Descripci&oacute;n</div>
                        <div class="flex-1 font-sans text-lg uppercase text-center">Email</div>
                        <div class="flex-1 font-sans text-lg uppercase text-center">Id de CFDI</div>
                    </div>
                    <div class="inline-flex mt-4 ml-4">
                        <div class="flex-1 flex justify-center relative mx-2 shadow">
                            <select class="block appearance-none w-full bg-white border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight uppercase"
                                    id="cit-filters-client" v-model="code"
                                    @change="updateClientRfcFilter">
                                <option value="" class="uppercase">Seleccionar</option>
                                <option v-for="item in warningData" v-bind:value="item.code" class="uppercase">{{ item.code }}
                                </option>
                            </select>
                            <select-caret/>
                        </div>
                        <div class="flex-1 flex justify-center mx-2">
                          <select class="block appearance-none w-full bg-white border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight uppercase"
                                    id="cit-filters-client" v-model="description"
                                    @change="updateClientRfcFilter">
                                <option value="" class="uppercase">Seleccionar</option>
                                <option v-for="item in warningData" v-bind:value="item.description" class="uppercase">{{ item.description }}
                                </option>
                            </select>
                            <select-caret/>
                        </div>
                        <div class="flex-1 flex justify-center mx-2">
                            <select class="block appearance-none w-full bg-white border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight uppercase"
                                    id="cit-filters-client" v-model="email"
                                    @change="updateClientRfcFilter">
                                <option value="" class="uppercase">Seleccionar</option>
                                <option v-for="item in warningData" v-bind:value="item.email" class="uppercase">{{ item.email }}
                                </option>
                            </select>
                            <select-caret/>
                        </div>
                        <div class="flex-1 flex justify-center mx-2">
                            <select class="block appearance-none w-full bg-white border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight uppercase"
                                    id="cit-filters-client" v-model="cfdiId"
                                    @change="updateClientRfcFilter">
                                <option value="" class="uppercase">Seleccionar</option>
                                <option v-for="item in warningData" v-bind:value="item.cfdiId" class="uppercase">{{ item.cfdiId }}
                                </option>
                            </select>
                            <select-caret/>
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
  import ProcessErrorService from "../../../js/services/process-error-service";
  const data = function () {
    return {
      errorData: [],

      code: '',
      description: '',
      email: '',
      cfdiId: 0
    }
  };

  const methods = {
    dispatchGetFilteredTableData() {
      this.$store.dispatch('toggleDispatchBillsTableRefresh');
    },

    dispatchGetErrorData() {
      this.getErrorData()
        .then(response => this.errorData = response.data);
    },

    async getErrorData(limit = 5) {
      let service = new ProcessErrorService();
      return await service.getEveryProcessWarning();
    },

    updateCodeFilter() {
      this.$store.dispatch('changeCodeFilter', this.code);
    },
    
    updateDescriptionFilter() {
      this.$store.dispatch('changeDescriptionFilter', this.description);
    },
    
    updateEmailFilter() {
      this.$store.dispatch('changeEmailFilter', this.email);
    },

    updateCfdiIdFilter() {
      this.$store.dispatch('changeCfdiIdFilter', this.cfdiId);
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

    name: 'warning-table-filters',
    components: {
      SelectCaret,
      FontAwesomeIcon,
    },
    mounted() {
      setTimeout(() => this.dispatchGetWarningData(), 500);
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