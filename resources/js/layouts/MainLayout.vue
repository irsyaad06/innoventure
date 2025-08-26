<template>
    <div class="bg-gray-900">
        <Navbar />
        <main class="bg-gray-900 md:p-4 mx-4 md:mx-12 lg:mx-20">
            <router-view />
        </main>
        <!-- <Footer /> -->
    </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
// import Footer from "../components/Footer.vue";
</script>
