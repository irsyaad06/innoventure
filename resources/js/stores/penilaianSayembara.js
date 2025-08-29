import { defineStore } from "pinia";
import api from "../axios";

export const usePenilaianSayembaraStore = defineStore("penilaianSayembara", {
    state: () => ({
        isLoading: false, // 1. Tambahkan state isLoading untuk proses fetching data
        isSubmitting: false,
        error: null,
        successMessage: null,
        allScores: [],
        currentJuriScores: [],
    }),

    actions: {
        async fetchScoresByJuri({ progressId, juriId }) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await api.get(
                    `/penilaian-sayembara/${progressId}/juri/${juriId}`
                );
                // 2. Pastikan payload selalu array untuk menghindari error .map()
                this.currentJuriScores = response.data.payload || [];
            } catch (err) {
                this.currentJuriScores = [];
                this.error = "Gagal mengambil skor spesifik juri.";
                console.error("Gagal mengambil skor juri:", err);
            } finally {
                this.isLoading = false;
            }
        },

        async fetchAllScoresForProgress(progressId) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await api.get(
                    `/penilaian-sayembara/${progressId}`
                );
                this.allScores = response.data.payload || [];
            } catch (err) {
                this.allScores = [];
                this.error = "Gagal mengambil data penilaian.";
            } finally {
                this.isLoading = false;
            }
        },

        /**
         * 3. Uncomment dan aktifkan action ini. Inilah yang dipanggil oleh komponen Anda.
         */
        async submitAllScores(payload) {
            this.isSubmitting = true;
            this.error = null;
            this.successMessage = null;
            try {
                const response = await api.post("/penilaian-sayembara", payload);
                
                if (response.data.code === 200 || response.data.code === 201) {
                    this.successMessage = response.data.message;
                    return true; // Berhasil
                } else {
                    throw new Error(response.data.message || "Gagal menyimpan skor.");
                }
            } catch (err) {
                this.error = err.response?.data?.message || err.message || "Gagal terhubung ke server.";
                return false; // Gagal
            } finally {
                this.isSubmitting = false;
            }
        },

        /**
         * 4. Action ini bisa dihapus atau disimpan jika masih ada bagian lain yang menggunakannya.
         * Untuk form yang sekarang, action ini tidak lagi dipakai.
         */
        // async submitScore(payload) { ... }
    },
});