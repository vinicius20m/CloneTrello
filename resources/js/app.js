import Vue from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue'
import Vuetify from 'vuetify';
import Layout from './components/Layout'
import Snack from './components/Home/Snack'

import "../css/app.css" ;


Vue.component('Layout', Layout)
Vue.component('Head', Head)
Vue.component('Link', Link)
Vue.component('Snack', Snack)

Vue.use(Vuetify)
let noInertiaActions = [
  'login',
  'register',
  'home',
]
const pageAction = document.location.href.split('/')[3];
let isInertia = noInertiaActions.includes(pageAction) ? false : true

if(isInertia)
  createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
      Vue.use(plugin)

      new Vue({
        vuetify: new Vuetify(),
        render: h => h(App, props),
      }).$mount(el)
    },
  })