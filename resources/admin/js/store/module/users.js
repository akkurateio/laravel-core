export default {
    namespaced: true,
    state: {
        loading: false,
        items: [],
    },
    mutations: {
        setItems(state, value) {
            state.items = value;
        },
        setLoading(state, value) {
            state.loading = value;
        },
    },
    actions: {
        async fetchAll({ rootState, commit }, { event, id }) {
            commit('setLoading', true);
            const accountUUID = rootState.account.entity.uuid;
            const api = `${origin}/api/v1/accounts/${accountUUID}/packages/admin/${event}/${id}/users`;
            const { data } = await axios.get(api);
            commit('setItems', data);
            commit('setLoading', false);
        },
        async addItem({ dispatch,rootState }, { item, event, id }) {
            const accountUUID = rootState.account.entity.uuid;
            await axios.post(
                `${origin}/api/v1/accounts/${accountUUID}/packages/admin/${event}/${id}/users/attach`,
                {contacts: [item.id]}
            );
            await dispatch('fetchAll', { event, id });
        },
        async removeItem({ dispatch, rootState }, { item, event, id }) {
            const accountUUID = rootState.account.entity.uuid;
            await axios.post(
                `${origin}/api/v1/accounts/${accountUUID}/packages/admin/${event}/${id}/users/detach`,
                { contacts: [item.id] }
            );
            await dispatch('fetchAll', { event, id });
        },
    },
    getters: {},
};
