<template>
    <button class="bg-slate-700 text-slate-200 px-3 py-2 rounded shadow cursor-pointer"
            @click="toggleFilterPanel">
        Filters
        <svg v-if="!isOpen"
             xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke-width="2"
             stroke="currentColor"
             class="w-5 h-5 inline-block ml-1">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
        <svg v-else
             xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke-width="2"
             stroke="currentColor"
             class="w-5 h-5 inline-block ml-1">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true
    }
});

const emit = defineEmits(['update:isOpen']);

function toggleFilterPanel() {
    emit('update:isOpen', !props.isOpen);
}

const handleKeydown = (event) => {
    if (event.key === 'Escape' && props.isOpen) {
        emit('update:isOpen', false);
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeydown);
});
</script>