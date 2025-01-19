<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/vue3";
import Chirp from "@/Components/Chirp.vue";
import { ref } from "vue";
import SelectChirpModal from "@/Components/SelectChirpModal.vue";
import axios from "axios";
import SelectModel from "@/Components/SelectModel.vue";

defineProps(["chirps"]);

const form = useForm({
    message: "",
});

const selectedModel = ref(null);
const loading = ref(false);
const showModal = ref(false);
const generatedChirps = ref(null);
const error = ref(null);

const generateChirps = async () => {
    if (!selectedModel.value) {
        error.value = "Please select a model first";
        return;
    }
    loading.value = true;
    error.value = null;
    try {
        const response = await axios.post(route("chirps.generate"), {
            model: selectedModel.value,
        });
        generatedChirps.value = response.data;
        showModal.value = true;
    } catch (err) {
        error.value = "Failed to generate chirps. TRY AGAIN";
        console.error("Failed to generate chirps: ", err);
    } finally {
        loading.value = false;
    }
};

const selectChirp = (message) => {
    form.message = message;
    showModal.value = false;
};
</script>

<template>
    <Head title="Chirps" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <!-- Form -->
            <form
                @submit.prevent="
                    form.post(route('chirps.store'), {
                        onSuccess: () => form.reset(),
                    })
                "
            >
                <textarea
                    v-model="form.message"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <!-- <PrimaryButton class="mt-4">Chirp</PrimaryButton> -->

                <!-- ----------------------------- -->
                <div class="mt-4 ml-1 flex gap-2">
                    <PrimaryButton
                        class="px-6 py-3 text-lg !focus:ring-0 !focus:ring-offset-0 !focus:ring-indigo-0 !ring-0 !ring-offset-0 dark:focus:bg-gray-700"
                    >
                        Add Chirp
                    </PrimaryButton>

                    <PrimaryButton
                        @click="generateChirps"
                        type="button"
                        :disabled="loading"
                        class="px-6 py-3 text-lg !focus:ring-0 !focus:ring-offset-0 !focus:ring-indigo-0 !ring-0 !ring-offset-0 dark:focus:bg-gray-700"
                    >
                        <svg
                            v-if="loading"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        {{ loading ? "Generating..." : "Generate AI Chirp" }}
                    </PrimaryButton>
                    <SelectModel v-model="selectedModel" />
                </div>
            </form>

            <div v-if="error" class="mt-2 text-red-600">
                {{ error }}
            </div>
            <SelectChirpModal
                :show="showModal"
                :chirps="generatedChirps"
                @close="showModal = false"
                @select="selectChirp"
            />

            <div class="mt-6 shadow-sm rounded-lg divide-y">
                <Chirp v-for="chirp in chirps" :key="chirp.id" :chirp="chirp" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
