import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import ru from 'vuetify/es5/locale/ru';

Vue.use(Vuetify)

const opts = {
    theme: {
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                primary: '#274684',
                secondary: '#424242',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107'
            },
        },
    },
    lang: {
        locales: { ru },
        current: 'ru',
    },
}

export default new Vuetify(opts)


