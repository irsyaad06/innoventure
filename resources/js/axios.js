import axios from "axios";

const api = axios.create({
    baseURL: "/api",
});

export default api;

// import axios from 'axios'

// const api = axios.create({
//   baseURL: '/api',       // semua request otomatis ke /api
//   timeout: 10000,
//   headers: {
//     'Accept': 'application/json',
//   },
// })

// // Optional: Interceptor untuk handle error global
// api.interceptors.response.use(
//   response => response,
//   error => {
//     console.error('API Error:', error.response?.data || error)
//     return Promise.reject(error)
//   }
// )

// export default api
