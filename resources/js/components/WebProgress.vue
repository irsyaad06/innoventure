<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
        <table
            class="w-full text-sm text-left rtl:text-right text-text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">Rank</th>
                    <th scope="col" class="px-6 py-3">Nama Tim</th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-amber-300 text-center"
                    >
                        Skor
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-center"
                        v-if="juriStore.isAuthenticated"
                    >
                        Dinilai
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(progress, index) in progressStore.progresses"
                    :key="progress.id"
                    class="bg-transparent border-b border-gray-700 hover:bg-gray-600"
                >
                    <td
                        class="px-6 py-4 text-center text-lg font-bold"
                        :class="{
                            'text-green-500': index + 1 <= 5,
                            'text-amber-300': index + 1 > 5 && index + 1 <= 10,
                            'text-red-500': index + 1 > 10,
                        }"
                    >
                        {{ index + 1 }}
                    </td>
                    <th
                        scope="row"
                        class="flex items-center px-6 py-4 text-white whitespace-nowrap"
                    >
                        <img
                            class="w-10 h-10 rounded-full"
                            :src="'/storage/' + progress.tim.instansi.logo"
                            :alt="'Logo ' + progress.tim.instansi.nama"
                        />
                        <div class="ps-3">
                            <div class="text-base font-semibold">
                                {{ progress.tim.nama }}
                            </div>
                            <div class="font-normal text-gray-500">
                                {{ progress.tim.instansi.nama }}
                            </div>
                        </div>
                    </th>
                    <td class="px-6 py-4 text-center text-gray-200">
                        {{ progress.total_skor.toFixed(2) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <router-link
                            :to="`/detail-web/${progress.id}`"
                            class="font-medium text-blue-500 hover:underline"
                        >
                            Detail
                        </router-link>
                    </td>
                    <td
                        class="px-6 py-4 text-center"
                        v-if="juriStore.isAuthenticated"
                    >
                        <div class="flex items-center justify-center">
                            <input
                                :id="`checkbox-table-search-${progress.id}`"
                                type="checkbox"
                                :disabled="isReadOnly"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                            />
                            <label
                                :for="`checkbox-table-search-${progress.id}`"
                                class="sr-only"
                                >checkbox</label
                            >
                        </div>
                    </td>
                </tr>
                <tr
                    v-if="
                        !progressStore.progresses.length &&
                        !progressStore.loading
                    "
                >
                    <td
                        :colspan="juriStore.isAuthenticated ? 5 : 4"
                        class="text-center py-4 text-gray-500"
                    >
                        Tidak ada data progress yang tersedia.
                    </td>
                </tr>
                <tr v-if="progressStore.loading">
                    <td
                        :colspan="juriStore.isAuthenticated ? 5 : 4"
                        class="text-center py-4 text-gray-500"
                    >
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { onMounted , ref} from "vue";
import { useWebdevProgressStore } from "../stores/webdevProgress";
import { useJuriStore } from "../stores/juriStore"; // 1. Impor store juri

const progressStore = useWebdevProgressStore();
const juriStore = useJuriStore();
const isReadOnly = ref(true);

onMounted(() => {
    progressStore.fetchAll();
});
</script>
