import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

import { ZiggyVue } from "ziggy-vue";
import { Ziggy } from "./ziggy";
import "../css/app.css";
import "../sass/app.scss";
import "./bootstrap";

InertiaProgress.init();

createInertiaApp({
    resolve: async (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component("Link", Link)
            .component("Head", Head)
            .mixin({ methods: { route: window.route } })
            .mount(el);
    },
});
