import moment from "moment-es6";

let startDatetime = moment().hour(0).minute(0).second(0).format('YYYY-MM-DD HH:mm:ss');
let endDatetime = moment().hour(23).minute(59).second(59).format('YYYY-MM-DD HH:mm:ss');
let filterDateType = 1;

const types = {
  SET_START_DATETIME_FILTER: 'SET_START_DATETIME_FILTER',
  SET_END_DATETIME_FILTER: 'SET_END_DATETIME_FILTER',
  SET_DISPATCH_BILLS_TABLE_REFRESH: 'SET_DISPATCH_BILLS_TABLE_REFRESH',
  SET_FILTER_DATE_TYPE: 'FILTER_DATE_TYPE',
};

const state = {
  startDatetime,
  endDatetime,
  filterDateType,

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
