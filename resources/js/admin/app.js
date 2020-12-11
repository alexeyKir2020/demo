require('./bootstrap')
import Vue from 'vue'

import Constants from './components/common/Constants'
Vue.use(Constants)

import { VueMaskDirective } from 'v-mask'
Vue.directive('mask', VueMaskDirective);

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Layout from "./components/Layout/Layout";
import vuetify from './plugins/vuetify'

import routes from './routes'
let router = new VueRouter({ mode: 'history', base: '/admin/', routes })

Vue.prototype.$api_url = '/api/v1/'


//TODO move import to components
import { TiptapVuetifyPlugin } from 'tiptap-vuetify'
import 'tiptap-vuetify/dist/main.css'

Vue.use(TiptapVuetifyPlugin, {
    vuetify,
    iconsGroup: 'mdi'
})

const App = new Vue({
    el: '#admin-app',
    router,
    vuetify,
    components: { Layout },
});
