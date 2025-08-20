<template>
    <div
        class="min-h-screen relative overflow-hidden flex items-center justify-center p-4 bg-gray-900"
    >
        <!-- Digital Data Animation Background -->
        <div class="digital-data-background absolute inset-0 z-0">
            <div
                v-for="i in 50"
                :key="i"
                class="digital-data"
                :style="{
                    left: `${Math.random() * 100}%`,
                    'animation-delay': `${Math.random() * 5}s`,
                    'animation-duration': `${5 + Math.random() * 5}s`,
                }"
            >
                <!-- Tambahkan karakter digital atau ikon -->
                <span class="text-sky-400 opacity-50 text-sm md:text-md">
                    {{ getDigitalCharacter() }}
                </span>
            </div>
        </div>

        <div class="max-w-6xl mx-auto relative z-10">
            <!-- Logo Section -->
            <div class="text-center">
                <img
                    src="../../../public/img/comingsoon-notext.png"
                    alt="Coming Soon"
                    class="h-50 md:h-64 mx-auto bounce-custom"
                />
            </div>

            <!-- Main Content -->
            <div class="text-center font-mokoto space-y-4">
                <h1 class="text-5xl md:text-7xl font-bold glow-text h-23 md:h-20">
                    Coming Soon!
                </h1>

                <!-- <p class="text-xl md:text-xl text-gray-300 max-w-2xl mx-auto">
                    Kami sedang mempersiapkan sesuatu yang spektakuler untuk Anda! 
                    Tetap terhubung untuk update terbaru.
                </p> -->

                <!-- Enhanced Countdown Timer -->
                <!-- <div v-if="showCountdown" class="flex justify-center items-center gap-4 my-12">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl">
                        <div class="text-4xl md:text-6xl font-bold text-white font-mono" id="days">{{ days }}</div>
                        <div class="text-sm text-gray-300 uppercase tracking-wider mt-2">Hari</div>
                    </div>
                    
                    <div class="text-4xl md:text-6xl font-bold text-white/60">:</div>
                    
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl">
                        <div class="text-4xl md:text-6xl font-bold text-white font-mono" id="hours">{{ hours }}</div>
                        <div class="text-sm text-gray-300 uppercase tracking-wider mt-2">Jam</div>
                    </div>
                    
                    <div class="text-4xl md:text-6xl font-bold text-white/60">:</div>
                    
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl">
                        <div class="text-4xl md:text-6xl font-bold text-white font-mono" id="minutes">{{ minutes }}</div>
                        <div class="text-sm text-gray-300 uppercase tracking-wider mt-2">Menit</div>
                    </div>
                    
                    <div class="text-4xl md:text-6xl font-bold text-white/60">:</div>
                    
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 shadow-xl">
                        <div class="text-4xl md:text-6xl font-bold text-white font-mono" id="seconds">{{ seconds }}</div>
                        <div class="text-sm text-gray-300 uppercase tracking-wider mt-2">Detik</div>
                    </div>
                </div> -->

                <!-- Social Links -->
                <div
                    v-if="showSocialLinks"
                    class="flex justify-center space-x-6"
                >
                    <a
                        v-for="link in socialLinks || defaultSocialLinks"
                        :key="link.name"
                        :href="link.url"
                        class="text-gray-400 hover:text-white transition-colors duration-300"
                        :aria-label="link.name"
                    >
                        <component :is="link.icon" class="w-8 h-8" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";

export default {
    name: "ComingSoon",
    props: {
        showCountdown: {
            type: Boolean,
            default: true,
        },
        showSocialLinks: {
            type: Boolean,
            default: true,
        },
        targetDate: String,
        socialLinks: Array,
    },
    setup(props, { emit }) {
        const days = ref("00");
        const hours = ref("00");
        const minutes = ref("00");
        const seconds = ref("00");

        const defaultSocialLinks = [
            {
                name: "Instagram",
                url: "#",
                icon: {
                    template: `<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>`,
                },
            },
            {
                name: "Twitter",
                url: "#",
                icon: {
                    template: `<svg fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>`,
                },
            },
        ];

        let interval = null;

        const getDigitalCharacter = () => {
            const characters = [
                "{ }",
                "< >",
                "/* */",
                "0101",
                "&&",
                "||",
                "=>",
                "[]",
            ];
            const randomIndex = Math.floor(Math.random() * characters.length);
            return characters[randomIndex];
        };

        const updateCountdown = () => {
            const now = new Date().getTime();
            const target = props.targetDate
                ? new Date(props.targetDate).getTime()
                : new Date("2025-12-31T23:59:59").getTime();
            const distance = target - now;

            if (distance > 0) {
                days.value = Math.floor(distance / (1000 * 60 * 60 * 24))
                    .toString()
                    .padStart(2, "0");
                hours.value = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                )
                    .toString()
                    .padStart(2, "0");
                minutes.value = Math.floor(
                    (distance % (1000 * 60 * 60)) / (1000 * 60)
                )
                    .toString()
                    .padStart(2, "0");
                seconds.value = Math.floor((distance % (1000 * 60)) / 1000)
                    .toString()
                    .padStart(2, "0");
            } else {
                days.value = "00";
                hours.value = "00";
                minutes.value = "00";
                seconds.value = "00";
            }
        };

        onMounted(() => {
            if (props.showCountdown) {
                updateCountdown();
                interval = setInterval(updateCountdown, 1000);
            }
        });

        onUnmounted(() => {
            if (interval) {
                clearInterval(interval);
            }
        });

        return {
            days,
            hours,
            minutes,
            seconds,
            defaultSocialLinks,
            getDigitalCharacter,
        };
    },
};
</script>

<style scoped>
.bounce-custom {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%,
    100% {
        transform: translateY(-5%);
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }
    50% {
        transform: translateY(0);
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}

.countdown-item {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

.countdown-number {
    font-family: "Courier New", monospace;
    font-weight: 700;
}

@media (max-width: 768px) {
    .countdown-item {
        padding: 0.75rem;
    }

    .countdown-number {
        font-size: 2rem;
    }

    .countdown-separator {
        font-size: 2rem;
    }
}

.digital-data-background {
    pointer-events: none;
}

.digital-data {
    position: absolute;
    bottom: -10%;
    animation-name: fly-up;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
}

@keyframes fly-up {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0;
    }
    5% {
        opacity: 1;
    }
    100% {
        transform: translateY(-110vh) scale(1.2);
        opacity: 0;
    }
}

.glow-text {
    text-shadow: 0 0 3px rgba(0, 191, 255, 0.121),
        0 0 6px rgba(0, 191, 255, 0.165), 0 0 9px rgba(148, 219, 255, 0.346);
    background: linear-gradient(to right, #ffffff, #9bdcff, #2d6581);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
