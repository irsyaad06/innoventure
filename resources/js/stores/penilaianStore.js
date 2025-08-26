import { defineStore } from "pinia";
import api from "../axios";

export const usePenilaianStore = defineStore("penilaian", {
    // STATE: Menyimpan status saat proses pengiriman data
    state: () => ({
        isSubmitting: false,
        error: null,
        successMessage: null,
        currentScores: {},
    }),

    // ACTIONS: Logika untuk berinteraksi dengan API
    actions: {
        async submitScore(payload) {
            this.isSubmitting = true;
            this.error = null;
            this.successMessage = null;

            try {
                // Panggil endpoint POST /penilaian yang sudah Anda buat
                const response = await api.post("/penilaian", payload);

                if (response.data.code === 200) {
                    this.successMessage = response.data.message;
                    return response.data; // Kembalikan data jika sukses
                } else {
                    // Tangani jika ada respons sukses tapi dengan kode yang tidak diharapkan
                    throw new Error(
                        response.data.message || "Gagal menyimpan skor."
                    );
                }
            } catch (err) {
                // Tangani error dari server (termasuk validasi) atau jaringan
                if (err.response && err.response.data) {
                    this.error =
                        err.response.data.message ||
                        "Terjadi kesalahan validasi.";
                } else {
                    this.error =
                        "Gagal terhubung ke server. Periksa koneksi Anda.";
                }
                console.error("Error submitting score:", this.error);
                return null; // Kembalikan null jika gagal
            } finally {
                this.isSubmitting = false;
            }
        },

        async fetchScores({ progressId, juriId }) {
            this.isSubmitting = true; // Bisa gunakan state loading yang sama
            this.error = null;
            try {
                const response = await api.get(
                    `/penilaian/karya/${progressId}/juri/${juriId}`
                );
                if (response.data.code === 200) {
                    this.currentScores = response.data.payload;
                    return true;
                }
            } catch (err) {
                if (err.response && err.response.status === 404) {
                    // Jika belum ada skor, itu bukan error. Reset saja.
                    this.currentScores = {};
                } else {
                    this.error = "Gagal mengambil skor yang sudah ada.";
                }
                console.error("Gagal fetch skor:", err);
                return false;
            } finally {
                this.isSubmitting = false;
            }
        },
    },
});
