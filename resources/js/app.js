require("./bootstrap");
import vue from "vue";
window.Vue = vue;

import App from "./components/App.vue";
import VueRouter from "vue-router";
import VueAxios from "vue-axios";
import axios from "axios";
import { routes } from "./routes";
import vmodal from 'vue-js-modal'

 
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(vmodal);

const router = new VueRouter({
    mode: "history",
    routes: routes,
});

const app = new Vue({
    el: "#app",
    router: router,
    render: (h) => h(App),
});
