import axios from "axios";

const api = axios.create({
    // Langsung arahkan ke base URL API Anda
    baseURL: "http://127.0.0.1:8000/api",
});

// Interceptor untuk menambahkan Bearer Token secara otomatis ke setiap request
api.interceptors.request.use((config) => {
    // Ambil token dari localStorage
    const token = localStorage.getItem("authToken");

    // Jika token ada, tambahkan ke header Authorization
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
});

export default api;
