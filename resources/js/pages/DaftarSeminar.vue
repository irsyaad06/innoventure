

<template>
  <div class="min-h-screen mt-20 bg-gray-900 text-white flex flex-col items-center justify-center p-6">
    <!-- Card Seminar -->
    <div class="w-full max-w-5xl bg-white/5 backdrop-blur-md rounded-2xl shadow-xl border border-white/10 p-10 space-y-8">
      <!-- Header -->
      <div class="text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4">
          Seminar Innoventure 2025
        </h1>
        <p class="text-gray-300 max-w-3xl mx-auto leading-relaxed">
        Bergabunglah dalam seminar yang akan membuka wawasan dan menginspirasi Anda!
          <br /><br />
          Kami mengundang Anda untuk ikut serta dalam <span class="font-semibold">Seminar INNOVENTURE</span>, sebuah acara yang dirancang khusus untuk memberikan pengetahuan mendalam dan wawasan terbaru tentang <span class="italic">[topik seminar]</span>.
          Jangan lewatkan kesempatan untuk belajar langsung dari para ahli dan praktisi berpengalaman di bidangnya.
        </p>
      </div>

      <!-- Manfaat -->
      <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white/10 p-6 rounded-xl border border-white/10 shadow-md">
          <h3 class="font-semibold mb-2">✨ Pengetahuan Mendalam</h3>
          <p class="text-gray-300 text-sm">
            Ikuti sesi yang membahas tren terkini dan strategi terbaik dalam [topik seminar].
          </p>
        </div>
        <div class="bg-white/10 p-6 rounded-xl border border-white/10 shadow-md">
          <h3 class="font-semibold mb-2">✨ Interaksi Langsung</h3>
          <p class="text-gray-300 text-sm">
            Ajukan pertanyaan dan diskusikan ide-ide dengan pembicara dan peserta lain.
          </p>
        </div>
        <div class="bg-white/10 p-6 rounded-xl border border-white/10 shadow-md">
          <h3 class="font-semibold mb-2">✨ Jaringan & Kolaborasi</h3>
          <p class="text-gray-300 text-sm">
            Temui para profesional, pengusaha, dan praktisi dari berbagai latar belakang.
          </p>
        </div>
        <div class="bg-white/10 p-6 rounded-xl border border-white/10 shadow-md">
          <h3 class="font-semibold mb-2">✨ Sertifikat Partisipasi</h3>
          <p class="text-gray-300 text-sm">
            Dapatkan sertifikat yang akan memperkaya portofolio dan CV Anda.
          </p>
        </div>
      </div>

      <!-- Detail Seminar -->
      <div class="grid md:grid-cols-3 gap-6 text-center">
        <div class="bg-white/10 p-5 rounded-xl border border-white/10">
          <h4 class="font-semibold">📅 Tanggal</h4>
          <p class="text-gray-300 text-sm">Sabtu, 30 Agustus 2025</p>
        </div>
        <div class="bg-white/10 p-5 rounded-xl border border-white/10">
          <h4 class="font-semibold">⏰ Waktu</h4>
          <p class="text-gray-300 text-sm">08.00 - 15.00 WIB</p>
        </div>
        <div class="bg-white/10 p-5 rounded-xl border border-white/10">
          <h4 class="font-semibold">📍 Tempat</h4>
          <p class="text-gray-300 text-sm">Auditorium UNIKOM, Kampus 4, lantai 4</p>
        </div>
      </div>

      <!-- Contact Person -->
      <div class="bg-white/5 p-5 rounded-xl border border-white/10 text-center">
        <p class="text-sm text-gray-300">
          Untuk informasi lebih lanjut, hubungi Contact Person kami:
          <br />
          📞 MINNOV1 : 081235452002 &nbsp; | &nbsp; 📞 MINNOV2 : 081235452005
        </p>
      </div>

      <!-- Form Pendaftaran -->
      <div class="bg-white/10 p-8 rounded-xl border border-white/10 shadow-md">
        <h2 class="text-xl font-bold text-center mb-6">Form Pendaftaran</h2>
        <form @submit.prevent="handleSubmit" class="space-y-5">
          <div>
            <label class="block text-sm font-medium text-gray-200 mb-1">Nama</label>
            <input
              type="text"
              v-model="form.nama"
              class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none"
              placeholder="Masukkan nama lengkap"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-200 mb-1">Asal Sekolah / Instansi</label>
            <input
              type="text"
              v-model="form.asal"
              class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none"
              placeholder="Masukkan asal sekolah/instansi"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-200 mb-1">Email</label>
            <input
              type="email"
              v-model="form.email"
              class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none"
              placeholder="Masukkan email"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-200 mb-1">No WhatsApp</label>
            <input
              type="tel"
              v-model="form.whatsapp"
              class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none"
              placeholder="Masukkan no WhatsApp"
              required
            />
          </div>
          <div class="pt-4">
            <button
              type="submit"
              class="w-full px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300"
            >
              Kirim Pendaftaran
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        nama: "",
        asal: "",
        email: "",
        whatsapp: ""
      }
    };
  },

  methods: {
    handleSubmit() {
      console.log("Form dikirim:", this.form);
      alert("Form berhasil dikirim!");
      // ganti ini dengan axios/fetch ke backend Laravel
    }
  }
};
</script>
