const types = {
  SET_DATETIME_RANGE_FILTER: 'SET_DATETIME_RANGE_FILTER',
};

const state = {
  datetimeRangeFilter: 1,
};

const getters = {
};

const actions = {
  changeDatetimeRangeFilter({commit}, value) {
    commit(types.SET_DATETIME_RANGE_FILTER, value);
  },
};

const mutations = {
  [types.SET_DATETIME_RANGE_FILTER](state, value) {
    state.datetimeRangeFilter = value;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
}
