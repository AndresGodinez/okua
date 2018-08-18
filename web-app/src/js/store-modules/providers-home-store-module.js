const types = {
  SET_DATETIME_RANGE_FILTER: 'SET_DATETIME_RANGE_FILTER',
  SET_GROUPED_DATA_FILTER: 'SET_GROUPED_DATA_FILTER',
  SET_FORCE_UPDATE_BY_NEW_REGISTERS: 'SET_FORCE_UPDATE_BY_NEW_REGISTERS',
};

const state = {
  datetimeRangeFilter: 1,
  groupedDataFilter: 1,

  forceUpdateByNewRegisters: false,
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

  toggleForceUpdateByNewRegisters({commit, state}) {
    commit(types.SET_FORCE_UPDATE_BY_NEW_REGISTERS, !state.forceUpdateByNewRegisters);
  },
};

const mutations = {
  [types.SET_DATETIME_RANGE_FILTER](state, value) {
    state.datetimeRangeFilter = value;
  },

  [types.SET_GROUPED_DATA_FILTER](state, value) {
    state.groupedDataFilter = value;
  },

  [types.SET_FORCE_UPDATE_BY_NEW_REGISTERS](state, value) {
    state.forceUpdateByNewRegisters = value;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
}