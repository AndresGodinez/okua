const types = {
  SET_IS_LOADING: 'SET_IS_LOADING',
};

const state = {
  isLoading: false,
};

const getters = {
};

const actions = {
  setIsLoading({ commit }) {
    commit(types.SET_IS_LOADING, true);
  },

  unsetIsLoading({ commit }) {
    commit(types.SET_IS_LOADING, false);
  },
};

const mutations = {
  [types.SET_IS_LOADING](state, value) {
    state.isLoading = value;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
}
