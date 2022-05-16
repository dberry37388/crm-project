import Maska from "maska";

require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import axios from 'axios'
import { Model } from 'vue-api-query'

// inject global axios instance as http client to Model
Model.$http = axios

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(Maska)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
