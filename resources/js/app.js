// app.js atau main.js
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import { useJuriStore } from "./stores/juriStore";

async function initializeApp() {
    const app = createApp(App);
    const pinia = createPinia();
    app.use(pinia);

    const juriStore = useJuriStore();
    // Coba login otomatis jika ada token tersimpan
    await juriStore.tryAutoLogin();

    app.use(router);
    app.mount("#app");
}

initializeApp();