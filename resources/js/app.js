
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import reveal from './directives/reveal';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .directive('reveal', reveal)
            .mount(el);
    },
    progress: {
        color: '#B2292E',
    },
});

// Transición de página: reinicia el fade-up del contenido en cada navegación.
router.on('navigate', () => {
    const app = document.getElementById('app');
    if (!app) return;
    app.classList.remove('lb-page-enter');
    void app.offsetWidth; // fuerza reflow para reiniciar la animación
    app.classList.add('lb-page-enter');
});
