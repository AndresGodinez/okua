import RouteUtils from "../utils/route-utils"

const types = {
};

const state = {
  sections: [
    {id: 0, name: 'Usuarios', icon: 'https://demo.opensourcepos.org/images/menubar/sales.png', route: '/users', },
    {id: 1, name: 'Respuestas de email', icon: 'https://demo.opensourcepos.org/images/menubar/expenses_categories.png', route: '/alert-email-responses',},
    {id: 2, name: 'Emisores', icon: 'https://demo.opensourcepos.org/images/menubar/item_kits.png', route: '/emitters',},
    {id: 3, name: 'Filtros de emisor', icon: 'https://demo.opensourcepos.org/images/menubar/items.png', route: '/filter-emitters',},
    {id: 4, name: 'Filtros de Receptor', icon: 'https://demo.opensourcepos.org/images/menubar/expenses.png', route: '/filter-receptors',},
  ],
  active: 'users'
};

const getters = {
  user: state => state.user,
};

const actions = {
  changeSection({ commit, state }, section) {
    RouteUtils.adminSections(section.route);
  },
};

const mutations = {
};

export default {
  state,
  getters,
  actions,
  mutations,
}