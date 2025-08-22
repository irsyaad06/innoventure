<template>
    <div class="relative min-h-screen overflow-hidden pt-30">
        <DigitalDataBG class="z-0" />
        <div class="text-white text-3xl mb-5">Hasil & Live Perlombaan</div>

        <div class="relative z-10 md:flex">
            <ul
                class="flex-column space-y space-y-4 text-sm font-medium text-gray-400 md:me-4 mb-4 md:mb-0"
            >
                <li
                    v-for="lomba in cabangLombaStore.cabangLombas"
                    :key="lomba.id"
                >
                    <a
                        href="#"
                        class="inline-flex items-center px-4 py-3 rounded-lg w-full bg-gray-800 hover:bg-gray-700 hover:text-white"
                        :class="{
                            'active text-white bg-sky-600':
                                selectedLomba?.id === lomba.id,
                        }"
                        :aria-current="
                            selectedLomba?.id === lomba.id ? 'page' : null
                        "
                        @click.prevent="selectLomba(lomba)"
                    >
                        {{ lomba.nama }}
                    </a>
                </li>
            </ul>
            <div
                class="p-6 bg-gray-800/80 text-medium text-gray-400 rounded-lg w-full h-full"
            >
                <h3 class="text-3xl font-bold text-white mb-2">
                    {{ selectedLomba?.nama || "Pilih Cabang Lomba" }}
                    <span v-if="selectedLomba"></span>
                </h3>
                <hr class="mt-2 mb-3" />
                <div v-if="selectedLomba?.nama === 'Mobile Legend'">
                    <MLBracket />
                </div>
                <div v-else-if="selectedLomba?.nama === 'Web Development'">
                    <WebProgress />
                </div>
                <p v-else>404 Not Found</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useCabangLombaStore } from "../stores/cabangLomba";
import DigitalDataBG from "../components/DigitalDataBG.vue";
import MLBracket from "../components/MLBracket.vue";
import WebProgress from "../components/WebProgress.vue";

const cabangLombaStore = useCabangLombaStore();
const selectedLomba = ref(null);

onMounted(() => {
    cabangLombaStore.fetchAll().then(() => {
        // Set item pertama sebagai yang terpilih secara default
        if (cabangLombaStore.cabangLombas.length > 0) {
            selectedLomba.value = cabangLombaStore.cabangLombas[0];
        }
    });
});

const selectLomba = (lomba) => {
    selectedLomba.value = lomba;
};
</script>
