const getUsers = (params = {}) => {
    const account = store.state.account.entity;
    return axios.get(`${origin}/api/v1/accounts/${account.uuid}/users`, {
        params,
    });
};

const postUser = (form) => {
    const account = store.state.account.entity;
    return axios.get(`${origin}/api/v1/accounts/${account.uuid}/users`, form);
};

const getUsersApiUrl = () => {
    const account = store.state.account.entity;
    return `${origin}/api/v1/accounts/${account.uuid}/packages/admin/users`;
};

export default {
    getUsers,
    postUser,
    getUsersApiUrl,
};
