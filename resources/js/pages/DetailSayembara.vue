<template>
    <div class="relative min-h-screen w-full bg-gray-900 pt-5 md:pt-0">
        <DigitalDataBG class="absolute inset-0 z-0" />

        <div
            class="relative z-10 min-h-screen w-full text-white flex items-center justify-center p-4 sm:p-6"
        >
            <div v-if="isLoading" class="text-center py-20">
                <p class="text-xl text-cyan-400 animate-pulse">
                    Tunggu Sebentar Yaa > . <
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
                    <p v-if="detail.tim" class="text-gray-400 mt-2">
                        Karya oleh:
                        <span class="font-semibold text-gray-300">{{
                            detail.tim.nama
                        }}</span>
                        dari
                        <span class="text-gray-300"
                            >{{ detail.tim.instansi.nama }} - A'{{
                                detail.angkatan
                            }}
                            - {{ detail.kelas }}</span
                        >
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
                                    :href="detail.link_file_logo"
                                    target="_blank"
                                    class="action-button bg-gray-800 hover:bg-gray-700"
                                >
                                    <i class="far fa-image fa-fw text-xl"></i>
                                    <span>Lihat Logo</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <a
                                    :href="detail.link_deskripsi_logo"
                                    target="_blank"
                                    class="action-button bg-blue-600 hover:bg-blue-500"
                                >
                                    <i
                                        class="far fa-file-pdf fa-fw text-xl"
                                    ></i>
                                    <span>Lihat Filosofi Logo</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <a
                                    :href="detail.link_gdrive_logo || '#'"
                                    target="_blank"
                                    :class="[
                                        'action-button',
                                        detail.link_gdrive_logo
                                            ? 'bg-green-600 hover:bg-green-500'
                                            : 'bg-gray-600 opacity-60 cursor-not-allowed',
                                    ]"
                                    :style="
                                        !detail.link_gdrive_logo
                                            ? 'pointer-events: none;'
                                            : ''
                                    "
                                >
                                    <i
                                        :class="[
                                            'fa-fw text-xl',
                                            detail.link_gdrive_logo
                                                ? 'fab fa-google-drive'
                                                : 'fas fa-link-slash',
                                        ]"
                                    ></i>
                                    <span>{{
                                        detail.link_gdrive_logo
                                            ? "Lihat Drive"
                                            : "Tidak Upload"
                                    }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </section>
                    </aside>

                    <div class="animate-fade-in">
                        <h2
                            class="text-2xl font-bold text-cyan-400 border-b-2 border-cyan-400/30 pb-3 mb-6"
                        >
                            Formulir Penilaian
                        </h2>

                        <form
                            v-if="
                                isJuriAuthenticated &&
                                (!hasJuriSubmitted || isEditing)
                            "
                            @submit.prevent="submitAllScores"
                            class="space-y-5"
                        >
                            <div
                                v-for="aspek in assignedAspekPenilaian"
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
                                <input
                                    type="number"
                                    v-model.number="formScores[aspek.id]"
                                    min="0"
                                    max="100"
                                    class="form-input flex-grow"
                                    placeholder="Skor (0-100)"
                                    required
                                />
                            </div>
                            <div
                                class="text-center bg-gray-800/50 border border-white/10 rounded-xl p-6 mt-4"
                            >
                                <label
                                    class="block text-base font-medium text-gray-400 mb-2"
                                >
                                    Total Skor Anda
                                </label>
                                <div
                                    class="text-5xl font-bold text-cyan-400 tracking-tight drop-shadow-[0_0_8px_rgba(6,182,212,0.5)]"
                                >
                                    {{ totalScoreForJuri.toFixed(2) }}
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 mt-6">
                                <button
                                    type="submit"
                                    :disabled="
                                        penilaianSayembaraStore.isSubmitting
                                    "
                                    class="w-full px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    {{
                                        penilaianSayembaraStore.isSubmitting
                                            ? "Menyimpan..."
                                            : "Simpan Perubahan"
                                    }}
                                </button>
                                <button
                                    v-if="isEditing"
                                    @click.prevent="cancelEdit"
                                    type="button"
                                    class="w-full px-6 py-3 bg-gray-600 hover:bg-gray-500 text-white font-semibold rounded-lg shadow-md transition duration-300"
                                >
                                    Batal
                                </button>
                            </div>
                        </form>

                        <div v-else class="space-y-6">
                            <div
                                v-if="isJuriAuthenticated && hasJuriSubmitted"
                                class="text-right mb-2"
                            >
                                <button
                                    @click="enterEditMode"
                                    class="px-4 py-2 bg-yellow-600 hover:bg-yellow-500 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105"
                                >
                                    <i class="fas fa-edit mr-2"></i> Edit Nilai
                                </button>
                            </div>

                            <div
                                v-if="!scoresByJuri.length"
                                class="text-center text-gray-500 italic"
                            >
                                Belum ada penilaian dari juri.
                            </div>
                            <div
                                v-for="(group, index) in scoresByJuri"
                                :key="group.juri.id"
                                class="bg-gray-800/50 border border-white/10 rounded-xl p-4"
                            >
                                <h3
                                    class="text-lg font-semibold text-cyan-400 mb-3"
                                >
                                    Juri {{ index + 1 }}
                                </h3>
                                <ul class="space-y-2 text-sm">
                                    <li
                                        v-for="score in group.scores"
                                        :key="score.nama"
                                        class="flex justify-between items-center"
                                    >
                                        <span class="text-gray-400">{{
                                            score.nama
                                        }}</span>
                                        <span
                                            class="font-mono text-white bg-gray-700/50 px-2 py-1 rounded-md"
                                            >{{ score.skor }}</span
                                        >
                                    </li>
                                </ul>
                                <div
                                    class="border-t border-gray-700 mt-4 pt-3 flex justify-between font-semibold text-base"
                                >
                                    <span>Sub Total</span>
                                    <span>{{ group.subTotal.toFixed(2) }}</span>
                                </div>
                            </div>
                            <div
                                v-if="detail.total_skor > 0"
                                class="text-center bg-gray-800/50 border border-white/10 rounded-xl p-6 mt-4"
                            >
                                <label
                                    class="block text-base font-medium text-gray-400 mb-2"
                                >
                                    Total Skor Akhir (Rata-rata)
                                </label>
                                <div
                                    class="text-5xl font-bold text-cyan-400 tracking-tight drop-shadow-[0_0_8px_rgba(6,182,212,0.5)]"
                                >
                                    {{ detail.total_skor.toFixed(2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <PengesahanJuri class="relative z-10" />
    </div>
</template>
<script>
import { useSayembaraProgressStore } from "../stores/sayembaraProgress.js";
import { useAspekPenilaianStore } from "../stores/aspekPenilaian.js";
import { useJuriStore } from "../stores/juriStore.js";
import { usePenilaianSayembaraStore } from "../stores/penilaianSayembara.js";
import DigitalDataBG from "../components/DigitalDataBG.vue";
import PengesahanJuri from "../components/PengesahanJuri.vue";

export default {
    components: { DigitalDataBG, PengesahanJuri },
    data() {
        return {
            formScores: {},
            hasJuriSubmitted: false,
            isEditing: false, // BARU: State untuk mode edit
        };
    },
    // Bagian computed tidak ada perubahan
    computed: {
        progressStore() {
            return useSayembaraProgressStore();
        },
        aspekStore() {
            return useAspekPenilaianStore();
        },
        juriStore() {
            return useJuriStore();
        },
        penilaianSayembaraStore() {
            return usePenilaianSayembaraStore();
        },
        detail() {
            return this.progressStore.progressDetail;
        },
        aspekPenilaian() {
            return this.aspekStore.aspekPenilaians;
        },
        isJuriAuthenticated() {
            return this.juriStore.isAuthenticated;
        },
        currentJuriId() {
            return this.juriStore.currentJuri?.id || null;
        },
        assignedAspekIds() {
            return this.juriStore.assignedAspekIds;
        },
        isLoading() {
            return (
                this.progressStore.loading ||
                this.aspekStore.loading ||
                this.penilaianSayembaraStore.isLoading
            );
        },
        error() {
            return (
                this.progressStore.error ||
                this.aspekStore.error ||
                this.penilaianSayembaraStore.error
            );
        },
        currentJuriScores() {
            return this.penilaianSayembaraStore.currentJuriScores;
        },
        assignedAspekPenilaian() {
            if (!this.aspekPenilaian || !this.assignedAspekIds) return [];
            return this.aspekPenilaian.filter((aspek) =>
                this.assignedAspekIds.includes(aspek.id)
            );
        },
        totalScoreForJuri() {
            if (!this.assignedAspekPenilaian.length) return 0;
            return this.assignedAspekPenilaian.reduce((total, aspek) => {
                const score = this.formScores[aspek.id] || 0;
                const bobot = aspek.bobot_penilaian / 100;
                return total + score * bobot;
            }, 0);
        },
        scoresByJuri() {
            const allScores = this.penilaianSayembaraStore.allScores;
            if (!allScores || !allScores.length) return [];
            const grouped = allScores.reduce((acc, score) => {
                if (score.aspek_penilaian) {
                    const juriId = score.juri_id;
                    if (!acc[juriId]) {
                        acc[juriId] = {
                            juri: score.juri || {
                                id: juriId,
                                name: `Juri #${juriId}`,
                            },
                            scores: [],
                            subTotal: 0,
                        };
                    }
                    acc[juriId].scores.push({
                        nama: score.aspek_penilaian.nama,
                        skor: score.skor,
                        bobot: score.aspek_penilaian.bobot_penilaian,
                    });
                }
                return acc;
            }, {});
            Object.values(grouped).forEach((group) => {
                group.subTotal = group.scores.reduce(
                    (total, s) => total + s.skor * (s.bobot / 100),
                    0
                );
            });
            return Object.values(grouped);
        },
    },
    // Bagian watch tidak ada perubahan
    watch: {
        currentJuriScores: {
            handler(newScores) {
                this.initializeFormScores(newScores);
                const hasScores =
                    newScores && Object.keys(newScores).length > 0;
                if (hasScores) {
                    this.hasJuriSubmitted = true;
                }
            },
            immediate: true,
            deep: true,
        },
        assignedAspekPenilaian(newAspekList) {
            if (newAspekList && newAspekList.length > 0) {
                this.initializeFormScores(this.currentJuriScores);
            }
        },
    },

    methods: {
        // BARU: Method untuk masuk ke mode edit
        enterEditMode() {
            this.isEditing = true;
        },

        // BARU: Method untuk keluar dari mode edit & membatalkan perubahan
        cancelEdit() {
            this.isEditing = false;
            // Kembalikan nilai form ke skor asli yang tersimpan
            this.initializeFormScores(this.currentJuriScores);
        },

        // Method initializeFormScores tidak ada perubahan
        initializeFormScores(scores) {
            if (
                !this.assignedAspekPenilaian ||
                this.assignedAspekPenilaian.length === 0
            ) {
                return;
            }
            const newFormScores = {};
            const isScoresObject =
                scores && typeof scores === "object" && !Array.isArray(scores);
            this.assignedAspekPenilaian.forEach((aspek) => {
                const aspekIdStr = String(aspek.id);
                if (isScoresObject && scores.hasOwnProperty(aspekIdStr)) {
                    newFormScores[aspek.id] = scores[aspekIdStr];
                } else {
                    newFormScores[aspek.id] = null;
                }
            });
            this.formScores = newFormScores;
        },

        async submitAllScores() {
            const scoresPayload = Object.entries(this.formScores).map(
                ([aspekId, skor]) => ({
                    aspek_id: parseInt(aspekId),
                    skor: skor,
                })
            );

            if (
                scoresPayload.some(
                    (s) => s.skor === null || s.skor < 0 || s.skor > 100
                )
            ) {
                alert(
                    "Harap isi semua skor yang ditugaskan dengan nilai antara 0 dan 100."
                );
                return;
            }

            const payload = {
                sayembara_progress_id: this.detail.id,
                juri_id: this.currentJuriId,
                scores: scoresPayload,
            };

            const success = await this.penilaianSayembaraStore.submitAllScores(
                payload
            );
            if (success) {
                alert(this.penilaianSayembaraStore.successMessage);
                this.hasJuriSubmitted = true;
                this.isEditing = false; // BARU: Keluar dari mode edit setelah berhasil menyimpan
                await this.progressStore.fetchOne(this.$route.params.id);
                await this.penilaianSayembaraStore.fetchAllScoresForProgress(
                    this.$route.params.id
                );
            } else {
                alert(`Gagal menyimpan: ${this.penilaianSayembaraStore.error}`);
            }
        },
    },
    // Bagian created tidak ada perubahan
    async created() {
        const submissionId = this.$route.params.id;
        await Promise.all([
            this.progressStore.fetchOne(submissionId),
            this.penilaianSayembaraStore.fetchAllScoresForProgress(
                submissionId
            ),
        ]);
        if (this.detail && this.detail.tim) {
            const idCabangLomba = this.detail.tim.cabang_lomba_id;
            await this.aspekStore.fetchByCabangLomba(
                idCabangLomba,
                submissionId
            );
        }
        if (this.isJuriAuthenticated) {
            await this.penilaianSayembaraStore.fetchScoresByJuri({
                progressId: submissionId,
                juriId: this.currentJuriId,
            });
        }
    },
};
</script>

<style scoped>
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
</style>
