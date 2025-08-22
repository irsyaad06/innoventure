import { defineStore } from "pinia";
import api from "../axios";

export const useInstansiStore = defineStore("instansi", {
    state: () => ({
        instansis: [],
        loading: false,
        error: null,
    }),
    actions: {
        async fetchAll() {
            this.loading = true;
            try {
                const res = await api.get("/instansi");
                this.instansis = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message || "Gagal fetch Instansi";
            } finally {
                this.loading = false;
            }
        },
    },
});
