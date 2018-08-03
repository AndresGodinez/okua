const types = {
  SET_DATETIME_RANGE_FILTER: 'SET_DATETIME_RANGE_FILTER',
  SET_GROUPED_DATA_FILTER: 'SET_GROUPED_DATA_FILTER',
};

const state = {
  datetimeRangeFilter: 1,
  groupedDataFilter: 1,
};

const getters = {
};

const actions = {
  changeDatetimeRangeFilter({commit}, value) {
    commit(types.SET_DATETIME_RANGE_FILTER, value);
  },

  changeGroupedDataFilter({commit}, value) {
    commit(types.SET_GROUPED_DATA_FILTER, value);
  },
};

const mutations = {
  [types.SET_DATETIME_RANGE_FILTER](state, value) {
    state.datetimeRangeFilter = value;
  },

  [types.SET_GROUPED_DATA_FILTER](state, value) {
    state.groupedDataFilter = value;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
}
