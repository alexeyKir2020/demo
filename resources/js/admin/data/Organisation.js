export default {
    ENTITY: "Organisation",
    SLUG: "organisations",

    text: {
        new: 'организации',
        edit: 'организацию',
        onPage: 'Организаций на странице'
    },

    item: {
        id: '',
        title: '',
        reg_number: '',
        link: '',
        type: {
            id: 0,
            name: '',
        },
        city: {
            id: 0,
            name: '',
        },
        contact_person: '',
        email: '',
        phone: '',
        addition_phone: '',
        addition_email: ''
    },

    data: {
        items: [],
        meta: {
            cities: [],
            organisation_types: [],
        }
    },

    rules: {

    }
};
