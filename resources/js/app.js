// resources/js/app.js

import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import { useJuriStore } from "./stores/juriStore";
import "flowbite";
import "../css/app.css";

async function initializeApp() {
    const app = createApp(App);
    const pinia = createPinia();

    // 1. Pasang Pinia
    app.use(pinia);

    // 2. Tunggu proses cek login selesai
    const juriStore = useJuriStore();
    await juriStore.tryAutoLogin();

    // 3. Pasang router setelahnya
    app.use(router);

    // 4. Mount aplikasi
    app.mount("#app");
}

// Panggil fungsi untuk memulai semuanya
initializeApp();