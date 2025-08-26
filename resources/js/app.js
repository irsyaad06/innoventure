// app.js

import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import { useJuriStore } from "./stores/juriStore";
import "flowbite";
import "../css/app.css";

// Create a global loading state for initial app setup
const appLoading = {
    isComplete: false,
    error: null
};

// Create fungsi async untuk memulai aplikasi dengan session persistence
async function initializeApp() {
    const app = createApp(App);
    const pinia = createPinia();

    // Install Pinia first so stores can be used
    app.use(pinia);

    // Get juri store instance
    const juriStore = useJuriStore();

    // Add global properties for loading state
    app.config.globalProperties.$appLoading = appLoading;

    try {
        // Perform initial session check
        console.log('Checking existing session...');
        await juriStore.getJuri();
        
        if (juriStore.isAuthenticated) {
            console.log('Session restored successfully');
        } else {
            console.log('No active session found');
        }
        
    } catch (error) {
        console.error('Session check failed:', error);
        appLoading.error = error;
    } finally {
        appLoading.isComplete = true;
    }

    // Install router after session check
    app.use(router);

    // Mount the application
    app.mount("#app");
}

// Handle page visibility changes for session validation
document.addEventListener('visibilitychange', () => {
    if (!document.hidden) {
        // Page became visible, validate session
        const juriStore = useJuriStore();
        if (juriStore.isAuthenticated) {
            juriStore.validateSession().then(isValid => {
                if (!isValid) {
                    console.log('Session expired, redirecting to login');
                    // Router will handle redirect based on auth state
                }
            });
        }
    }
});

// Start the application
initializeApp().catch(error => {
    console.error('Failed to initialize app:', error);
    // Fallback: mount app even if session check fails
    const app = createApp(App);
    const pinia = createPinia();
    app.use(pinia);
    app.use(router);
    app.mount("#app");
});
