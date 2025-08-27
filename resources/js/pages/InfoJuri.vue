<template>
    <div class="relative min-h-screen w-full bg-gray-900">
        <DigitalDataBG class="absolute inset-0 z-0 opacity-50" />
        <div
            class="relative z-10 flex items-center justify-center min-h-screen p-4"
        >
            <div
                v-if="juriStore.isAuthenticated && juri"
                class="w-full max-w-2xl bg-gray-800/50 backdrop-blur-lg border border-white/10 rounded-2xl shadow-2xl p-8 text-white"
            >
                <h1 class="text-3xl font-extrabold text-center mb-8">
                    Profil Juri
                </h1>

                <div class="space-y-4">
                    <div class="info-row">
                        <span class="info-label">Nama</span>
                        <span class="info-value">{{ juri.nama }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ juri.email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Role</span>
                        <span class="info-value capitalize">{{
                            juri.role
                        }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Instansi</span>
                        <span class="info-value">{{ juri.instansi }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">No. HP</span>
                        <span class="info-value">{{ juri.no_hp }}</span>
                    </div>
                </div>

                <div
                    class="mt-10 flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4"
                >
                    <router-link
                        to="/game-on"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition-colors text-center w-full sm:w-auto"
                    >
                        Nilai Web Dev
                    </router-link>

                    <button
                        @click="handleLogout"
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition-colors text-center w-full sm:w-auto"
                    >
                        Logout
                    </button>
                </div>
            </div>

            <div v-else class="text-center">
                <p>Silakan login terlebih dahulu.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { useRouter } from "vue-router";
import { useJuriStore } from "../stores/juriStore"; // Sesuaikan path
import DigitalDataBG from "../components/DigitalDataBG.vue"; // Sesuaikan path

const router = useRouter();
const juriStore = useJuriStore();

// Ambil data juri dari getter di store
const juri = computed(() => juriStore.currentJuri);

const handleLogout = async () => {
    await juriStore.logout();
    router.push("/login"); // Arahkan kembali ke halaman login
};
</script>

<style scoped>
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 1rem;
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 0.5rem;
    border-left: 4px solid #06b6d4; /* cyan-500 */
}
.info-label {
    font-weight: 600;
    color: #9ca3af; /* gray-400 */
}
.info-value {
    font-weight: 500;
}
</style>
