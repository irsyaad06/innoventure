<template>
    <div class="relative min-h-screen w-full bg-gray-900">
        <DigitalDataBG class="absolute inset-0 z-0 opacity-50" />
        <div
            class="relative z-10 flex items-center justify-center min-h-screen p-4"
        >
            <div
                class="w-full max-w-md bg-gray-800/50 backdrop-blur-lg border border-white/10 rounded-2xl shadow-2xl p-8"
            >
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-white">
                        Portal Juri
                    </h1>
                    <p class="text-gray-400 mt-2">
                        Silakan login untuk melanjutkan
                    </p>
                </div>

                <form @submit.prevent="handleLogin" class="space-y-6">
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-300"
                            >Email</label
                        >
                        <div class="relative mt-1">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                            >
                                <i class="fas fa-envelope text-gray-500"></i>
                            </span>
                            <input
                                v-model="email"
                                type="email"
                                id="email"
                                class="form-input pl-10"
                                required
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-300"
                            >Password</label
                        >
                        <div class="relative mt-1">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                            >
                                <i class="fas fa-lock text-gray-500"></i>
                            </span>
                            <input
                                v-model="password"
                                type="password"
                                id="password"
                                class="form-input pl-10"
                                required
                            />
                        </div>
                    </div>

                    <div
                        v-if="errorMsg"
                        class="text-center bg-red-500/20 text-red-300 text-sm p-3 rounded-lg"
                    >
                        {{ errorMsg }}
                    </div>

                    <div>
                        <button
                            type="submit"
                            :disabled="juriStore.isLoading"
                            class="w-full flex justify-center items-center px-4 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-wait"
                        >
                            <span v-if="!juriStore.isLoading">Login</span>
                            <span v-else>Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useJuriStore } from "../stores/juriStore"; // Sesuaikan path
import DigitalDataBG from "../components/DigitalDataBG.vue"; // Sesuaikan path

// Inisialisasi
const router = useRouter();
const juriStore = useJuriStore();

// State untuk form
const email = ref("juri@gmail.com");
const password = ref("12345678");
const errorMsg = ref("");

// Method untuk handle login yang sudah disederhanakan
const handleLogin = async () => {
    errorMsg.value = ""; // Reset pesan error
    try {
        // Panggil action login dari store
        await juriStore.login({
            email: email.value,
            password: password.value,
        });

        // Jika berhasil, langsung arahkan ke halaman info juri
        router.push("/info-juri");
    } catch (error) {
        // Jika gagal, tampilkan pesan error dari store
        errorMsg.value = juriStore.error || "Terjadi kesalahan saat login.";
    }
};
</script>
<style scoped>
.form-input {
    width: 100%;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    border-radius: 0.5rem;
    background-color: rgb(31 41 55);
    color: white;
    border: 1px solid rgb(75 85 99);
    transition: all 0.2s ease-in-out;
}
.form-input:focus {
    outline: none;
    border-color: rgb(59 130 246);
    box-shadow: 0 0 0 2px rgb(59 130 246 / 0.5);
}
</style>
