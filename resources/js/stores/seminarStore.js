import { defineStore } from "pinia";
import api from "../axios";

export const useSeminarStore = defineStore("seminar", {
    state: () => ({
        seminars: [],
        isLoading: false,
        error: null,
        isSubmitting: false,
        submissionError: null,
        submissionData: null,
        // STATE BARU: Untuk menyimpan data pendaftar seminar
        pendaftar: [],
        pendaftarDetail: null,
    }),

    actions: {
        async fetchSeminars() {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await api.get("/seminar");
                if (response.data.code === 200 && response.data.payload) {
                    this.seminars = response.data.payload;
                } else {
                    this.error = "Data seminar tno_undianak ditemukan.";
                    this.seminars = [];
                }
            } catch (err) {
                console.error("Failed to fetch seminars:", err);
                if (err.response) {
                    this.error =
                        err.response.data.message ||
                        "Terjadi kesalahan pada server.";
                } else {
                    this.error =
                        "Gagal terhubung ke server. Periksa koneksi internet Anda.";
                }
                this.seminars = [];
            } finally {
                this.isLoading = false;
            }
        },

        async postSeminar(seminarData) {
            this.isSubmitting = true;
            this.submissionError = null;
            this.submissionData = null;
            try {
                const response = await api.post("/daftarseminar", seminarData);
                if (response.data.code === 201) {
                    this.submissionData = response.data.payload;
                    return response.data;
                } else {
                    this.submissionError =
                        response.data.message || "Pendaftaran gagal.";
                    throw new Error(this.submissionError);
                }
            } catch (err) {
                // console.log(
                //     "ISI LENGKAP ERROR DARI SERVER:",
                //     err.response.data
                // );

                // --- 👇 BAGIAN INI YANG DIPERBARUI ---
                if (err.response && err.response.data) {
                    // Cek apakah ada error validasi spesifik untuk 'email'
                    if (
                        err.response.data.errors &&
                        err.response.data.errors.email
                    ) {
                        // Jika ada, gunakan pesan custom Anda
                        this.submissionError =
                            "Email sudah terdaftar. Silakan gunakan email lain.";
                    } else {
                        // Jika tidak, gunakan pesan error umum dari server
                        this.submissionError =
                            err.response.data.message || "Pendaftaran gagal.";
                    }
                } else {
                    // Untuk error jaringan atau lainnya
                    this.submissionError = "Gagal terhubung ke server.";
                }

                // Tetap lemparkan error agar bisa ditangkap oleh komponen
                throw new Error(this.submissionError);
                // --- 👆 AKHIR BAGIAN YANG DIPERBARUI ---
            } finally {
                this.isSubmitting = false;
            }
        },

        // --- ACTION YANG DIPERBAIKI ---
        async allDaftarSeminar() {
            this.isLoading = true; // Menggunakan isLoading
            this.error = null;
            try {
                const res = await api.get("/daftarseminar");
                // Menyimpan ke state 'pendaftar'
                this.pendaftar = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message ||
                    "Gagal mengambil daftar pendaftar."; // Pesan error diperbaiki
            } finally {
                this.isLoading = false; // Menggunakan isLoading
            }
        },

        async fetchPendaftarByKode(no_undian) {
            this.isLoading = true;
            this.error = null;
            this.pendaftarDetail = null;
            try {
                // Endpoint diasumsikan bisa menerima kode undian
                const res = await api.get(`/daftarseminar/${no_undian}`);
                this.pendaftarDetail = res.data.payload;
            } catch (err) {
                this.error =
                    err.response?.data?.message ||
                    `Gagal mengambil data untuk kode undian ${no_undian}.`;
            } finally {
                this.isLoading = false;
            }
        },
    },
});
