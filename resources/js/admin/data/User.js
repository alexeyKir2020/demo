export default {
    ENTITY: "User",
    SLUG: "users",

    endpoints: {

    },

    text: {
        new: 'пользователя',
        edit: 'пользователя',
        onPage: 'Пользователей на странице'
    },

    item: {
        id: '',
        email: '',
        phone: '',
        password: '',
        password_confirmation: '',
        //name: "",
        created_at: '',
        status: "",
        roles: "",
        permissions: "",
        identity_verified_at: ""
    },

    data: {
        items: [],
        meta: {
            roles: [],
        }
    },

    rules: {

    }
};
