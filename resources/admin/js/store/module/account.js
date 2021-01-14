const account = {
    namespaced: true,
    state: {
        init: false,
        loading: false,
        entity: null,
        user: null,
    },
    mutations: {
        setInit(state) {
            state.init = true;
        },
        setLoading(state, value) {
            state.loading = value;
        },
        setEntity(state, value) {
            state.entity = value;
        },
        setUser(state, value) {
            state.user = value;
        },
        setAccountUuid(state, value) {
            state.accountUuid = value;
        },
    },
    actions: {
        init({ commit }, { entity, user }) {
            commit('setEntity', entity);
            commit('setUser', user);
            commit('setAccountUuid', entity.uuid);
            commit('setLoading', true);

            commit('setInit');
            commit('setLoading', false);
        },
    },
    getters: {},
};
export default account;
