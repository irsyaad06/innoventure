import { defineStore } from "pinia";
import api from "../axios";

export const useSeminarStore = defineStore("seminar", {
  state: () => ({
    seminars: [],
    isLoading: false,
    error: null,
  }),

  actions: {
    async fetchSeminars() {
      // Set status loading menjadi true
      this.isLoading = true;
      // Reset error
      this.error = null;

      try {
        // Lakukan panggilan API menggunakan instance axios
        const response = await api.get('/seminar');
        
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
        console.error('Failed to fetch seminars:', err);
        if (err.response) {
          // Kesalahan dari respons server (misal: 404, 500)
          this.error = err.response.data.message || "Terjadi kesalahan pada server.";
        } else {
          // Kesalahan non-server (misal: jaringan mati)
          this.error = "Gagal terhubung ke server. Periksa koneksi internet Anda.";
        }
        this.seminars = [];
      } finally {
        // Selalu set status loading menjadi false, terlepas dari keberhasilan atau kegagalan
        this.isLoading = false;
      }
    },
  },
});