<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
        <div
            class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4"
        >
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div
                    class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none"
                >
                    <svg
                        class="w-4 h-4 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        />
                    </svg>
                </div>
                <input
                    type="text"
                    id="table-search-users"
                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Cari Tim Kamu !"
                />
            </div>
        </div>
        <table
            class="w-full text-sm text-left rtl:text-right text-text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">Rank</th>
                    <th scope="col" class="px-6 py-3">Nama Tim</th>
                    <th scope="col" class="px-6 py-3">Website</th>
                    <th scope="col" class="px-6 py-3">PPT</th>
                    <th scope="col" class="px-6 py-3 text-amber-300">Poin</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop melalui data progress -->
                <tr
                    v-for="(progress, index) in progressStore.progresses"
                    :key="progress.id"
                    class="bg-gray-transparent border-gray-700 border-gray-Online hover:bg-gray-50 dark:hover:bg-gray-600"
                >
                    <th
                        scope="row"
                        class="pr-10 text-center py-4 text-lg font-bold"
                        :class="{
                            'text-green-500': index + 1 <= 5,
                            'text-amber-300': index + 1 > 5 && index + 1 <= 10,
                            'text-red-500': index + 1 > 10,
                        }"
                    >
                        {{ index + 1 }}
                    </th>
                    <th
                        scope="row"
                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
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

                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div
                                :class="{
                                    'h-2.5 w-2.5 rounded-full me-2': true,
                                    'bg-green-500': progress.web_app_uploaded,
                                    'bg-red-500': !progress.web_app_uploaded,
                                }"
                            ></div>
                            {{
                                progress.web_app_uploaded ? "Online" : "Offline"
                            }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div
                                :class="{
                                    'text-green-500': progress.ppt_uploaded,
                                    'text-red-500': !progress.ppt_uploaded,
                                }"
                            >
                                {{ progress.ppt_uploaded ? "200" : "404" }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="text-gray-200">90</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a
                            href="#"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                            >Detail</a
                        >
                    </td>
                </tr>
                <tr
                    v-if="
                        !progressStore.progresses.length &&
                        !progressStore.loading
                    "
                >
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Tidak ada data progress yang tersedia.
                    </td>
                </tr>
                <tr v-if="progressStore.loading">
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useWebdevProgressStore } from "../stores/webdevProgress"; // Sesuaikan path ini

const progressStore = useWebdevProgressStore();

onMounted(() => {
    progressStore.fetchAll();
});
</script>
