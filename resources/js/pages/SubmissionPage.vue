<template>
    <div
        class="min-h-screen mt-20 flex items-center justify-center bg-gray-900 px-4"
    >
        <div
            class="bg-white/10 backdrop-blur-md rounded-2xl p-8 shadow-xl w-full max-w-3xl border border-white/20"
        >
            <!-- Progress Bar -->
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
                        <span class="mt-2 text-sm font-medium text-gray-300">
                            {{ stepName }}
                        </span>
                    </div>
                    <div
                        v-if="index < steps.length - 1"
                        class="flex-1 h-1 -mt-5"
                        :class="
                            currentStep > index ? 'bg-blue-600' : 'bg-gray-700'
                        "
                    ></div>
                </template>
            </div>

            <h2
                class="text-2xl md:text-3xl font-bold text-white text-center mb-6"
            >
                {{ steps[currentStep] }}
            </h2>

            <form @submit.prevent="handleSubmit" class="space-y-5">
                <!-- Step 1: Identitas Kelompok -->
                <div v-if="currentStep === 0" class="space-y-4">
                    <div>
                        <label class="block text-white font-medium"
                            >Nama Kelompok
                            <span class="text-red-500">*</span></label
                        >
                        <input
                            v-model="form.namaKelompok"
                            type="text"
                            required
                            class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label class="block text-white font-medium"
                            >Asal Sekolah
                            <span class="text-red-500">*</span></label
                        >
                        <input
                            v-model="form.asalSekolah"
                            type="text"
                            required
                            class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                        />
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

                <!-- Step 2: Data Ketua & Anggota -->
                <div v-if="currentStep === 1" class="space-y-4">
                    <div>
                        <label class="block text-white font-medium"
                            >Nama Ketua Kelompok
                            <span class="text-red-500">*</span></label
                        >
                        <input
                            v-model="form.ketua"
                            type="text"
                            required
                            class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label class="block text-white font-medium"
                            >NIS Ketua Kelompok
                            <span class="text-red-500">*</span></label
                        >
                        <input
                            v-model="form.nisKetua"
                            type="text"
                            required
                            class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div
                        v-for="i in 4"
                        :key="i"
                        class="border-t border-gray-600 pt-4"
                    >
                        <label class="block text-white font-medium"
                            >Nama Anggota {{ i }}
                            <span v-if="i <= 3" class="text-red-500"
                                >*</span
                            ></label
                        >
                        <input
                            v-model="form.anggota[i - 1].nama"
                            type="text"
                            :required="i <= 3"
                            class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                        />

                        <label class="block text-white font-medium mt-2"
                            >NIS Anggota {{ i }}
                            <span v-if="i <= 3" class="text-red-500"
                                >*</span
                            ></label
                        >
                        <input
                            v-model="form.anggota[i - 1].nis"
                            type="text"
                            :required="i <= 3"
                            class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                </div>

                <!-- Step 3: Project Detail -->
                <div v-if="currentStep === 2" class="space-y-4">
                    <div>
                        <label class="block text-white font-medium"
                            >Judul Project
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
                            class="w-full mt-2 block rounded-lg border border-gray-600 bg-gray-800 text-white px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                        />
                        <small class="text-gray-400">Upload max 100 MB</small>
                    </div>

                    <div>
                        <label class="block text-white font-medium"
                            >Link Repository (GitHub/Drive)
                            <span class="text-red-500">*</span></label
                        >
                        <input
                            v-model="form.repo"
                            type="url"
                            required
                            class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label class="block text-white font-medium"
                            >Link Video Demo (YouTube/Drive)
                            <span class="text-red-500">*</span></label
                        >
                        <input
                            v-model="form.video"
                            type="url"
                            required
                            class="w-full mt-2 px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500"
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
                            class="w-full mt-2 block rounded-lg border border-gray-600 bg-gray-800 text-white px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                        />
                        <small class="text-gray-400">Upload max 100 MB</small>
                    </div>
                </div>

                <!-- Step 4: Persetujuan -->
                <div v-if="currentStep === 3" class="space-y-4">
                    <p class="text-white">
                        Dengan ini saya menyatakan bahwa data yang saya isi
                        adalah benar adanya dan bukan hasil jiplakan. Apabila
                        terdapat ketidaksesuaian, saya siap bertanggung jawab.
                        <span class="text-red-500">*</span>
                    </p>
                    <label class="flex items-center mt-2 space-x-2 text-white">
                        <input
                            type="checkbox"
                            value="ya"
                            v-model="form.persetujuan"
                            required
                        />
                        <span>Saya Bersedia</span>
                    </label>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between pt-4">
                    <button
                        v-if="currentStep > 0"
                        type="button"
                        @click="prevStep"
                        class="px-6 py-2 rounded-lg bg-gray-600 text-white font-semibold shadow hover:opacity-80"
                    >
                        Back
                    </button>

                    <button
                        v-if="currentStep < steps.length - 1"
                        type="button"
                        @click="nextStep"
                        class="ml-auto px-6 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700"
                    >
                        Next
                    </button>

                    <button
                        v-if="currentStep === steps.length - 1"
                        type="submit"
                        class="ml-auto px-6 py-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold shadow hover:opacity-90"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentStep: 0,
            steps: [
                "Identitas Kelompok",
                "Data Anggota",
                "Detail Project",
                "Persetujuan",
            ],
            form: {
                namaKelompok: "",
                asalSekolah: "",
                email: "",
                ketua: "",
                nisKetua: "",
                anggota: [
                    { nama: "", nis: "" },
                    { nama: "", nis: "" },
                    { nama: "", nis: "" },
                    { nama: "", nis: "" },
                ],
                judulProject: "",
                repo: "",
                video: "",
                persetujuan: null,
            },
        };
    },
    methods: {
        nextStep() {
            if (this.currentStep < this.steps.length - 1) this.currentStep++;
        },
        prevStep() {
            if (this.currentStep > 0) this.currentStep--;
        },
        handleSubmit() {
            alert("Form Submitted!");
            console.log(this.form);
        },
    },
};
</script>
