<template>
    <div
        class="h-screen w-full flex flex-col items-center justify-center text-white overflow-hidden bg-gray-900 relative"
    >
        <!-- Background animasi -->
        <DigitalDataBG class="absolute inset-0 z-0" />

        <!-- Loading -->
        <div
            v-if="seminarStore.isLoading"
            class="text-xl md:text-2xl text-white/80 z-10 animate-pulse"
        >
            Memuat data seminar...
        </div>

        <!-- Error -->
        <div
            v-else-if="seminarStore.error"
            class="text-xl md:text-2xl text-red-400 z-10 text-center animate-shake"
        >
            Gagal memuat seminar: {{ seminarStore.error }}
        </div>

        <transition name="fade-scale" mode="out-in">
            <!-- Countdown -->
            <div v-if="showCountdown" key="countdown" class="z-10 w-full px-6">
                <!-- Judul -->
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

                <!-- Timer -->
                <div
                    class="flex justify-center items-center gap-4 mb-8 animate-fade-in-up flex-wrap"
                >
                    <!-- Hari -->
                    <div class="countdown-card">
                        <div class="countdown-number">{{ days }}</div>
                        <div class="countdown-label">Hari</div>
                    </div>

                    <div class="countdown-separator">:</div>

                    <!-- Jam -->
                    <div class="countdown-card">
                        <div class="countdown-number">{{ hours }}</div>
                        <div class="countdown-label">Jam</div>
                    </div>

                    <div class="countdown-separator">:</div>

                    <!-- Menit -->
                    <div class="countdown-card">
                        <div class="countdown-number">{{ minutes }}</div>
                        <div class="countdown-label">Menit</div>
                    </div>

                    <div class="countdown-separator">:</div>

                    <!-- Detik -->
                    <div class="countdown-card">
                        <div class="countdown-number">{{ seconds }}</div>
                        <div class="countdown-label">Detik</div>
                    </div>
                </div>

                <!-- Motivasi -->
                <div
                    class="mt-6 text-center text-gray-400 text-lg italic animate-fade-in-up"
                >
                    "Bersiaplah untuk menambah wawasan dan inspirasi baru
                    bersama pembicara hebat 🎤"
                </div>

                <!-- Tombol daftar -->
                <div class="z-10 text-center mt-8">
                    <a
                        href="/seminar/daftar"
                        class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-cyan-500/50"
                    >
                        <span
                            class="relative px-8 py-4 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent text-lg font-semibold"
                        >
                            Daftar Seminar
                        </span>
                    </a>
                </div>
            </div>

            <!-- Done -->
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
    </div>
</template>

<script>
import { useSeminarStore } from "@/stores/seminarStore";
import DigitalDataBG from "../components/DigitalDataBG.vue";

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
/* Card countdown */
.countdown-card {
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.05),
        rgba(0, 188, 212, 0.1)
    );
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 1.5rem;
    min-width: 100px;
    text-align: center;
    transition: all 0.3s ease-in-out;
}
.countdown-card:hover {
    transform: scale(1.08) rotate(3deg);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.5), 0 0 40px rgba(0, 255, 255, 0.3);
    cursor: default;
}

/* Angka countdown */
.countdown-number {
    font-size: 2.5rem;
    font-weight: bold;
    font-family: monospace;
    color: #fff;
    text-shadow: 0 0 8px rgba(0, 255, 255, 0.8), 0 0 20px rgba(0, 255, 255, 0.6),
        0 0 40px rgba(0, 255, 255, 0.4);
    animation: glow-pulse 2s infinite alternate;
}

/* Label countdown */
.countdown-label {
    margin-top: 0.5rem;
    font-size: 0.9rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #d1d5db;
}

/* Separator */
.countdown-separator {
    font-size: 2.5rem;
    font-weight: bold;
    color: rgba(255, 255, 255, 0.5);
    text-shadow: 0 0 10px rgba(0, 255, 255, 0.4);
}

/* Animasi glow */
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

/* Transition */
.fade-scale-enter-active,
.fade-scale-leave-active {
    transition: opacity 0.5s, transform 0.5s;
}
.fade-scale-enter,
.fade-scale-leave-to {
    opacity: 0;
    transform: scale(0.9);
}

/* Shake error */
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

/* Fade-in animations */
.animate-fade-in {
    animation: fadeIn 1s ease-in-out forwards;
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
.animate-fade-in-up {
    animation: fadeInUp 1s ease-in-out forwards;
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
