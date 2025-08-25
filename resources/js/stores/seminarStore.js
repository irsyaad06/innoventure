import { defineStore } from "pinia";
import api from "../axios";

export const useSeminarStore = defineStore("seminar", {
    state: () => ({
        seminars: [],
        isLoading: false,
        error: null,
        isSubmitting: false, // Tambahkan state untuk status pengiriman data
        submissionError: null, // Tambahkan state untuk error pengiriman data
        submissionData: null, // Tambahkan state untuk data hasil pengiriman
    }),

    actions: {
        async fetchSeminars() {
            // Set status loading menjadi true
            this.isLoading = true;
            // Reset error
            this.error = null;

            try {
                // Lakukan panggilan API menggunakan instance axios
                const response = await api.get("/seminar");

                // Periksa apakah respons berhasil dan memiliki payload
                if (response.data.code === 200 && response.data.payload) {
                    this.seminars = response.data.payload;
                } else {
                    // Tangani kasus di mana API mengembalikan kode sukses, tetapi tidak ada data
                    this.error = "Data seminar tidak ditemukan.";
                    this.seminars = [];
                }
            } catch (err) {
                // Tangani kesalahan jaringan atau server
                console.error("Failed to fetch seminars:", err);
                if (err.response) {
                    // Kesalahan dari respons server (misal: 404, 500)
                    this.error =
                        err.response.data.message ||
                        "Terjadi kesalahan pada server.";
                } else {
                    // Kesalahan non-server (misal: jaringan mati)
                    this.error =
                        "Gagal terhubung ke server. Periksa koneksi internet Anda.";
                }
                this.seminars = [];
            } finally {
                // Selalu set status loading menjadi false, terlepas dari keberhasilan atau kegagalan
                this.isLoading = false;
            }
        },

        async postSeminar(seminarData) {
            // Set status pengiriman menjadi true
            this.isSubmitting = true;
            // Reset error dan data pengiriman
            this.submissionError = null;
            this.submissionData = null;

            try {
                // Lakukan panggilan API POST
                const response = await api.post("/daftarseminar", seminarData);

                // Periksa respons dari server
                if (response.data.code === 201) {
                    // Jika berhasil, simpan data payload
                    this.submissionData = response.data.payload;
                    return response.data;
                } else {
                    // Tangani jika ada kode respons yang tidak diharapkan
                    this.submissionError =
                        response.data.message || "Pendaftaran gagal.";
                    return null;
                }
            } catch (err) {
                console.error("Failed to submit seminar registration:", err);
                if (err.response && err.response.data) {
                    // Log the specific validation errors from the server
                    console.error(
                        "Validation Errors:",
                        err.response.data.errors
                    );
                    this.submissionError =
                        err.response.data.message || "Pendaftaran gagal.";
                } else {
                    this.submissionError = "Gagal terhubung ke server.";
                }
            } finally {
                // Selalu set status pengiriman menjadi false
                this.isSubmitting = false;
            }
        },
    },
});
