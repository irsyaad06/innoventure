import { defineStore } from "pinia";
import api from "../axios";

export const useAspekPenilaianStore = defineStore("aspekPenilaian", {
    state: () => ({
        aspekPenilaians: [],
        loading: false,
        error: null,
    }),
    actions: {
        // PERUBAHAN: Sekarang menerima dua parameter
        async fetchByCabangLomba(id_cabang_lomba, progressId) {
            this.loading = true;
            this.error = null;
            try {
                // PERUBAHAN: Memanggil API baru yang sudah digabungkan
                const res = await api.get(`/aspek-penilaian/cabang/${id_cabang_lomba}/progress/${progressId}`);
                this.aspekPenilaians = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message ||
                    "Gagal mengambil data Aspek Penilaian";
            } finally {
                this.loading = false;
            }
        },
    },
});