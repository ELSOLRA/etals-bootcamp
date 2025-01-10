<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/vue3";
import Chirp from "@/Components/Chirp.vue";
import { ref } from "vue";
import SelectChirpModal from "@/Components/SelectChirpModal.vue";

defineProps(["chirps"]);

const form = useForm({
    message: "",
});

const showModal = ref(false);
const testChirps = {
    serious: "Test serious message",
    casual: "Test casual message",
    funny: "Test funny message",
};
</script>

<template>
    <Head title="Chirps" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
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
                <PrimaryButton class="mt-4">Chirp</PrimaryButton>
            </form>
            <!-- --------------------Testing--------------------- -->
            <button @click="showModal = true" class="bg-white">
                Testing Modal
            </button>
            <SelectChirpModal
                :show="showModal"
                :chirps="testChirps"
                @close="showModal = false"
            />

            <div class="mt-6 shadow-sm rounded-lg divide-y">
                <Chirp v-for="chirp in chirps" :key="chirp.id" :chirp="chirp" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
