import { defineStore } from "pinia";
import api from "../axios";

export const useJuriStore = defineStore("juriAuth", {
    state: () => ({
        juri: null,
        isLoading: false,
        error: null,
        isInitialized: false, // Track if initial session check is complete
    }),

    getters: {
        // Getter untuk memeriksa apakah juri sudah login
        isAuthenticated: (state) => !!state.juri,
        // Getter untuk mendapatkan data juri yang sedang login
        currentJuri: (state) => state.juri,
        // Check if session check is complete
        isReady: (state) => state.isInitialized,
    },

    actions: {
        async getJuri() {
            this.isLoading = true;
            try {
                const response = await api.get("/juri");
                this.juri = response.data;
                return response.data;
            } catch (error) {
                // Jika gagal (misal: session expired), pastikan state juri kosong
                this.juri = null;
                return null;
            } finally {
                this.isLoading = false;
                this.isInitialized = true;
            }
        },

        async login(credentials) {
            this.isLoading = true;
            this.error = null;
            try {
                // 1. Ambil CSRF cookie
                await api.get("/sanctum/csrf-cookie");

                // 2. Kirim request login DAN TANGKAP responsnya
                const response = await api.post("/login", credentials);

                // 3. Langsung gunakan data 'user' dari respons login
                if (response.data && response.data.user) {
                    this.juri = response.data.user;
                } else {
                    // Fallback jika respons tidak sesuai harapan
                    await this.getJuri();
                }
                
                return this.juri;
            } catch (err) {
                this.juri = null;
                if (err.response && err.response.status === 422) {
                    this.error = "Email atau password salah.";
                } else {
                    this.error = "Terjadi kesalahan pada server.";
                }
                throw new Error(this.error);
            } finally {
                this.isLoading = false;
            }
        },

        async logout() {
            this.isLoading = true;
            this.error = null;
            try {
                await api.post("/logout");
                this.juri = null;
                this.isInitialized = true;
            } catch (error) {
                console.error("Gagal logout:", error);
                this.error = "Gagal melakukan logout.";
                throw new Error(this.error);
            } finally {
                this.isLoading = false;
            }
        },

        async validateSession() {
            // Quick session validation without loading state
            try {
                const response = await api.get("/juri");
                this.juri = response.data;
                return true;
            } catch (error) {
                this.juri = null;
                return false;
            }
        },

        async waitForInitialization() {
            // Wait for initial session check to complete
            if (this.isInitialized) {
                return;
            }
            
            return new Promise((resolve) => {
                const checkInitialization = () => {
                    if (this.isInitialized) {
                        resolve();
                    } else {
                        setTimeout(checkInitialization, 50);
                    }
                };
                checkInitialization();
            });
        },
    },
});
