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
Vue.component("Avatar", () => import("@/Components/Avatar"));

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
