import { defineStore } from "pinia";
import api from "../axios";

export const useJuriStore = defineStore("juriAuth", {
    state: () => ({
        juri: null,
        token: localStorage.getItem("authToken") || null,
        isLoading: false,
        error: null,
        juris: [],
    }),

    getters: {
        isAuthenticated: (state) => !!state.juri && !!state.token,
        currentJuri: (state) => state.juri,
        assignedAspekIds: (state) => {
            // Getter ini akan reaktif. Jika state.juri berubah, hasilnya akan berubah.
            return state.juri?.assigned_aspek_ids || [];
        },
    },

    actions: {
        async fetchJuri() {
            this.isLoading = true;
            try {
                const res = await api.get("/list-juri");
                this.juris = res.data.payload;
            } catch (err) {
                this.error = err.response?.data?.message || "Gagal fetch list juri";
            } finally {
                this.isLoading = false;
            }
        },

        async login(credentials) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await api.post("/login", credentials);
                const { user, token } = response.data;
                this.juri = user;
                this.token = token;
                localStorage.setItem("authToken", token);
            } catch (err) {
                this.juri = null;
                this.token = null;
                localStorage.removeItem("authToken");
                throw err; // Lempar error agar bisa ditangani di komponen
            } finally {
                this.isLoading = false;
            }
        },

        async logout() {
            try {
                await api.post("/logout");
            } catch (error) {
                console.error("Logout error:", error);
            } finally {
                this.juri = null;
                this.token = null;
                localStorage.removeItem("authToken");
            }
        },

        async tryAutoLogin() {
            // Fungsi ini akan ditunggu oleh app.js
            if (this.token) {
                try {
                    const response = await api.get("/juri");
                    this.juri = response.data;
                } catch (error) {
                    this.juri = null;
                    this.token = null;
                    localStorage.removeItem("authToken");
                }
            }
        },
    },
});