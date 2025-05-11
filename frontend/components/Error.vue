<template>
    <div class="flex justify-center items-center py-4 bg-red-500 text-white rounded-lg shadow-md">
        <p class="text-sm">Error: {{ errorMessage }}</p>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    errorMessage: {
        type: String,
        required: true
    }
});
</script>