import Vue from "vue";
import VueMeta from "vue-meta";
import PortalVue from "portal-vue";
import Loading from "@/Shared/Components/Loading";
import { InertiaApp } from "@inertiajs/inertia-vue";

Vue.component("loading", Loading);
Vue.config.productionTip = false;
Vue.mixin({ methods: { route: window.route } });
Vue.use(InertiaApp);
Vue.use(PortalVue);
Vue.use(VueMeta);
Vue.mixin({
    methods: {
        lightenColor(col, amt) {
            let usePound = false;

            if (col[0] == "#") {
                col = col.slice(1);
                usePound = true;
            }

            let num = parseInt(col, 16);

            let r = (num >> 16) + amt;

            if (r > 255) r = 255;
            else if (r < 0) r = 0;

            let b = ((num >> 8) & 0x00ff) + amt;

            if (b > 255) b = 255;
            else if (b < 0) b = 0;

            let g = (num & 0x0000ff) + amt;

            if (g > 255) g = 255;
            else if (g < 0) g = 0;

            return (
                (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
            );
            // var num = parseInt(color.replace("#", ""), 16),
            //     amt = Math.round(2.55 * percent),
            //     R = (num >> 16) + amt,
            //     B = ((num >> 8) & 0x00ff) + amt,
            //     G = (num & 0x0000ff) + amt;
            // return (
            //     "#" +
            //     (
            //         0x1000000 +
            //         (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 +
            //         (B < 255 ? (B < 1 ? 0 : B) : 255) * 0x100 +
            //         (G < 255 ? (G < 1 ? 0 : G) : 255)
            //     )
            //         .toString(16)
            //         .slice(1)
            // );
        }
    }
});
Vue.component("Avatar", () => import("@/Shared/Partials/User/Avatar"));
Vue.component("AvatarModal", () =>
    import("@/Shared/Partials/User/AvatarModal")
);

let app = document.getElementById("app");

new Vue({
    metaInfo: {
        titleTemplate: title => (title ? `${title} - ELPMS` : "ELPMS")
    },

    render: h =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: name =>
                    import(`@/Pages/${name}`).then(module => module.default)
            }
        })
}).$mount(app);
