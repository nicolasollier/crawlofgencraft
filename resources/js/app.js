import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import StoreProvider from '@/Layouts/StoreProvider.vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'CrawlOfGencraft';

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

createInertiaApp({
    title: () => appName,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({
            render: () => h(StoreProvider, null, {
                default: () => h(App, props)
            })
        })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}).then(() => {
    window.document.getElementById('app').removeAttribute('data-page');
});
