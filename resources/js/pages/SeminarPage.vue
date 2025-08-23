<template>
    <div
        class="h-screen w-full flex flex-col items-center justify-center text-white overflow-hidden"
    >
    <DigitalDataBG class="z-0"/>
        <div
            v-if="showCountdown"
            class="flex justify-center items-center gap-4 mb-8"
        >
            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl"
            >
                <div class="text-4xl md:text-6xl font-bold text-white font-mono">
                    {{ days }}
                </div>
                <div
                    class="text-sm text-gray-300 uppercase tracking-wider mt-2"
                >
                    Hari
                </div>
            </div>

            <div class="text-4xl md:text-6xl font-bold text-white/60">:</div>

            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl"
            >
                <div class="text-4xl md:text-6xl font-bold text-white font-mono">
                    {{ hours }}
                </div>
                <div
                    class="text-sm text-gray-300 uppercase tracking-wider mt-2"
                >
                    Jam
                </div>
            </div>

            <div class="text-4xl md:text-6xl font-bold text-white/60">:</div>

            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl"
            >
                <div class="text-4xl md:text-6xl font-bold text-white font-mono">
                    {{ minutes }}
                </div>
                <div
                    class="text-sm text-gray-300 uppercase tracking-wider mt-2"
                >
                    Menit
                </div>
            </div>

            <div class="text-4xl md:text-6xl font-bold text-white/60">:</div>

            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl"
            >
                <div class="text-4xl md:text-6xl font-bold text-white font-mono">
                    {{ seconds }}
                </div>
                <div
                    class="text-sm text-gray-300 uppercase tracking-wider mt-2"
                >
                    Detik
                </div>
            </div>
        </div>

        <div v-else class="text-3xl md:text-5xl font-bold text-white text-center mb-8">
            🎉 Waktu Habis 🎉
        </div>

        <div v-if="showCountdown">
            <a
                href="/seminar/daftar"
                class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800"
            >
                <span
                    class="relative px-6 py-3 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-transparent group-hover:dark:bg-transparent text-lg font-semibold"
                >
                    Daftar Seminar
                </span>
            </a>
        </div>
    </div>
</template>

<script>

import DigitalDataBG from "../components/DigitalDataBG.vue";

export default {
    data() {
        return {
            targetDate: new Date("2025-08-23T23:59:59"),
            days: "00",
            hours: "00",
            minutes: "00",
            seconds: "00",
            showCountdown: true,
            interval: null,
        };
    },
    mounted() {
        this.startCountdown();
    },
    beforeUnmount() {
        clearInterval(this.interval);
    },
    methods: {
        startCountdown() {
            this.updateCountdown();
            this.interval = setInterval(this.updateCountdown, 1000);
        },
        updateCountdown() {
            const now = new Date().getTime();
            const distance = this.targetDate.getTime() - now;

            if (distance <= 0) {
                this.showCountdown = false;
                clearInterval(this.interval);
                return;
            }

            this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, "0");
            this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, "0");
            this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, "0");
            this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, "0");
        },
    },
};
</script>
