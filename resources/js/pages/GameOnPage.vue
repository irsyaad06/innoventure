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
                        <!-- Anda bisa menambahkan ikon secara kondisional di sini jika diperlukan -->
                        <svg
                            v-if="lomba.nama === 'Mobile Legend'"
                            class="w-4 h-4 me-2 text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"
                            />
                        </svg>
                        <svg
                            v-else
                            class="w-4 h-4 me-2 text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 18 18"
                        >
                            <path
                                d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"
                            />
                        </svg>
                        {{ lomba.nama }}
                    </a>
                </li>
            </ul>
            <div
                class="p-6 bg-gray-800 text-medium text-gray-400 rounded-lg w-full h-full"
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
