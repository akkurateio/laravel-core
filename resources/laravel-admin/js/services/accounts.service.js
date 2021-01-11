const getAccounts = (params = {}) => {
    return axios.get(
        `${origin}/api/v1/accounts/${
            location.pathname.split('/')[2]
        }/packages/admin/accounts`,
        { params }
    );
};

export default {
    getAccounts,
};
