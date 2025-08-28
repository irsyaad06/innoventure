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
                    alt="Innoventure Logo"
                />
            </RouterLink>
            <div
                class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse"
            >
                <div v-if="isLoading" class="hidden md:flex items-center pr-4">
                    <div
                        class="animate-spin rounded-full h-6 w-6 border-b-2 border-sky-300"
                    ></div>
                </div>
                <RouterLink
                    v-else-if="!isAuthenticated"
                    to="/daftar"
                    class="text-white hidden md:flex bg-gradient-to-bl from-sky-300 via-sky-500 to-sky-600 hover:bg-gradient-to-tr font-medium rounded-lg text-xs md:text-sm px-5 py-2.5 text-center me-2 mb-2 cursor-pointer"
                >
                    Daftar Lomba
                </RouterLink>
                <div
                    v-else-if="juri"
                    class="relative hidden md:flex items-center"
                >
                    <button
                        ref="profileButtonRef"
                        @click="isProfileDropdownOpen = !isProfileDropdownOpen"
                        class="flex items-center gap-2 text-white p-2 rounded-lg hover:bg-gray-700 transition-colors"
                    >
                        <span class="font-semibold text-sm">{{
                            juri.nama
                        }}</span>
                        <svg
                            class="w-2.5 h-2.5"
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
                    <div
                        v-show="isProfileDropdownOpen"
                        ref="profileDropdownRef"
                        class="absolute top-full right-0 mt-2 w-48 bg-gray-700 rounded-lg shadow-lg py-2 z-50"
                    >
                        <RouterLink
                            to="/info-juri"
                            @click="isProfileDropdownOpen = false"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-600"
                            >Profil Saya</RouterLink
                        >
                        <a
                            href="#"
                            @click.prevent="handleLogout"
                            class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-600"
                            >Logout</a
                        >
                    </div>
                </div>

                <button
                    ref="burgerButton"
                    data-collapse-toggle="navbar-menu"
                    type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-menu"
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

            <div class="hidden w-full md:block md:w-auto" id="navbar-menu">
                <ul
                    class="flex flex-col font-light p-4 md:p-0 mt-4 border border-gray-700 rounded-lg bg-gray-900 md:space-x-8 md:flex-row md:mt-0 md:border-0"
                >
                    <li>
                        <RouterLink
                            @click="closeMobileMenu"
                            to="/"
                            class="block py-2 px-3 text-gray-400 rounded-sm md:p-0 hover:text-sky-300"
                            :class="{ 'text-sky-300': route.path === '/' }"
                            >Beranda</RouterLink
                        >
                    </li>
                    <li>
                        <button
                            ref="kompetisiButtonRef"
                            @click="isDropdownOpen = !isDropdownOpen"
                            class="flex items-center justify-between cursor-pointer w-full py-2 px-3 rounded-sm md:border-0 md:p-0 md:w-auto text-gray-400 hover:text-sky-300"
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
                        <div
                            id="dropdownNavbar"
                            v-show="isDropdownOpen"
                            ref="dropdownRef"
                            class="z-10 absolute font-light divide-y p-2 rounded-lg shadow-sm w-44 bg-gray-700 divide-gray-600"
                        >
                            <ul class="py-2 text-sm text-gray-400">
                                <li
                                    v-for="lomba in cabangLombaStore.cabangLombas"
                                    :key="lomba.id"
                                >
                                    <RouterLink
                                        @click="
                                            isDropdownOpen = false;
                                            closeMobileMenu();
                                        "
                                        :to="`/kompetisi/${lomba.nama
                                            .toLowerCase()
                                            .replace(/ /g, '-')}`"
                                        class="block px-4 py-2 text-gray-200 hover:bg-gray-600 hover:text-sky-300"
                                        >{{ lomba.nama }}</RouterLink
                                    >
                                </li>
                            </ul>
                            <div
                                class="py-1 flex justify-center items-center pt-2 pl-2"
                            >
                                <RouterLink
                                    @click="
                                        isDropdownOpen = false;
                                        closeMobileMenu();
                                    "
                                    to="/kompetisi"
                                    class="text-white cursor-pointer bg-gradient-to-r from-sky-300 via-sky-500 to-sky-700 hover:bg-gradient-to-br font-medium rounded-lg text-xs px-5 py-2.5 text-center me-2 mb-2"
                                >
                                    Semua Kompetisi
                                </RouterLink>
                            </div>
                        </div>
                    </li>
                    <li>
                        <RouterLink
                            @click="closeMobileMenu"
                            to="/game-on"
                            class="block py-2 px-3 text-gray-400 md:p-0 hover:text-sky-300"
                            :class="{
                                'text-sky-300': route.path === '/game-on',
                            }"
                            >Game On!</RouterLink
                        >
                    </li>
                    <li>
                        <RouterLink
                            @click="closeMobileMenu"
                            to="/seminar"
                            class="block py-2 px-3 text-gray-400 md:p-0 hover:text-sky-300"
                            :class="{
                                'text-sky-300': route.path === '/seminar',
                            }"
                            >Seminar</RouterLink
                        >
                    </li>

                    <li class="mt-4 border-t border-gray-700 pt-4 md:hidden">
                        <div
                            v-if="isLoading"
                            class="flex items-center justify-center py-2"
                        >
                            <div
                                class="animate-spin rounded-full h-6 w-6 border-b-2 border-sky-300"
                            ></div>
                        </div>

                        <RouterLink
                            v-else-if="!isAuthenticated"
                            @click="closeMobileMenu"
                            to="/daftar"
                            class="text-white bg-gradient-to-bl from-sky-300 via-sky-500 to-sky-600 hover:bg-gradient-to-tr font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full block"
                        >
                            Daftar Lomba
                        </RouterLink>

                        <div v-else-if="juri" class="space-y-2">
                            <div class="px-3 py-2 text-sm text-white">
                                <div class="font-semibold">{{ juri.nama }}</div>
                                <div class="text-gray-400 truncate">
                                    {{ juri.email }}
                                </div>
                            </div>
                            <ul class="text-gray-300">
                                <li>
                                    <RouterLink
                                        @click="closeMobileMenu"
                                        to="/info-juri"
                                        class="block w-full text-left px-3 py-2 rounded-md hover:bg-gray-700"
                                    >
                                        Profil Saya
                                    </RouterLink>
                                </li>
                                <li>
                                    <button
                                        @click="handleLogoutMobile"
                                        class="block w-full text-left px-3 py-2 rounded-md text-red-400 hover:bg-gray-700"
                                    >
                                        Logout
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, onMounted, computed, onUnmounted } from "vue";
import { RouterLink, useRoute, useRouter } from "vue-router";
import { useCabangLombaStore } from "../stores/cabangLomba";
import { useJuriStore } from "../stores/juriStore";
import { initFlowbite } from "flowbite";

// Inisialisasi
const isDropdownOpen = ref(false);
const isProfileDropdownOpen = ref(false);
const cabangLombaStore = useCabangLombaStore();
const juriStore = useJuriStore();
const route = useRoute();
const router = useRouter();

// Computed properties
const isAuthenticated = computed(() => juriStore.isAuthenticated);
const juri = computed(() => juriStore.currentJuri);
const isLoading = computed(() => juriStore.isLoading);
const isCompetisiRouteActive = computed(() =>
    route.path.startsWith("/kompetisi")
);

// Refs
const dropdownRef = ref(null);
const kompetisiButtonRef = ref(null);
const profileDropdownRef = ref(null);
const profileButtonRef = ref(null);
const burgerButton = ref(null);

// Fungsi untuk menutup dropdown
function handleClickOutside(event) {
    if (
        kompetisiButtonRef.value &&
        !kompetisiButtonRef.value.contains(event.target) &&
        dropdownRef.value &&
        !dropdownRef.value.contains(event.target)
    ) {
        isDropdownOpen.value = false;
    }
    if (
        profileButtonRef.value &&
        !profileButtonRef.value.contains(event.target) &&
        profileDropdownRef.value &&
        !profileDropdownRef.value.contains(event.target)
    ) {
        isProfileDropdownOpen.value = false;
    }
}

// Fungsi untuk menutup menu mobile
function closeMobileMenu() {
    if (
        burgerButton.value &&
        burgerButton.value.getAttribute("aria-expanded") === "true"
    ) {
        burgerButton.value.click();
    }
}

// Fungsi logout (untuk desktop)
const handleLogout = async () => {
    isProfileDropdownOpen.value = false;
    await juriStore.logout();
    router.push("/login-juri");
};

// Fungsi logout (untuk mobile, sekaligus menutup menu)
const handleLogoutMobile = async () => {
    closeMobileMenu();
    await juriStore.logout();
    router.push("/login-juri");
};

onMounted(() => {
    cabangLombaStore.fetchAll();
    document.addEventListener("mousedown", handleClickOutside);
    initFlowbite();
});

onUnmounted(() => {
    document.removeEventListener("mousedown", handleClickOutside);
});
</script>
