import { defineStore } from "pinia";
import api from "../axios";

export const useMlMatchStore = defineStore("mlMatch", {
    state: () => ({
        matches: [],
        loading: false,
        error: null,
    }),
    actions: {
        async fetchAll() {
            this.loading = true;
            try {
                const res = await api.get("/ml-match");
                this.matches = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message || "Gagal fetch ML Matches";
            } finally {
                this.loading = false;
            }
        },
    },
});
