import { createRouter, createWebHistory } from "vue-router";
import Sliders from "./components/pages/Sliders.vue";
import Settings from "./components/pages/Settings.vue";
import About from "./components/pages/About.vue";
import AddSlider from "./components/pages/AddSlider";

const basePath = `${cfadminObj.adminUrl}/admin.php?page=cf-kc-simple-slider#`;

const routes = [
    { path: '/',name:'main', components: { default: Sliders } },
    { path: '/settings',name:'Settings', components: { default: Settings } },
    { path: '/about',name:'About', components: { default: About } },
    { path: '/add',name:'add', components: { default: AddSlider } },
]

const router = createRouter({
    history: createWebHistory(basePath),
    routes,
});

export default router;