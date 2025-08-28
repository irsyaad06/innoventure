<script setup>
import { onMounted } from "vue";
import { useJuriStore } from "../stores/juriStore";

const juriStore = useJuriStore();

onMounted(() => {
    juriStore.fetchJuri(); // fetch saat komponen muncul
});
</script>

<template>
    <div
        class="relative z-10 w-full text-white flex items-center justify-center p-4 sm:p-6"
    >
        <div
            class="w-full max-w-7xl bg-white/5 backdrop-blur-md rounded-2xl shadow-2xl border border-white/10 p-6 mt-10 sm:p-10 card-with-bg-logo"
        >
            <h3 class="text-2xl font-bold text-center text-cyan-400 mb-8">
                Sebuah Pesan dari Tim Juri
            </h3>

            <p class="text-gray-300 mb-4 leading-relaxed">
                Kepada para peserta lomba yang luar biasa,
            </p>
            <p class="text-gray-300 mb-4 leading-relaxed">
                Dengan segala hormat, kami ingin menyampaikan rasa apresiasi
                yang setinggi-tingginya atas seluruh dedikasi, kerja keras, dan
                kreativitas yang telah kalian curahkan dalam setiap karya yang
                dipresentasikan. Kami sangat terkesan melihat potensi luar biasa
                yang kalian miliki.
            </p>

            <p class="text-gray-300 mb-4 leading-relaxed">
                Karya-karya yang telah kami nilai bukanlah sekadar proyek,
                melainkan cerminan dari semangat belajar dan gairah kalian
                terhadap dunia pengembangan web. Kalian telah membuktikan bahwa
                talenta di Jawa Barat sungguh menjanjikan. Pengalaman kami
                sebagai juri, yang telah berkecimpung di industri ini selama
                lebih dari empat tahun, membentuk perspektif bahwa standar
                tinggi adalah kunci untuk pertumbuhan. Oleh karena itu, kami
                menetapkan standar penilaian yang mungkin terasa menantang.
            </p>

            <p class="text-gray-300 mb-4 leading-relaxed">
                Hal ini bukan untuk mengecilkan hasil kerja keras kalian,
                melainkan sebagai bentuk kepercayaan kami bahwa kalian mampu
                melampaui batasan saat ini dan mengembangkan diri menjadi
                profesional yang tangguh di masa depan. Catatan ini kami berikan
                sebagai bentuk apresiasi dan bimbingan, bukan sebagai kritikan.
            </p>

            <p class="text-gray-300 mb-6 leading-relaxed">
                Kami sangat yakin bahwa dengan semangat dan potensi yang kalian
                miliki, kalian dapat menjadi generasi pengembang web yang andal
                dan inovatif. Teruslah belajar, berani bereksperimen, dan jangan
                pernah berhenti mengasah kemampuan. Kami tidak sabar untuk
                melihat sejauh mana kalian akan berkembang. Selamat atas kerja
                keras kalian, dan sukses selalu!
            </p>

            <div class="mt-10 text-right">
                <p class="text-gray-400 italic">Hormat kami,</p>
                <p class="text-gray-300 font-semibold mt-1 mb-5">
                    Tim Juri Lomba Web Development
                </p>
                <div v-for="(juri, i) in juriStore.juris" :key="i">
                    <p class="text-gray-300 font-thin text-sm mt-1">
                        {{ juri.nama }} | {{ juri.role }}
                    </p>
                </div>
                <p class="text-cyan-500 font-bold mt-5">INNOVENTURE 2025</p>
            </div>
        </div>
    </div>
</template>
<style scoped>
.card-with-bg-logo {
    position: relative;
    z-index: 1;
}

.card-with-bg-logo::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
    background-image: url("/img/primary-logo.png");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 45%;
    opacity: 0.12;
}
</style>
