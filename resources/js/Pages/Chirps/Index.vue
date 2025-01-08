<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head, Link } from "@inertiajs/vue3";

defineProps(["chirps"]);

const form = useForm({
    message: "",
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Chirps" />

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
                />
                <InputError :message="form.errors.message" class="mt-2" />
                <PrimaryButton class="mt-4">Chirp</PrimaryButton>
            </form>

            <div class="mt-6">
                <!-- in blade we use @foreach ($chirps as $chirp) but in vue istead foreach v-for -->

                <div
                    v-for="chirp in chirps"
                    :key="chirp.id"
                    class="mb-4 p-4 bg-white rounded shadow"
                >
                    <div>{{ chirp.user.name }}</div>
                    <div>{{ chirp.message }}</div>
                    <div>{{ new Date(chirp.created_at).toLocaleString() }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
