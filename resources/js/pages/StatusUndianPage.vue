<template>
    <div class="min-h-screen bg-gray-900 pt-28">
        <div class="container mx-auto px-4 text-white text-center">
            <div
                v-if="seminarStore.isLoading"
                class="text-xl text-cyan-400 animate-pulse"
            >
                Memuat data pendaftaran...
            </div>

            <div
                v-else-if="seminarStore.error"
                class="bg-red-500/20 border border-red-500 text-red-400 p-6 rounded-lg"
            >
                <h2 class="text-2xl font-bold mb-2">Terjadi Kesalahan</h2>
                <p>{{ seminarStore.error }}</p>
            </div>

            <div
                v-else-if="seminarStore.pendaftarDetail"
                class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-lg max-w-2xl mx-auto"
            >
                <h1 class="text-3xl font-bold text-white drop-shadow-lg">
                    ✅ Pendaftaran Berhasil!
                </h1>
                <p class="mt-2 text-gray-300">
                    Berikut adalah detail pendaftaran seminar Anda.
                </p>

                <div class="mt-8 text-left space-y-4">
                    <div class="bg-gray-700/50 p-4 rounded-lg">
                        <label class="text-sm text-gray-400 block"
                            >Nama Lengkap</label
                        >
                        <p class="text-lg font-semibold">
                            {{ seminarStore.pendaftarDetail.nama }}
                        </p>
                    </div>
                    <div class="bg-gray-700/50 p-4 rounded-lg">
                        <label class="text-sm text-gray-400 block"
                            >Asal Sekolah/Instansi</label
                        >
                        <p class="text-lg font-semibold">
                            {{ seminarStore.pendaftarDetail.instansi }}
                        </p>
                    </div>
                    <div class="bg-gray-700/50 border border-yellow-500 p-4 rounded-lg">
                        <label class="text-sm text-gray-400 block"
                            >Grup Seminar</label
                        >
                        <a
                            href="https://chat.whatsapp.com/B9YIqjJ4BrYBvEzB2Q6mcT?mode=ems_copy_c"
                            target="_blank"
                            class="text-lg font-semibold text-yellow-500 hover:text-yellow-300"
                        >
                            Klik aku dong!.
                        </a>
                    </div>
                    <div
                        class="bg-cyan-600/30 border border-cyan-500 p-4 rounded-lg"
                    >
                        <label class="text-sm text-cyan-300 block"
                            >Nomor Undian Anda</label
                        >
                        <p
                            class="text-xl font-bold tracking-wider text-cyan-300"
                        >
                            {{ seminarStore.pendaftarDetail.no_undian }}
                        </p>
                    </div>

                    <div class="bg-gray-700/50 p-4 rounded-lg text-center">
                        <label class="text-sm text-gray-400 block mb-4"
                            >Kode Absen (QR Code)</label
                        >

                        <div class="bg-white p-4 rounded-lg inline-block">
                            <qrcode-vue
                                :value="seminarStore.pendaftarDetail.kode_absen"
                                :size="qrSize"
                                level="H"
                            />
                        </div>

                        <p
                            class="mt-4 text-lg font-semibold tracking-widest font-mono"
                        >
                            {{ seminarStore.pendaftarDetail.kode_absen }}
                        </p>
                    </div>
                </div>

                <p class="mt-8 text-sm text-gray-400">
                    Harap simpan nomor undian dan kode absen Anda. Sampai jumpa
                    di acara seminar!
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { useSeminarStore } from "../stores/seminarStore";
import QrcodeVue from "qrcode.vue";

export default {
    name: "StatusUndianPage",
    components: {
        QrcodeVue,
    },
    data() {
        return {
            seminarStore: useSeminarStore(),
            // 1. Tambahkan data untuk ukuran QR, beri nilai default
            qrSize: 200,
        };
    },
    // 2. Tambahkan lifecycle hooks
    mounted() {
        // Panggil method saat komponen pertama kali dimuat
        this.updateQrSize();
        // Tambahkan event listener untuk mendeteksi perubahan ukuran window
        window.addEventListener("resize", this.updateQrSize);
    },
    beforeUnmount() {
        // Hapus event listener saat komponen dihancurkan untuk mencegah memory leak
        window.removeEventListener("resize", this.updateQrSize);
    },
    // 3. Tambahkan object methods
    methods: {
        updateQrSize() {
            const screenWidth = window.innerWidth;
            if (screenWidth < 480) {
                // Untuk layar HP kecil (lebar di bawah 480px)
                this.qrSize = 150;
            } else {
                // Untuk layar yang lebih besar
                this.qrSize = 200;
            }
        },
    },
    created() {
        const kodeAbsen = this.$route.params.kode_absen;
        this.seminarStore.fetchPendaftarByKode(kodeAbsen);
    },
};
</script>
