<template>
    <div class="relative min-h-screen w-full bg-gray-900">
        <DigitalDataBG class="absolute inset-0 z-0" />

        <div
            class="relative z-10 min-h-screen w-full text-white flex items-center justify-center p-4 sm:p-6"
        >
            <div v-if="isLoading" class="text-center py-20">
                <p class="text-xl text-cyan-400 animate-pulse">
                    Memuat data karya untuk penilaian...
                </p>
            </div>

            <div
                v-else-if="error"
                class="text-center py-20 bg-red-900/20 p-8 rounded-lg"
            >
                <h2 class="text-2xl font-bold text-red-400 mb-2">
                    Gagal Memuat Data
                </h2>
                <p class="text-red-300">{{ error }}</p>
            </div>

            <div
                v-else-if="detail"
                class="w-full max-w-7xl bg-white/5 backdrop-blur-md rounded-2xl shadow-2xl border border-white/10 p-6 mt-10 sm:p-10"
            >
                <div class="text-center mb-10">
                    <h1
                        class="text-3xl md:text-4xl font-extrabold text-white drop-shadow-lg"
                    >
                        {{ detail.judul_proyek }}
                    </h1>
                    <p v-if="detail.tim" class="text-gray-400 mt-2">
                        Karya oleh:
                        <span class="font-semibold text-gray-300">{{
                            detail.tim.nama
                        }}</span>
                        dari
                        <span class="font-semibold text-gray-300">{{
                            detail.tim.instansi.nama
                        }}</span>
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
                    <aside class="space-y-8 animate-fade-in">
                        <section>
                            <h2
                                class="text-2xl font-bold text-cyan-400 border-b-2 border-cyan-400/30 pb-3 mb-6"
                            >
                                Akses Proyek
                            </h2>
                            <div class="space-y-4">
                                <a
                                    :href="detail.link_repository"
                                    target="_blank"
                                    class="action-button bg-gray-800 hover:bg-gray-700"
                                >
                                    <i class="fab fa-github fa-fw text-xl"></i>
                                    <span>Lihat Repository</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <a
                                    :href="detail.link_demo"
                                    target="_blank"
                                    class="action-button bg-blue-600 hover:bg-blue-500"
                                >
                                    <i class="fab fa-youtube fa-fw text-xl"></i>
                                    <span>Tonton Video Demo</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <a
                                    :href="detail.link_hosting || '#'"
                                    target="_blank"
                                    :class="[
                                        'action-button',
                                        detail.link_hosting
                                            ? 'bg-green-600 hover:bg-green-500'
                                            : 'bg-gray-600 opacity-60 cursor-not-allowed',
                                    ]"
                                    :style="
                                        !detail.link_hosting
                                            ? 'pointer-events: none;'
                                            : ''
                                    "
                                >
                                    <i
                                        :class="[
                                            'fa-fw text-xl',
                                            detail.link_hosting
                                                ? 'fas fa-globe'
                                                : 'fas fa-link-slash',
                                        ]"
                                    ></i>
                                    <span>{{
                                        detail.link_hosting
                                            ? "Kunjungi Website"
                                            : "Tidak Upload Website"
                                    }}</span>
                                    <i
                                        v-if="detail.link_hosting"
                                        class="fas fa-arrow-right"
                                    ></i>
                                </a>
                            </div>
                        </section>
                        <section>
                            <div
                                class="flex justify-between items-center border-b-2 border-cyan-400/30 pb-3 mb-6"
                            >
                                <h2 class="text-2xl font-bold text-cyan-400">
                                    Deskripsi Proyek
                                </h2>
                                <a
                                    :href="`/storage/${detail.deskripsi_pdf}`"
                                    target="_blank"
                                    class="text-sm text-cyan-400 hover:text-cyan-700 transition-colors font-semibold"
                                >
                                    Buka PDF
                                    <i
                                        class="fas fa-external-link-alt ml-1"
                                    ></i>
                                </a>
                            </div>
                            <div
                                class="aspect-w-4 aspect-h-5 bg-gray-800 rounded-lg overflow-hidden border border-white/10"
                            >
                                <iframe
                                    :src="`/storage/${detail.deskripsi_pdf}`"
                                    class="w-full h-full"
                                ></iframe>
                            </div>
                        </section>
                        <section>
                            <div
                                class="flex justify-between items-center border-b-2 border-cyan-400/30 pb-3 mb-6"
                            >
                                <h2 class="text-2xl font-bold text-cyan-400">
                                    Power Point
                                </h2>
                                <a
                                    :href="`/storage/${detail.ppt}`"
                                    target="_blank"
                                    class="text-sm text-cyan-400 hover:text-cyan-700 transition-colors font-semibold"
                                >
                                    Buka PPT
                                    <i
                                        class="fas fa-external-link-alt ml-1"
                                    ></i>
                                </a>
                            </div>
                            <div
                                class="aspect-w-16 aspect-h-9 bg-gray-800 rounded-lg overflow-hidden border border-white/10"
                            >
                                <iframe
                                    :src="`/storage/${detail.ppt}`"
                                    class="w-full h-full"
                                ></iframe>
                            </div>
                        </section>
                    </aside>

                    <div class="animate-fade-in" style="animation-delay: 0.2s">
                        <h2
                            class="text-2xl font-bold text-cyan-400 border-b-2 border-cyan-400/30 pb-3 mb-6"
                        >
                            Formulir Penilaian
                        </h2>
                        <form @submit.prevent="submitComment" class="space-y-5">
                            <div
                                v-for="aspek in aspekPenilaian"
                                :key="aspek.id"
                            >
                                <label
                                    class="block text-sm font-medium text-gray-200 mb-1"
                                >
                                    Skor {{ aspek.nama }}
                                    <span class="text-gray-400 font-light"
                                        >(Bobot:
                                        {{ aspek.bobot_penilaian }}%)</span
                                    >
                                </label>
                                <div class="flex items-center gap-3">
                                    <input
                                        type="number"
                                        v-model.number="scores[aspek.id]"
                                        min="0"
                                        max="100"
                                        class="form-input flex-grow"
                                        :class="{
                                            'bg-gray-700 cursor-not-allowed':
                                                !isJuriAuthenticated,
                                        }"
                                        placeholder="Skor (1-100)"
                                        :disabled="!isJuriAuthenticated"
                                        required
                                    />
                                    <button
                                        v-if="isJuriAuthenticated"
                                        @click.prevent="
                                            submitSingleScore(aspek)
                                        "
                                        class="flex-shrink-0 px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105"
                                    >
                                        Nilai
                                    </button>
                                </div>
                            </div>

                            <div
                                class="text-center bg-gray-800/50 border border-white/10 rounded-xl p-6 mt-4"
                            >
                                <label
                                    class="block text-base font-medium text-gray-400 mb-2"
                                >
                                    Total Skor Akhir
                                </label>
                                <div
                                    class="text-5xl font-bold text-cyan-400 tracking-tight drop-shadow-[0_0_8px_rgba(6,182,212,0.5)]"
                                >
                                    {{ totalScore.toFixed(2) }}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useWebdevProgressStore } from "../stores/webDevProgress.js";
import { useAspekPenilaianStore } from "../stores/aspekPenilaian.js";
import { usePenilaianStore } from "../stores/penilaianStore.js";
import { useJuriStore } from "../stores/juriStore.js";
import { mapState } from "pinia";
import DigitalDataBG from "../components/DigitalDataBG.vue";

export default {
    components: { DigitalDataBG },
    data() {
        return {
            scores: {},
            comments: "",
        };
    },
    computed: {
        ...mapState(useWebdevProgressStore, { detail: "progressDetail" }),
        ...mapState(useAspekPenilaianStore, {
            aspekPenilaian: "aspekPenilaians",
        }),
        juriStore() {
            return useJuriStore();
        },
        isJuriAuthenticated() {
            return this.juriStore.isAuthenticated;
        },
        currentJuriId() {
            return this.juriStore.isAuthenticated
                ? this.juriStore.juri.id
                : null;
        },
        isLoading() {
            return (
                useWebdevProgressStore().loading ||
                useAspekPenilaianStore().loading ||
                usePenilaianStore().isSubmitting
            );
        },
        error() {
            return (
                useWebdevProgressStore().error ||
                useAspekPenilaianStore().error ||
                usePenilaianStore().error
            );
        },
        totalScore() {
            if (!this.aspekPenilaian || !this.aspekPenilaian.length) return 0;
            return this.aspekPenilaian.reduce((total, aspek) => {
                const score = this.scores[aspek.id] || 0;
                const bobot = aspek.bobot_penilaian / 100;
                return total + score * bobot;
            }, 0);
        },
        isDataReadyForScores() {
            return this.detail && this.aspekPenilaian.length > 0 && this.juriStore.isReady;
        },
    },
    watch: {
        isDataReadyForScores(isReady) {
            if (isReady) {
                this.fetchExistingScores();
            }
        },
    },
    methods: {
        // Menggunakan fetchAllScores untuk mengambil semua data skor
        async fetchExistingScores() {
            const submissionId = this.$route.params.id;
            const penilaianStore = usePenilaianStore();

            // Panggil aksi fetchAllScores tanpa juriId
            await penilaianStore.fetchAllScores({
                progressId: submissionId
            });

            // Inisialisasi properti 'scores' dengan data yang sudah diambil
            const existingScores = penilaianStore.currentScores;
            const initialScores = {};
            this.aspekPenilaian.forEach(aspek => {
                initialScores[aspek.id] = existingScores[aspek.id] || 0;
            });
            
            this.scores = initialScores;
        },
        async submitSingleScore(aspek) {
            const score = this.scores[aspek.id] || 0;
            if (score < 0 || score > 100) {
                alert("Skor harus di antara 0 dan 100.");
                return;
            }
            const penilaianStore = usePenilaianStore();
            const payload = {
                webdev_progress_id: this.detail.id,
                aspek_penilaian_id: aspek.id,
                skor: score,
                juri_id: this.currentJuriId,
            };
            const result = await penilaianStore.submitScore(payload);
            if (result) {
                alert(
                    penilaianStore.successMessage || `Skor berhasil disimpan.`
                );
            } else {
                alert(`Gagal menyimpan skor: ${penilaianStore.error}`);
            }
        },
    },
    async created() {
        const submissionId = this.$route.params.id;
        const progressStore = useWebdevProgressStore();
        const aspekStore = useAspekPenilaianStore();

        await progressStore.fetchOne(submissionId);
        if (progressStore.progressDetail && progressStore.progressDetail.tim) {
            const idCabangLomba =
                progressStore.progressDetail.tim.cabang_lomba_id;
            await aspekStore.fetchByCabangLomba(idCabangLomba);
        }
    },
};
</script>

<style scoped>
/* ... (style tidak ada perubahan) ... */
.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
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

.action-button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    transition: all 0.2s ease-in-out;
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
.action-button i:last-child {
    transition: transform 0.2s ease-in-out;
}
.action-button:hover i:last-child {
    transform: translateX(4px);
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-in-out forwards;
}
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

iframe {
    -webkit-overflow-scrolling: touch;
}
</style>
