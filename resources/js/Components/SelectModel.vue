<script setup>
const MODELS = {
    "gpt-3.5-turbo": "GPT-3.5",
    "gpt-4": "GPT-4",
};

defineProps(["modelValue"]);
defineEmits(["update:modelValue"]);
</script>

<template>
    <select
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        placeholder="Select Model"
        class="rounded-md bg-gray-800 text-white text-xs font-semibold tracking-wider dark:border-none dark:bg-gray-700"
    >
        <option value="" disabled selected>SELECT MODEL</option>
        <option v-for="(lable, model) in MODELS" :key="model" :value="model">
            {{ lable }}
        </option>
    </select>
</template>
