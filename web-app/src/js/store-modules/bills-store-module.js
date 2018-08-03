import moment from "moment-es6";

let startDatetime = moment().hour(0).minute(0).second(0).format('YYYY-MM-DD HH:mm:ss');
let endDatetime = moment().hour(23).minute(59).second(59).format('YYYY-MM-DD HH:mm:ss');

const types = {
  SET_START_DATETIME_FILTER: 'SET_START_DATETIME_FILTER',
  SET_END_DATETIME_FILTER: 'SET_END_DATETIME_FILTER',
};

const state = {
  startDatetime,
  endDatetime,
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
};

const mutations = {
  [types.SET_START_DATETIME_FILTER](state, value) {
    state.startDatetime = value;
  },

  [types.SET_END_DATETIME_FILTER](state, value) {
    state.endDatetime = value;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
}
