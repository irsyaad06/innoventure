<!-- Navbar.vue -->
<template>
    <nav class="bg-gray-900 fixed w-full z-20 top-0 start-0">
        <div
            class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-1"
        >
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img
                    src="../../../public/img/secondary-logo.png"
                    class="h-16"
                    alt="Flowbite Logo"
                />
            </a>
            <div
                class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse"
            >
                <button
                    type="button"
                    class="text-white bg-gradient-to-bl from-blue-300 via-blue-500 to-blue-600 hover:bg-gradient-to-tr font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 cursor-pointer"
                >
                    Daftar Sekarang
                </button>
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
                        <a
                            href="#"
                            class="block py-2 px-3 text-white rounded-sm md:p-0 md:text-blue-500 md:bg-transparent"
                            aria-current="page"
                            >Beranda</a
                        >
                    </li>
                    <li>
                        <button
                            id="dropdownNavbarLink"
                            data-dropdown-toggle="dropdownNavbar"
                            class="flex items-center justify-between cursor-pointer w-full py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent"
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
                            class="z-10 hidden font-light divide-y p-2 rounded-lg shadow-sm w-44 bg-gray-700 divide-gray-600"
                        >
                            <ul
                                class="py-2 text-sm text-gray-700 dark:text-gray-400"
                                aria-labelledby="dropdownLargeButton"
                            >
                                <li>
                                    <a
                                        href="/kompetisi/web-development"
                                        class="block px-4 py-2 text-gray-200 hover:bg-gray-600 hover:text-blue-400"
                                        >Web Development</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="/kompetisi/mobile-legend"
                                        class="block px-4 py-2 text-gray-200 hover:bg-gray-600 hover:text-blue-400"
                                        >Mobile Legend</a
                                    >
                                </li>
                            </ul>
                            <div class="py-1 flex justify-center items-center pt-2 pl-2">
                                <button type="button" class="text-white cursor-pointer bg-gradient-to-r from-blue-300 via-blue-500 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-xs px-5 py-2.5 text-center me-2 mb-2">Semua Kompetisi</button>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a
                            href="/game-on"
                            class="block py-2 px-3 text-white rounded-sm md:p-0 md:bg-transparent"
                            aria-current="page"
                            >Game On!</a
                        >
                    </li>
                    <li>
                        <a
                            href="/seminar"
                            class="block py-2 px-3 text-white rounded-sm md:p-0 md:bg-transparent"
                            aria-current="page"
                            >Seminar</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
