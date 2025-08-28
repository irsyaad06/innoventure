<template>
    <div
        class="min-h-screen w-full flex flex-col items-center justify-center text-white overflow-hidden bg-gray-900 relative pt-30 pb-10"
    >
        <DigitalDataBG class="absolute inset-0 z-0" />

        <div
            v-if="seminarStore.isLoading"
            class="text-xl md:text-2xl text-cyan-400 animate-pulse z-10"
        >
            Tunggu Sebentar Yaa > . <
        </div>

        <div
            v-else-if="seminarStore.error"
            class="text-xl md:text-2xl text-red-400 z-10 text-center animate-shake"
        >
            Gagal memuat seminar: {{ seminarStore.error }}
        </div>

        <transition v-else name="fade-scale" mode="out-in">
            <div
                v-if="showCountdown"
                key="countdown"
                class="z-10 w-full px-4 sm:px-6"
            >
                <div class="text-center mb-12 animate-fade-in">
                    <h1
                        class="text-3xl md:text-5xl font-extrabold text-white drop-shadow-lg tracking-wide"
                    >
                        Seminar & Awarding Innoventure 🚀
                    </h1>
                    <p class="mt-4 text-lg md:text-xl text-gray-300">
                        Hitung mundur menuju acara besar kita! Jangan lewatkan
                        momen inspiratif ini ✨
                    </p>
                </div>

                <div
                    class="flex justify-center items-center gap-2 sm:gap-4 mb-8 animate-fade-in-up flex-wrap"
                >
                    <div class="countdown-card highlighted-card">
                        <div class="countdown-number">{{ days }}</div>
                        <div class="countdown-label">Hari</div>
                    </div>

                    <div class="countdown-separator">:</div>

                    <div class="countdown-card">
                        <div class="countdown-number">{{ hours }}</div>
                        <div class="countdown-label">Jam</div>
                    </div>

                    <div class="countdown-separator">:</div>

                    <div class="countdown-card">
                        <div class="countdown-number">{{ minutes }}</div>
                        <div class="countdown-label">Menit</div>
                    </div>

                    <div class="seconds-wrapper items-center gap-2 sm:gap-4">
                        <div class="countdown-separator">:</div>
                        <div class="countdown-card">
                            <div class="countdown-number">{{ seconds }}</div>
                            <div class="countdown-label">Detik</div>
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 text-center text-gray-400 text-lg italic animate-fade-in-up"
                >
                    "Bersiaplah untuk menambah wawasan dan inspirasi baru
                    bersama pembicara hebat 🎤"
                </div>

                <div class="z-10 text-center mt-8">
                    <a
                        href="/seminar/daftar"
                        class="relative inline-flex items-center justify-center overflow-hidden text-lg font-semibold rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-600 transition-all duration-300 transform hover:scale-105"
                    >
                        <span class="px-8 py-4 text-white">
                            Daftar Seminar
                        </span>
                    </a>
                </div>
            </div>

            <div
                v-else
                key="done"
                class="z-10 text-center animate-fade-in-up px-6"
            >
                <h2
                    class="text-4xl md:text-6xl font-extrabold mb-6 bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent drop-shadow-lg"
                >
                    🎉 Terima kasih sudah mengikuti seminar!
                </h2>
                <p class="text-gray-300 text-lg md:text-xl">
                    Sampai jumpa di event berikutnya dengan pengalaman yang
                    lebih seru 🚀
                </p>
            </div>
        </transition>
        <div class="w-full max-w-6xl mx-auto mt-30">
            <h2
                class="text-3xl font-bold text-center text-white mb-10 animate-fade-in-up"
            >
                Apa yang Akan Anda Dapatkan?
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="(feature, index) in features"
                    :key="feature.title"
                    class="feature-card animate-fade-in-up"
                    :style="{ 'animation-delay': `${index * 100}ms` }"
                >
                    <div class="text-4xl mb-4">{{ feature.icon }}</div>

                    <h3 class="text-xl font-bold text-cyan-400 mb-2">
                        {{ feature.title }}
                    </h3>

                    <p class="text-gray-400 text-sm">
                        {{ feature.description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Bagian script tidak perlu diubah
import { useSeminarStore } from "../stores/seminarStore";
import DigitalDataBG from "../components/DigitalDataBG.vue";
// Di dalam <script setup> atau bagian data() Anda

export default {
    components: { DigitalDataBG },
    data() {
        return {
            days: "00",
            hours: "00",
            minutes: "00",
            seconds: "00",
            interval: null,
            seminarStore: useSeminarStore(),
            features: [
                {
                    icon: "🎤",
                    title: "Inspiring Guest Star",
                    description:
                        "Pembicara tamu inspiratif langsung dari DISDIK JABAR.",
                },
                {
                    icon: "🏅",
                    title: "Sertifikat Eksklusif",
                    description:
                        "Dapatkan E-Sertifikat resmi sebagai bukti partisipasi Anda.",
                },
                {
                    icon: "🤝",
                    title: "Networking Session",
                    description:
                        "Perluas koneksi Anda dengan para profesional dan peserta lain.",
                },
                {
                    icon: "🍔",
                    title: "Makan Siang Gratis",
                    description:
                        "Tersedia untuk 100 pendaftar pertama yang hadir di lokasi.",
                },
                {
                    icon: "🎁",
                    title: "Puluhan Doorprize",
                    description:
                        "Menangkan berbagai hadiah menarik yang sudah kami siapkan.",
                },
                {
                    icon: "🏆",
                    title: "Awarding Session",
                    description:
                        "Saksikan pengumuman dan penganugerahan para pemenang lomba.",
                },
            ],
        };
    },

    computed: {
        targetDate() {
            if (
                this.seminarStore.seminars &&
                this.seminarStore.seminars.length > 0
            ) {
                return new Date(this.seminarStore.seminars[0].waktu);
            }
            return null;
        },
        showCountdown() {
            return (
                this.targetDate &&
                this.targetDate.getTime() > new Date().getTime()
            );
        },
    },
    mounted() {
        this.seminarStore.fetchSeminars();
        this.$watch(
            "targetDate",
            (newDate) => {
                if (newDate) this.startCountdown();
                else this.stopCountdown();
            },
            { immediate: true }
        );
    },
    beforeUnmount() {
        this.stopCountdown();
    },
    methods: {
        startCountdown() {
            this.stopCountdown();
            this.updateCountdown();
            this.interval = setInterval(this.updateCountdown, 1000);
        },
        stopCountdown() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },
        updateCountdown() {
            if (!this.targetDate) {
                this.stopCountdown();
                return;
            }

            const now = new Date().getTime();
            const distance = this.targetDate.getTime() - now;

            if (distance <= 0) {
                this.stopCountdown();
                return;
            }

            this.days = String(
                Math.floor(distance / (1000 * 60 * 60 * 24))
            ).padStart(2, "0");
            this.hours = String(
                Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                )
            ).padStart(2, "0");
            this.minutes = String(
                Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
            ).padStart(2, "0");
            this.seconds = String(
                Math.floor((distance % (1000 * 60)) / 1000)
            ).padStart(2, "0");
        },
    },
};
</script>

<style scoped>
.feature-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    transform: translateY(0);
}

.feature-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(6, 182, 212, 0.5); /* Warna cyan */
    box-shadow: 0 10px 30px rgba(6, 182, 212, 0.1);
}

/* Animasi yang sudah ada di komponen Anda */
@keyframes fadeIn-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeIn-up 0.5s ease-out forwards;
    opacity: 0; /* Mulai dari tidak terlihat */
}

/* Ukuran default untuk mobile */
.countdown-card {
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.05),
        rgba(0, 188, 212, 0.1)
    );
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.75rem;
    padding: 0.75rem;
    min-width: 70px;
    text-align: center;
    transition: all 0.3s ease-in-out;
}
.countdown-number {
    font-size: 1.875rem;
    font-weight: bold;
    font-family: monospace;
    color: #fff;
    text-shadow: 0 0 8px rgba(0, 255, 255, 0.8), 0 0 20px rgba(0, 255, 255, 0.6),
        0 0 40px rgba(0, 255, 255, 0.4);
    animation: glow-pulse 2s infinite alternate;
}
.countdown-label {
    margin-top: 0.25rem;
    font-size: 0.7rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #d1d5db;
}
.countdown-separator {
    font-size: 1.875rem;
    font-weight: bold;
    color: rgba(255, 255, 255, 0.5);
    text-shadow: 0 0 10px rgba(0, 255, 255, 0.4);
}
/* Sembunyikan detik di mobile */
.seconds-wrapper {
    display: none;
}

/* Ukuran lebih besar untuk desktop (lebar layar 768px ke atas) */
@media (min-width: 768px) {
    .countdown-card {
        border-radius: 1rem;
        padding: 1.5rem;
        min-width: 100px;
    }
    .countdown-number {
        font-size: 2.5rem;
    }
    .countdown-label {
        margin-top: 0.5rem;
        font-size: 0.9rem;
        letter-spacing: 2px;
    }
    .countdown-separator {
        font-size: 2.5rem;
    }
    /* Tampilkan kembali detik di desktop */
    .seconds-wrapper {
        display: flex;
    }
}

.countdown-card:hover {
    transform: scale(1.08) rotate(3deg);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.5), 0 0 40px rgba(0, 255, 255, 0.3);
    cursor: default;
}

.highlighted-card {
    transform: scale(1.08) rotate(3deg);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.5), 0 0 40px rgba(0, 255, 255, 0.3);
}

/* ... sisa style tidak perlu diubah ... */
@keyframes glow-pulse {
    from {
        text-shadow: 0 0 8px rgba(0, 255, 255, 0.5),
            0 0 20px rgba(0, 255, 255, 0.3);
    }
    to {
        text-shadow: 0 0 16px rgba(0, 255, 255, 1),
            0 0 32px rgba(0, 255, 255, 0.8);
    }
}
.fade-scale-enter-active,
.fade-scale-leave-active {
    transition: opacity 0.5s, transform 0.5s;
}
.fade-scale-enter-from,
.fade-scale-leave-to {
    opacity: 0;
    transform: scale(0.9);
}
@keyframes shake {
    0%,
    100% {
        transform: translateX(0);
    }
    10%,
    30%,
    50%,
    70%,
    90% {
        transform: translateX(-5px);
    }
    20%,
    40%,
    60%,
    80% {
        transform: translateX(5px);
    }
}
.animate-shake {
    animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
}
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
