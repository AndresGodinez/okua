const types = {
  SET_FORCE_UPDATE_BY_NEW_REGISTERS: 'SET_FORCE_UPDATE_BY_NEW_REGISTERS',
};

const state = {
  forceUpdateByNewRegisters: false,
};

const getters = {
};

const actions = {
  toggleForceUpdateByNewRegisters({commit, state}) {
    commit(types.SET_FORCE_UPDATE_BY_NEW_REGISTERS, !state.forceUpdateByNewRegisters);
  },
};

const mutations = {
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
