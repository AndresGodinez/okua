import moment from "moment-es6";

let startDatetime = moment().hour(0).minute(0).second(0).format('YYYY-MM-DD HH:mm:ss');
let endDatetime = moment().hour(23).minute(59).second(59).format('YYYY-MM-DD HH:mm:ss');
let clientRfc = '';
let initialAmount = 0;
let finalAmount = 0;
let filterDateType = 1;

const types = {
  SET_START_DATETIME_FILTER: 'SET_START_DATETIME_FILTER',
  SET_END_DATETIME_FILTER: 'SET_END_DATETIME_FILTER',
  SET_CLIENT_RFC_FILTER: 'SET_CLIENT_RFC_FILTER',
  SET_INITIAL_AMOUNT_FILTER: 'SET_INITIAL_AMOUNT_FILTER',
  SET_FINAL_AMOUNT_FILTER: 'SET_FINAL_AMOUNT_FILTER',
  SET_DISPATCH_BILLS_TABLE_REFRESH: 'SET_DISPATCH_BILLS_TABLE_REFRESH',
  SET_FILTER_DATE_TYPE: 'FILTER_DATE_TYPE',
};

const state = {
  startDatetime,
  endDatetime,
  filterDateType,
  clientRfc,
  initialAmount,
  finalAmount,

  dispatchBillsTableRefresh: false,
};

const getters = {
};

const actions = {
  changeStartDatetimeFilter({commit}, value) {
    commit(types.SET_START_DATETIME_FILTER, value);
  },

  changeEndDatetimeFilter({commit}, value) {
    commit(types.SET_END_DATETIME_FILTER, value);
  },

  changeFilterDateType({commit}, value) {
    commit(types.SET_FILTER_DATE_TYPE, value);
  },

  changeClientRfcFilter({commit}, value) {
    commit(types.SET_CLIENT_RFC_FILTER, value);
  },

  changeInitialAmountFilter({commit}, value) {
    commit(types.SET_INITIAL_AMOUNT_FILTER, value);
  },

  changeFinalAmountFilter({commit}, value) {
    commit(types.SET_FINAL_AMOUNT_FILTER, value);
  },

  toggleDispatchBillsTableRefresh({commit, state}) {
    commit(types.SET_DISPATCH_BILLS_TABLE_REFRESH, !state.dispatchBillsTableRefresh);
  },
};

const mutations = {
  [types.SET_START_DATETIME_FILTER](state, value) {
    state.startDatetime = value;
  },

  [types.SET_FILTER_DATE_TYPE](state, value) {
    state.filterDateType = value;
  },

  [types.SET_END_DATETIME_FILTER](state, value) {
    state.endDatetime = value;
  },

  [types.SET_CLIENT_RFC_FILTER](state, value) {
    state.clientRfc = value;
  },

  [types.SET_INITIAL_AMOUNT_FILTER](state, value) {
    state.initialAmount = value;
  },

  [types.SET_FINAL_AMOUNT_FILTER](state, value) {
    state.finalAmount = value;
  },

  [types.SET_DISPATCH_BILLS_TABLE_REFRESH](state, value) {
    state.dispatchBillsTableRefresh = value;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
}
