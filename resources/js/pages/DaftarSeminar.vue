<template>
    <div
        class="min-h-screen bg-transparent md:bg-gray-900 text-white flex flex-col items-center justify-center p-0 md:p-6 mt-15"
    >
        <div
            class="w-full max-w-5xl bg-transparent md:bg-white/5 backdrop-blur-md rounded-2xl shadow-2xl md:border border-white/10 p-0 md:p-6 sm:p-10 space-y-8"
        >
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4">
                    Seminar Innoventure 2025
                </h1>
                <p
                    class="text-gray-300 max-w-3xl mx-auto leading-relaxed text-sm sm:text-base"
                >
                    Bergabunglah dalam seminar yang akan membuka wawasan dan
                    menginspirasi Anda!
                    <br /><br />
                    Kami mengundang Anda untuk ikut serta dalam
                    <span class="font-semibold text-cyan-400"
                        >Seminar INNOVENTURE</span
                    >, sebuah acara yang dirancang khusus untuk memberikan
                    pengetahuan mendalam dan wawasan terbaru tentang
                    <span class="italic text-cyan-400"
                        >Web Dev dimasa depan</span
                    >. Jangan lewatkan kesempatan untuk belajar langsung dari
                    para ahli dan praktisi berpengalaman di bidangnya.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-4 sm:gap-6">
                <div
                    class="bg-white/10 p-4 sm:p-6 rounded-xl border border-white/10 shadow-md"
                >
                    <h3 class="font-semibold mb-2 text-cyan-300">
                        ✨ Pengetahuan Mendalam
                    </h3>
                    <p class="text-gray-300 text-xs sm:text-sm">
                        Ikuti sesi yang membahas tren terkini dan strategi
                        terbaik dalam Web Dev dimasa depan.
                    </p>
                </div>
                <div
                    class="bg-white/10 p-4 sm:p-6 rounded-xl border border-white/10 shadow-md"
                >
                    <h3 class="font-semibold mb-2 text-cyan-300">
                        ✨ Interaksi Langsung
                    </h3>
                    <p class="text-gray-300 text-xs sm:text-sm">
                        Ajukan pertanyaan dan diskusikan ide-ide dengan
                        pembicara dan peserta lain.
                    </p>
                </div>
                <div
                    class="bg-white/10 p-4 sm:p-6 rounded-xl border border-white/10 shadow-md"
                >
                    <h3 class="font-semibold mb-2 text-cyan-300">
                        ✨ Jaringan & Kolaborasi
                    </h3>
                    <p class="text-gray-300 text-xs sm:text-sm">
                        Temui para profesional, pengusaha, dan praktisi dari
                        berbagai latar belakang.
                    </p>
                </div>
                <div
                    class="bg-white/10 p-4 sm:p-6 rounded-xl border border-white/10 shadow-md"
                >
                    <h3 class="font-semibold mb-2 text-cyan-300">
                        ✨ Sertifikat Partisipasi
                    </h3>
                    <p class="text-gray-300 text-xs sm:text-sm">
                        Dapatkan sertifikat yang akan memperkaya portofolio dan
                        CV Anda.
                    </p>
                </div>
            </div>

            <div v-if="isLoading" class="text-center text-gray-400">
                Sedang memuat detail seminar...
            </div>
            <div v-else-if="error" class="text-center text-red-400">
                {{ error }}
            </div>
            <div
                v-else-if="seminarDetails"
                class="grid md:grid-cols-3 gap-4 sm:gap-6 text-center"
            >
                <div
                    class="bg-white/10 p-4 sm:p-5 rounded-xl border border-white/10"
                >
                    <h4 class="font-semibold text-cyan-300">📅 Tanggal</h4>
                    <p class="text-gray-300 text-xs sm:text-sm">
                        {{ formatTanggal(seminarDetails.tanggal) }}
                    </p>
                </div>
                <div
                    class="bg-white/10 p-4 sm:p-5 rounded-xl border border-white/10"
                >
                    <h4 class="font-semibold text-cyan-300">⏰ Waktu</h4>
                    <p class="text-gray-300 text-xs sm:text-sm">
                        {{ formatWaktu(seminarDetails.waktu) }} - Selesai
                    </p>
                </div>
                <div
                    class="bg-white/10 p-4 sm:p-5 rounded-xl border border-white/10"
                >
                    <h4 class="font-semibold text-cyan-300">📍 Tempat</h4>
                    <p class="text-gray-300 text-xs sm:text-sm">
                        {{ seminarDetails.tempat }}
                    </p>
                </div>
            </div>
            <div v-else class="text-center text-gray-400">
                Tidak ada data seminar yang tersedia.
            </div>

            <div
                class="bg-white/5 p-4 sm:p-5 rounded-xl border border-white/10 text-center"
            >
                <p class="text-xs sm:text-sm text-gray-300">
                    Untuk informasi lebih lanjut, hubungi Contact Person kami:
                    <br />
                    📞 MINNOV1 :
                    <span class="font-semibold">081235452002</span> &nbsp; |
                    &nbsp; 📞 MINNOV2 :
                    <span class="font-semibold">081235452005</span>
                </p>
            </div>

            <div
                id="form-pendaftaran"
                class="bg-white/10 p-6 sm:p-8 rounded-xl border border-white/10 shadow-md"
            >
                <h2 class="text-xl font-bold text-center mb-6 text-cyan-200">
                    Form Pendaftaran
                </h2>
                <form
                    @submit.prevent="handleSubmit"
                    class="space-y-4 sm:space-y-5"
                >
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-200 mb-1"
                            >Nama</label
                        >
                        <input
                            type="text"
                            v-model="form.nama"
                            class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none text-xs"
                            placeholder="Masukkan nama lengkap"
                            required
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-200 mb-1"
                            >Asal Sekolah / Instansi</label
                        >
                        <input
                            type="text"
                            v-model="form.instansi"
                            class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none text-xs"
                            placeholder="Masukkan asal sekolah/instansi"
                            required
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-200 mb-1"
                            >Email</label
                        >
                        <input
                            type="email"
                            v-model="form.email"
                            class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none text-xs"
                            placeholder="Masukkan email"
                            required
                        />
                        <span class="text-yellow-500 text-xs"
                            >*Gunakan email asli untuk mendapatkan
                            sertifikat</span
                        >
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-200 mb-1"
                            >No WhatsApp</label
                        >
                        <input
                            type="tel"
                            v-model="form.no_hp"
                            class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none text-xs"
                            placeholder="Masukkan no WhatsApp"
                            required
                        />
                        <span class="text-yellow-500 text-xs"
                            >*Gunakan Nomor yang terdaftar Whatsapp untuk
                            verifikasi memasuki grup</span
                        >
                    </div>
                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105"
                        >
                            Daftar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <button
        v-show="showButton"
        @click="scrollToForm"
        ref="daftarButton"
        class="fixed bottom-4 right-4 z-50 px-6 py-3 bg-gradient-to-br from-cyan-500 to-blue-600 text-white font-semibold rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl focus:outline-none"
    >
        Daftar Sekarang
    </button>
</template>

<script>
import { useSeminarStore } from "../stores/seminarStore";

export default {
    data() {
        return {
            seminarDetails: null,
            form: {
                nama: "",
                instansi: "",
                email: "",
                no_hp: "",
            },
            showButton: false, // Tambahkan properti untuk mengontrol visibilitas tombol
        };
    },
    mounted() {
        const seminarStore = useSeminarStore();
        seminarStore.fetchSeminars();

        this.$watch(
            () => seminarStore.seminars,
            (newSeminars) => {
                if (newSeminars.length > 0) {
                    this.seminarDetails = newSeminars[0];
                }
            },
            { immediate: true }
        );

        // Tambahkan event listener untuk memantau posisi scroll
        window.addEventListener("scroll", this.handleScroll);
        this.handleScroll(); // Panggil sekali saat mount untuk memeriksa posisi awal
    },
    unmounted() {
        // Hapus event listener saat komponen dihancurkan
        window.removeEventListener("scroll", this.handleScroll);
    },
    computed: {
        isLoading() {
            return useSeminarStore().isLoading;
        },
        error() {
            return useSeminarStore().error;
        },
    },
    methods: {
        // Fungsi untuk memformat tanggal
        formatTanggal(dateString) {
            if (!dateString) return "";
            const options = {
                weekday: "long",
                day: "numeric",
                month: "long",
                year: "numeric",
            };
            const date = new Date(dateString);
            return date.toLocaleDateString("id-ID", options);
        },
        // Fungsi untuk memformat waktu
        formatWaktu(timeString) {
            if (!timeString) return "";
            const timePart = timeString.split(" ")[1];
            const [hours, minutes] = timePart.split(":");
            return `${hours.substring(0, 2)}.${minutes} WIB`;
        },
        async handleSubmit() {
            const seminarStore = useSeminarStore();
            const result = await seminarStore.postSeminar({
                nama: this.form.nama,
                instansi: this.form.instansi,
                email: this.form.email,
                no_hp: this.form.no_hp,
            });

            if (result) {
                alert(
                    "Pendaftaran berhasil! No Undian: " +
                        result.payload.no_undian
                );
                this.form = {
                    nama: "",
                    instansi: "",
                    email: "",
                    no_hp: "",
                };
            } else {
                alert("Pendaftaran gagal: " + seminarStore.submissionError);
            }
        },
        // Fungsi untuk menggulir halaman ke form pendaftaran
        scrollToForm() {
            const formElement = document.getElementById("form-pendaftaran");
            if (formElement) {
                formElement.scrollIntoView({ behavior: "smooth" });
            }
        },
        // Fungsi untuk mengontrol visibilitas tombol
        handleScroll() {
            const formElement = document.getElementById("form-pendaftaran");
            if (formElement) {
                const rect = formElement.getBoundingClientRect();
                // Atur showButton ke true jika form berada di bawah viewport
                // dan false jika form sudah terlihat
                this.showButton = rect.top > window.innerHeight - 100;
            }
        },
    },
};
</script>
