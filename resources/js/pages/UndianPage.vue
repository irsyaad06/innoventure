<template>
    <div class="min-h-screen pt-20 mt-20">
        <h1 class="title">Generator Nomor Undian</h1>

        <div class="display-wrapper">
            <div class="display-box text-white" :class="{ 'is-running': isMengundi }">
                {{ tampilanNomor }}
            </div>
        </div>

        <div
            v-if="pemenang"
            class="winner-info"
            :class="{ 'animate-winner': !isMengundi }"
        >
            <p class="congrats">Selamat kepada:</p>
            <p class="winner-name">{{ pemenang.nama }}</p>
        </div>

        <div class="controls">
            <button
                @click="mulaiUndian"
                :disabled="isMengundi || undians.length === 0"
                class="undian-button"
            >
                {{ buttonText }}
            </button>
        </div>

        <div v-if="error" class="error-message">
            {{ error }}
        </div>

        <div class="peserta-count">Sisa Peserta: {{ undians.length }}</div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";

// --- State Management ---
const undians = ref([]); // Daftar semua peserta dengan nomor undian
const tampilanNomor = ref("VENTURE-YYYYXXXX"); // Teks yang tampil di layar
const pemenang = ref(null); // Pemenang yang terpilih
const isMengundi = ref(false); // Status apakah proses undian sedang berjalan
const error = ref(null); // Untuk pesan error

let intervalId = null; // ID untuk setInterval agar bisa dihentikan

// --- Computed Properties ---
const buttonText = computed(() => {
    if (undians.value.length === 0 && !isMengundi.value) {
        return "Data Peserta Kosong";
    }
    return isMengundi.value ? "Mengundi..." : "Mulai Undian";
});

// --- Lifecycle Hooks ---
onMounted(() => {
    // Ambil data dari API Laravel saat komponen pertama kali dimuat
    // Anda bisa mengganti ini dengan action dari Pinia store jika data perlu dibagi
    fetch("/api/undian-peserta") // Sesuaikan URL jika domain berbeda
        .then((response) => {
            if (!response.ok) {
                throw new Error(
                    "Gagal memuat data peserta. Pastikan API berjalan."
                );
            }
            return response.json();
        })
        .then((data) => {
            undians.value = data;
            if (data.length === 0) {
                error.value =
                    "Tidak ada peserta dengan nomor undian yang ditemukan.";
            }
        })
        .catch((err) => {
            console.error(err);
            error.value = err.message;
        });
});

// --- Methods ---
const mulaiUndian = () => {
    if (undians.value.length === 0) {
        error.value = "Tidak ada lagi peserta yang bisa diundi.";
        return;
    }

    isMengundi.value = true;
    pemenang.value = null;
    error.value = null;

    // Efek angka berputar (acak) selama 5 detik
    const durasiUndian = 5000; // 5 detik

    intervalId = setInterval(() => {
        // Pilih peserta acak dari daftar untuk ditampilkan
        const randomIndex = Math.floor(Math.random() * undians.value.length);
        tampilanNomor.value = undians.value[randomIndex].no_undian;
    }, 75); // Ganti angka setiap 75 milidetik

    // Setelah durasi selesai, tentukan pemenangnya
    setTimeout(() => {
        clearInterval(intervalId); // Hentikan efek putaran

        // Pilih pemenang final secara acak
        const winnerIndex = Math.floor(Math.random() * undians.value.length);
        const pemenangTerpilih = undians.value[winnerIndex];

        // Simpan data pemenang
        pemenang.value = pemenangTerpilih;
        tampilanNomor.value = pemenangTerpilih.no_undian;
        isMengundi.value = false;

        // Hapus pemenang dari daftar agar tidak bisa menang lagi
        undians.value.splice(winnerIndex, 1);
    }, durasiUndian);
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@700&family=Poppins:wght@400;600&display=swap");

.undian-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 40px;
    background: #2c3e50;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    text-align: center;
    color: #ecf0f1;
    font-family: "Poppins", sans-serif;
}

.title {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 30px;
    color: #1abc9c;
}

.display-wrapper {
    padding: 10px;
    background: linear-gradient(145deg, #34495e, #2c3e50);
    border-radius: 15px;
    margin-bottom: 30px;
}

.display-box {
    background: #233140;
    padding: 30px 20px;
    font-family: "Roboto Mono", monospace;
    font-size: 3rem;
    font-weight: 700;
    letter-spacing: 2px;
    border-radius: 10px;
    border: 2px solid #34495e;
    transition: all 0.2s ease-in-out;
}

.display-box.is-running {
    color: #1abc9c;
    text-shadow: 0 0 15px #1abc9c;
}

.winner-info {
    margin-bottom: 30px;
    min-height: 80px;
}

.congrats {
    font-size: 1.2rem;
    color: #95a5a6;
    margin: 0;
}

.winner-name {
    font-size: 2rem;
    font-weight: 600;
    color: #f1c40f;
    margin: 5px 0 0 0;
}

.undian-button {
    padding: 15px 40px;
    font-size: 1.2rem;
    font-weight: 600;
    color: #fff;
    background-color: #1abc9c;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(26, 188, 156, 0.3);
}

.undian-button:hover:not(:disabled) {
    background-color: #16a085;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(26, 188, 156, 0.4);
}

.undian-button:disabled {
    background-color: #7f8c8d;
    cursor: not-allowed;
    opacity: 0.6;
}

.error-message {
    margin-top: 20px;
    color: #e74c3c;
    font-weight: 600;
}

.peserta-count {
    margin-top: 30px;
    color: #95a5a6;
}

.animate-winner {
    animation: winner-pop 0.5s ease-out;
}

@keyframes winner-pop {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    80% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@media (max-width: 600px) {
    .display-box {
        font-size: 1.8rem;
    }
    .title {
        font-size: 2rem;
    }
    .winner-name {
        font-size: 1.5rem;
    }
}
</style>
