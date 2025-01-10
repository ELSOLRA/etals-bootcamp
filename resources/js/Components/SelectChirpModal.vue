<script setup>
import { Dialog, DialogPanel } from "@headlessui/vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

/* defineProps({
    show: Boolean,
    chirps: Object,
}); */
/** @type {(show: boolean, chirps: Object)} */
defineProps(["show", "chirps"]);

defineEmits(["close", "select"]);
</script>

<template>
    <Dialog :open="show" @close="$emit('close')" class="relative z-50">
        <div class="fixed inset-0 bg-gray-500/75" />

        <div class="fixed inset-0 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <DialogPanel class="w-full max-w-lg rounded-lg bg-white p-6">
                    <h2 class="text-lg font-medium mb-4">
                        Select a Generated Chirp
                    </h2>
                    <div
                        v-for="(message, style) in chirps"
                        :key="style"
                        class="p-4 rounded border hover:bg-gray-50 cursor-pointer"
                        @click="$emit('select', message)"
                    >
                        <div class="font-medium capitalize mb-1">
                            {{ style }}
                        </div>
                        <div>{{ message }}</div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <PrimaryButton @click="$emit('close')"
                            >Cancel</PrimaryButton
                        >
                    </div>
                </DialogPanel>
            </div>
        </div>
    </Dialog>
</template>
