import { defineStore } from "pinia";
import api from "../axios";

export const useJuriStore = defineStore("juriAuth", {
    state: () => ({
        juri: null,
        // Ambil token dari localStorage saat store pertama kali dibuat
        token: localStorage.getItem("authToken") || null,
        isLoading: false,
        error: null,
        juris: [],
    }),

    getters: {
        // Logika otentikasi sekarang bergantung pada keberadaan juri DAN token
        isAuthenticated: (state) => !!state.juri && !!state.token,
        currentJuri: (state) => state.juri,
    },

    actions: {
        async fetchJuri() {
            this.isLoading = true;
            try {
                const res = await api.get("/list-juri");
                this.juris = res.data.payload; // simpan hasil
            } catch (err) {
                this.error =
                    err.response?.data?.message || "Gagal fetch list juri";
            } finally {
                this.isLoading = false;
            }
        },

        async login(credentials) {
            this.isLoading = true;
            this.error = null;
            try {
                // Panggil endpoint login yang mengembalikan token
                const response = await api.post("/login", credentials);

                const { user, token } = response.data;

                // Simpan data ke state
                this.juri = user;
                this.token = token;

                // Simpan token ke localStorage agar tidak hilang saat refresh
                localStorage.setItem("authToken", token);
            } catch (err) {
                this.juri = null;
                this.token = null;
                localStorage.removeItem("authToken");
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
            try {
                // Panggil endpoint logout (opsional, tapi praktik yang baik)
                await api.post("/logout");
            } catch (error) {
                console.error("Logout error:", error);
            } finally {
                // Hapus semua data otentikasi dari frontend
                this.juri = null;
                this.token = null;
                localStorage.removeItem("authToken");
                this.isLoading = false;
            }
        },

        /**
         * Action ini untuk memeriksa apakah token di localStorage masih valid.
         * Panggil ini saat aplikasi pertama kali dimuat (di app.js).
         */
        async tryAutoLogin() {
            if (this.token) {
                try {
                    // Coba ambil data juri menggunakan token yang ada
                    const response = await api.get("/juri");
                    this.juri = response.data;
                } catch (error) {
                    // Jika token tidak valid (misal: expired), hapus semuanya
                    this.juri = null;
                    this.token = null;
                    localStorage.removeItem("authToken");
                }
            }
        },
    },
});
