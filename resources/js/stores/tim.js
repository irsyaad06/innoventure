import { defineStore } from "pinia";
import api from "../axios";

export const useTimStore = defineStore("tim", {
    state: () => ({
        tims: [],
        loading: false,
        error: null,
    }),
    actions: {
        async fetchAll() {
            this.loading = true;
            try {
                const res = await api.get("/tim");
                this.tims = res.data.payload;
            } catch (err) {
                this.error = err.response?.data?.message || "Gagal fetch Tim";
            } finally {
                this.loading = false;
            }
        },

        async fetchOne(id) {
            this.loading = true;
            this.error = null;
            this.progressDetail = null;
            try {
                const res = await api.get(`/tim/${id}`);
                this.progressDetail = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message ||
                    "Gagal mengambil detail tim.";
            } finally {
                this.loading = false;
            }
        },
    },
});
