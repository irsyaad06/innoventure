import { defineStore } from "pinia";
import api from "../axios"; // Pastikan path ini benar sesuai dengan lokasi Anda

export const useWebdevProgressStore = defineStore("webdevProgress", {
    state: () => ({
        progresses: [],
        progressDetail: null,
        loading: false,
        error: null,
    }),
    actions: {
        async fetchAll() {
            this.loading = true;
            this.error = null;
            try {
                const res = await api.get("/webdev-progress");
                this.progresses = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message ||
                    "Gagal mengambil data progress.";
            } finally {
                this.loading = false;
            }
        },

        async fetchOne(id) {
            this.loading = true;
            this.error = null;
            this.progressDetail = null;
            try {
                const res = await api.get(`/webdev-progress/${id}`);
                this.progressDetail = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message ||
                    "Gagal mengambil detail progress.";
            } finally {
                this.loading = false;
            }
        },
    },
});
