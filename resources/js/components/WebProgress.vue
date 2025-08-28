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
                            <div v-if="progress.is_judged_by_current_user">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="w-6 h-6 text-emerald-500"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.06 0l4.001-5.497z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>

                            <div v-else>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="w-6 h-6 text-gray-600"
                                >
                                    <path
                                        d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4zM3 8h14a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V9a1 1 0 011-1z"
                                    />
                                </svg>
                            </div>
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
import { onMounted, ref } from "vue";
import { useWebdevProgressStore } from "../stores/webdevProgress";
import { useJuriStore } from "../stores/juriStore"; // 1. Impor store juri

const progressStore = useWebdevProgressStore();
const juriStore = useJuriStore();
const isReadOnly = ref(true);

onMounted(() => {
    progressStore.fetchAll();
});
</script>
