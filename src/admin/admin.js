import { createApp } from "vue";
import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css';
import App from "./App.vue";
import router from "./routes.js";
import store from "../store";

const app = createApp( App );
app.use(router);
app.use(store);
app.use(VueSweetalert2);
app.mount("#cf-admin-app");