<template>
    <!-- Digital Data Animation Background -->
    <div class="digital-data-background fixed inset-0">
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
            <span class="text-sky-400 opacity-50 text-sm md:text-md">
                {{ getDigitalCharacter() }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: "DigitalDataBackground",
    methods: {
        getDigitalCharacter() {
            const characters = [
                "{ }",
                "In",
                "no",
                "ven",
                "ture",
                "<. >",
                "2025",
                "0101",
                "&&",
                "</>",
                "||",
                "=>",
                "[]",
            ];
            const randomIndex = Math.floor(Math.random() * characters.length);
            return characters[randomIndex];
        },
    },
};
</script>

<style scoped>
.digital-data-background {
    pointer-events: none;
}

.digital-data {
    position: absolute;
    bottom: -10%;
    animation-name: fly-up;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-duration: 5s;
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
</style>
