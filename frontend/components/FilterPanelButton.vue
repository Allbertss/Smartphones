<template>
    <button class="bg-slate-700 text-slate-200 px-3 py-2 rounded shadow cursor-pointer"
            @click="toggleFilterPanel">
        Filters
        <FilterOpenIcon v-if="isOpen" />

        <FilterCloseIcon v-else />
    </button>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue';
import FilterOpenIcon from './svgs/FilterOpenIcon.vue';
import FilterCloseIcon from './svgs/FilterCloseIcon.vue';

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