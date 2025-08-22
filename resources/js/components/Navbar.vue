<!-- Navbar.vue -->
<template>
    <nav class="bg-gray-900 fixed w-full z-20 top-0 start-0">
        <div
            class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-1"
        >
            <RouterLink
                to="/"
                class="flex items-center space-x-3 rtl:space-x-reverse"
            >
                <img
                    src="../../../public/img/secondary-logo.png"
                    class="h-16"
                    alt="Flowbite Logo"
                />
            </RouterLink>
            <div
                class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse"
            >
                <RouterLink
                    to="/daftar"
                    class="text-white bg-gradient-to-bl from-sky-300 via-sky-500 to-sky-600 hover:bg-gradient-to-tr font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 cursor-pointer"
                >
                    Daftar Lomba
                </RouterLink>
                <button
                    data-collapse-toggle="navbar-cta"
                    type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-cta"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 17 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15"
                        />
                    </svg>
                </button>
            </div>
            <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                <ul
                    class="flex flex-col font-light p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
                >
                    <li>
                        <RouterLink
                            to="/"
                            class="block py-2 px-3 text-gray-400 rounded-sm md:p-0"
                            aria-current="page"
                            :class="{ 'text-sky-300': route.path === '/' }"
                            >Beranda</RouterLink
                        >
                    </li>
                    <li>
                        <button
                            id="dropdownNavbarLink"
                            @click="isDropdownOpen = !isDropdownOpen"
                            class="flex items-center justify-between cursor-pointer w-full py-2 px-3 rounded-sm md:border-0 md:p-0 md:w-auto text-gray-400 md:hover:text-sky-300 focus:text-white border-gray-700 hover:bg-gray-700 md:hover:bg-transparent"
                            :class="
                                isCompetisiRouteActive ? 'text-sky-300' : ''
                            "
                        >
                            Kompetisi
                            <svg
                                class="w-2.5 h-2.5 ms-2.5"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 4 4 4-4"
                                />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div
                            id="dropdownNavbar"
                            v-show="isDropdownOpen"
                            class="z-10 absolute font-light divide-y p-2 rounded-lg shadow-sm w-44 bg-gray-700 divide-gray-600"
                            ref="dropdownRef"
                        >
                            <ul
                                class="py-2 text-sm text-gray-700 dark:text-gray-400"
                                aria-labelledby="dropdownLargeButton"
                            >
                                <li
                                    v-for="lomba in cabangLombaStore.cabangLombas"
                                    :key="lomba.id"
                                >
                                    <RouterLink
                                        @click="isDropdownOpen = false"
                                        :to="`/kompetisi/${lomba.nama
                                            .toLowerCase()
                                            .replace(/ /g, '-')}`"
                                        class="block px-4 py-2 text-gray-200 hover:bg-gray-600 hover:text-sky-300"
                                        active-class="text-sky-500"
                                        >{{ lomba.nama }}</RouterLink
                                    >
                                </li>
                            </ul>
                            <div
                                class="py-1 flex justify-center items-center pt-2 pl-2"
                            >
                                <RouterLink
                                    @click="isDropdownOpen = false"
                                    to="/kompetisi"
                                    class="text-white cursor-pointer bg-gradient-to-r from-sky-300 via-sky-500 to-sky-700 hover:bg-gradient-to-br font-medium rounded-lg text-xs px-5 py-2.5 text-center me-2 mb-2"
                                    active-class="ring-2 ring-offset-2 ring-sky-500 dark:ring-offset-gray-900"
                                >
                                    Semua Kompetisi
                                </RouterLink>
                            </div>
                        </div>
                    </li>
                    <li>
                        <RouterLink
                            to="/game-on"
                            class="block py-2 px-3 rounded-sm text-gray-400 hover:text-sky-300 md:p-0"
                            aria-current="page"
                            :class="{
                                'text-sky-300': route.path === '/game-on',
                            }"
                            >Game On!</RouterLink
                        >
                    </li>
                    <li>
                        <RouterLink
                            to="/seminar"
                            class="block py-2 px-3 rounded-sm md:p-0 md:hover:bg-transparent hover:text-sky-300 text-gray-400 hover:bg-gray-700"
                            aria-current="page"
                            :class="{
                                'text-sky-300': route.path === '/seminar',
                            }"
                            >Seminar</RouterLink
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, onMounted, computed, onUnmounted } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { useCabangLombaStore } from "../stores/cabangLomba";

const isDropdownOpen = ref(false);
const cabangLombaStore = useCabangLombaStore();
const route = useRoute();

const isCompetisiRouteActive = computed(() => {
    return route.path.startsWith("/kompetisi");
});

const dropdownRef = ref(null);

function handleClickOutside(event) {
    if (
        dropdownRef.value &&
        !dropdownRef.value.contains(event.target) &&
        event.target.id !== "dropdownNavbarLink"
    ) {
        isDropdownOpen.value = false;
    }
}

onMounted(() => {
    cabangLombaStore.fetchAll();
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>
