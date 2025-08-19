import { defineStore } from "pinia";
import api from "../axios";

export const useCabangLombaStore = defineStore("cabangLomba", {
    state: () => ({
        cabangLombas: [],
        loading: false,
        error: null,
    }),
    actions: {
        async fetchAll() {
            this.loading = true;
            try {
                const res = await api.get("/cabang-lomba");
                this.cabangLombas = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message || "Gagal fetch Cabang Lomba";
            } finally {
                this.loading = false;
            }
        },
    },
});
