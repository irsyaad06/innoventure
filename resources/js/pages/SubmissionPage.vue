<template>
    <div class="min-h-screen bg-gray-900 pt-28">
        <div class="text-white text-3xl text-center mb-10">
            Pengumpulan Karya Web Dev!
        </div>
        <div class="flex items-center justify-center md:px-4">
            <div
                class="bg-white/10 backdrop-blur-md rounded-2xl p-8 shadow-xl w-full max-w-3xl border border-white/20"
            >
                <div class="flex items-center w-full max-w-2xl mx-auto mb-8">
                    <template v-for="(stepName, index) in steps" :key="index">
                        <div class="flex flex-col items-center">
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-full font-semibold z-10"
                                :class="
                                    currentStep > index
                                        ? 'bg-blue-600 text-white'
                                        : currentStep === index
                                        ? 'bg-cyan-500 text-white'
                                        : 'bg-gray-700 text-gray-400'
                                "
                            >
                                {{ index + 1 }}
                            </div>
                            <span
                                class="mt-2 text-sm font-medium text-gray-300"
                            >
                                {{ stepName }}
                            </span>
                        </div>
                        <div
                            v-if="index < steps.length - 1"
                            class="flex-1 h-1 -mt-5"
                            :class="
                                currentStep > index
                                    ? 'bg-blue-600'
                                    : 'bg-gray-700'
                            "
                        ></div>
                    </template>
                </div>

                <h2
                    class="text-2xl md:text-3xl font-bold text-white text-center mb-6"
                >
                    {{ steps[currentStep] }}
                </h2>
                <div
                    v-if="loading"
                    class="text-center text-lg text-blue-400 mb-4"
                >
                    Sedang memproses...
                </div>
                <div v-if="error" class="text-center text-red-500 mb-4">
                    {{ error }}
                </div>

                <form @submit.prevent="handleSubmit" class="space-y-5">
                    <div v-if="currentStep === 0" class="space-y-4">
                        <div>
                            <label class="block text-white font-medium"
                                >Nama Kelompok
                                <span class="text-red-500">*</span></label
                            >
                            <select
                                v-model="form.teamId"
                                required
                                class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="" disabled>
                                    Pilih Nama Kelompok
                                </option>
                                <option
                                    v-for="team in tims"
                                    :key="team.id"
                                    :value="team.id"
                                >
                                    {{ team.nama }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-white font-medium"
                                >Email Ketua Kelompok
                                <span class="text-red-500">*</span></label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                    </div>

                    <div v-if="currentStep === 1" class="space-y-4">
                        <div>
                            <label class="block text-white font-medium"
                                >Judul Proyek
                                <span class="text-red-500">*</span></label
                            >
                            <input
                                v-model="form.judulProject"
                                type="text"
                                required
                                class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                        <div>
                            <label class="block text-white font-medium"
                                >Deskripsi Singkat Project (PDF)
                                <span class="text-red-500">*</span></label
                            >
                            <input
                                type="file"
                                accept=".pdf"
                                required
                                @change="
                                    handleFileChange($event, 'deskripsiFile')
                                "
                                class="w-full mt-2 block rounded-lg border border-gray-600 bg-gray-800 text-white px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                                :class="{
                                    'border-green-500': form.deskripsiFile,
                                }"
                            />
                            <small class="text-gray-400"
                                >Upload max 10 MB</small
                            >
                        </div>
                        <div>
                            <label class="block text-white font-medium"
                                >Link Repository (GitHub/Drive)
                                <span class="text-red-500">*</span></label
                            >
                            <input
                                v-model="form.linkRepo"
                                type="url"
                                required
                                class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                                @focus="addHttpsPrefix('linkRepo')"
                            />
                        </div>
                        <div>
                            <label class="block text-white font-medium"
                                >Link Video Demo (YouTube/Drive)
                                <span class="text-red-500">*</span></label
                            >
                            <input
                                v-model="form.linkVideo"
                                type="url"
                                required
                                class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                                @focus="addHttpsPrefix('linkVideo')"
                            />
                        </div>
                        <div>
                            <label class="block text-white font-medium"
                                >Link Website
                            </label>
                            <input
                                v-model="form.linkWebsite"
                                type="url"
                                class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                                @focus="addHttpsPrefix('linkWebsite')"
                            />
                        </div>
                        <div>
                            <label class="block text-white font-medium"
                                >Power Point Presentasi (max 10 menit)
                                <span class="text-red-500">*</span></label
                            >
                            <input
                                type="file"
                                accept=".ppt,.pptx,.pdf"
                                required
                                @change="
                                    handleFileChange($event, 'presentasiFile')
                                "
                                class="w-full mt-2 block rounded-lg border border-gray-600 bg-gray-800 text-white px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                                :class="{
                                    'border-green-500': form.presentasiFile,
                                }"
                            />
                            <small class="text-gray-400"
                                >Upload max 10 MB</small
                            >
                        </div>
                    </div>

                    <div v-if="currentStep === 2" class="space-y-4">
                        <p class="text-white">
                            Dengan ini saya menyatakan bahwa data yang saya isi
                            adalah benar adanya dan bukan hasil jiplakan.
                            Apabila terdapat ketidaksesuaian, saya siap
                            bertanggung jawab. dan saya yakin untuk memberikan
                            hasil karya saya dan tidak bisa diupdate lagi
                            setelah dikirimkan
                            <span class="text-red-500">*</span>
                        </p>
                        <label
                            class="flex items-center mt-2 space-x-2 text-white"
                        >
                            <input
                                type="checkbox"
                                v-model="form.persetujuan"
                                required
                            />
                            <span>Saya Bersedia</span>
                        </label>
                    </div>

                    <div class="flex justify-between pt-4">
                        <button
                            v-if="currentStep > 0"
                            type="button"
                            @click="prevStep"
                            class="px-6 py-2 rounded-lg bg-gray-600 text-white font-semibold shadow hover:opacity-80"
                        >
                            Kembali
                        </button>
                        <button
                            v-if="currentStep < steps.length - 1"
                            type="button"
                            @click="nextStep"
                            class="ml-auto px-6 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700"
                            :disabled="!isCurrentStepValid"
                            :class="{
                                'opacity-50 cursor-not-allowed':
                                    !isCurrentStepValid,
                            }"
                        >
                            Lanjut
                        </button>
                        <button
                            v-if="currentStep === steps.length - 1"
                            type="submit"
                            class="ml-auto px-6 py-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold shadow hover:opacity-90"
                            :disabled="loading || !form.persetujuan"
                            :class="{
                                'opacity-50 cursor-not-allowed':
                                    !form.persetujuan,
                            }"
                        >
                            <span v-if="!loading">Submit</span>
                            <span v-else>Mengirim...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div
        v-if="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
    >
        <div
            class="bg-gray-800 rounded-lg p-6 shadow-2xl max-w-sm mx-auto transform transition-all sm:my-8 sm:w-full"
            :class="{
                'border-t-4 border-green-500': modalType === 'success',
                'border-t-4 border-red-500': modalType === 'error',
            }"
        >
            <div class="text-center">
                <h3
                    class="text-lg leading-6 font-medium"
                    :class="{
                        'text-green-400': modalType === 'success',
                        'text-red-400': modalType === 'error',
                    }"
                >
                    {{ modalType === "success" ? "Berhasil!" : "Gagal!" }}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-300">
                        {{ modalMessage }}
                    </p>
                </div>
            </div>
            <div class="mt-5 flex justify-center">
                <button
                    @click="closeModal"
                    type="button"
                    class="px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div
        v-if="showConfirmationModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
    >
        <div
            class="bg-gray-800 rounded-lg p-6 shadow-2xl max-w-sm mx-auto transform transition-all sm:my-8 sm:w-full border-t-4 border-yellow-500"
        >
            <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-yellow-400">
                    Konfirmasi Pengumpulan
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-300">
                        Apakah Anda yakin ingin mengirimkan karya ini? Data
                        tidak dapat diubah setelah dikirim.
                    </p>
                </div>
            </div>
            <div class="mt-5 flex justify-center space-x-4">
                <button
                    @click="cancelSubmission"
                    type="button"
                    class="px-4 py-2 text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none"
                >
                    Batal
                </button>
                <button
                    @click="confirmSubmission"
                    type="button"
                    class="px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none"
                >
                    Ya, saya yakin
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { useWebdevProgressStore } from "../stores/webDevProgress.js";
import { useTimStore } from "../stores/tim.js";
import { mapState, mapActions } from "pinia";

export default {
    data() {
        return {
            currentStep: 0,
            steps: ["Identitas Kelompok", "Rincian Projek", "Persetujuan"],
            form: {
                teamId: "",
                email: "",
                judulProject: "",
                linkRepo: "",
                linkVideo: "",
                linkWebsite: "",
                deskripsiFile: null,
                presentasiFile: null,
                persetujuan: null,
            },
            showModal: false,
            modalMessage: "",
            modalType: "",
            showConfirmationModal: false, // State untuk modal konfirmasi
        };
    },
    computed: {
        ...mapState(useWebdevProgressStore, ["loading", "error"]),
        ...mapState(useTimStore, {
            tims: "tims",
        }),
        isCurrentStepValid() {
            if (this.currentStep === 0) {
                return this.form.teamId && this.form.email && this.isEmailValid;
            }
            if (this.currentStep === 1) {
                return (
                    this.form.judulProject &&
                    this.form.linkRepo &&
                    this.form.linkVideo &&
                    this.form.deskripsiFile &&
                    this.form.presentasiFile &&
                    this.isUrlValid(this.form.linkRepo) &&
                    this.isUrlValid(this.form.linkVideo) &&
                    (!this.form.linkWebsite || // linkWebsite tidak wajib, tapi jika diisi harus valid
                        this.isUrlValid(this.form.linkWebsite))
                );
            }
            // Step terakhir (persetujuan) selalu dianggap valid untuk navigasi
            return true;
        },
        isEmailValid() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(this.form.email);
        },
    },
    created() {
        useTimStore().fetchAll();
    },
    methods: {
        ...mapActions(useWebdevProgressStore, ["createProgress"]),

        showModalMessage(message, type) {
            this.modalMessage = message;
            this.modalType = type;
            this.showModal = true;
        },
        closeModal() {
            const isSuccess = this.modalType === "success";

            this.showModal = false;
            this.modalMessage = "";
            this.modalType = "";

            if (isSuccess) {
                this.$router.push("/game-on");
            }
        },
        addHttpsPrefix(key) {
            if (
                this.form[key] &&
                !this.form[key].startsWith("https://") &&
                !this.form[key].startsWith("http://")
            ) {
                this.form[key] = "https://" + this.form[key];
            }
        },
        handleFileChange(event, key) {
            const file = event.target.files[0];
            if (file) {
                this.form[key] = file;
            }
        },
        isUrlValid(url) {
            try {
                new URL(url);
                return true;
            } catch (e) {
                return false;
            }
        },
        nextStep() {
            if (this.isCurrentStepValid) {
                if (this.currentStep < this.steps.length - 1)
                    this.currentStep++;
            }
        },
        prevStep() {
            if (this.currentStep > 0) this.currentStep--;
        },
        handleSubmit() {
            if (!this.form.persetujuan) {
                this.showModalMessage(
                    "Anda harus menyetujui pernyataan terlebih dahulu.",
                    "error"
                );
                return;
            }
            // Tampilkan modal konfirmasi, bukan langsung submit
            this.showConfirmationModal = true;
        },
        cancelSubmission() {
            this.showConfirmationModal = false;
        },
        async confirmSubmission() {
            // Tutup modal konfirmasi
            this.showConfirmationModal = false;

            const pdfFile = this.form.deskripsiFile;
            const pptFile = this.form.presentasiFile;

            if (!pdfFile || !pptFile) {
                this.showModalMessage(
                    "Harap unggah kedua file yang diperlukan.",
                    "error"
                );
                return;
            }

            const formData = new FormData();
            formData.append("tim_id", this.form.teamId);
            formData.append("email_ketua", this.form.email);
            formData.append("judul_proyek", this.form.judulProject);
            formData.append("link_repository", this.form.linkRepo);
            formData.append("link_demo", this.form.linkVideo);
            formData.append("link_hosting", this.form.linkWebsite);
            formData.append("deskripsi_pdf", pdfFile);
            formData.append("ppt", pptFile);
            formData.append("persetujuan", this.form.persetujuan ? 1 : 0);

            try {
                const response = await this.createProgress(formData);
                if (response.code === 201) {
                    this.showModalMessage(
                        "Pengumpulan karya berhasil!",
                        "success"
                    );
                    // Reset form dan step
                    this.form = {
                        teamId: "",
                        email: "",
                        judulProject: "",
                        linkRepo: "",
                        linkVideo: "",
                        linkWebsite: "",
                        deskripsiFile: null,
                        presentasiFile: null,
                        persetujuan: null,
                    };
                    this.currentStep = 0;
                }
            } catch (err) {
                this.showModalMessage(
                    "Gagal mengirimkan data: " +
                        (this.error || "Terjadi kesalahan."),
                    "error"
                );
            }
        },
    },
};
</script>
