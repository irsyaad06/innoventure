import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: process.env.APP_ENV === "local", // HMR hanya aktif di local
            devServer: process.env.APP_ENV === "local" ? undefined : false, // Matikan dev server di production
        }),
        tailwindcss(),
        vue(),
    ],
});
