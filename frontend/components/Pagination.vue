<template>
    <div class="flex justify-between items-center px-4 py-3 mt-6 w-full">
        <div class="text-sm text-slate-400">
            Showing page <b>{{ Math.min(currentPage, totalPages) }}</b> of {{ totalPages }}
        </div>

        <div class="flex ml-auto space-x-1">
            <button :disabled="currentPage === 1"
                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-300 bg-slate-700 border border-slate-600 rounded hover:bg-slate-600 hover:border-slate-500 transition duration-200 ease cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                    @click="goToPage(1)">
                First
            </button>

            <button v-if="currentPage > 2"
                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-300 bg-slate-700 border border-slate-600 rounded hover:bg-slate-600 hover:border-slate-500 transition duration-200 ease cursor-pointer"
                    @click="goToPage(currentPage - 2)">
                {{ currentPage - 2 }}
            </button>

            <button v-if="currentPage > 1"
                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-300 bg-slate-700 border border-slate-600 rounded hover:bg-slate-600 hover:border-slate-500 transition duration-200 ease cursor-pointer"
                    @click="goToPage(currentPage - 1)">
                {{ currentPage - 1 }}
            </button>

            <button disabled
                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-white bg-slate-600 border-slate-600 hover:bg-slate-500 hover:border-slate-500 transition duration-200 ease cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                {{ currentPage }}
            </button>

            <button v-if="currentPage < totalPages"
                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-300 bg-slate-700 border border-slate-600 rounded hover:bg-slate-600 hover:border-slate-500 transition duration-200 ease cursor-pointer"
                    @click="goToPage(currentPage + 1)">
                {{ currentPage + 1 }}
            </button>

            <button v-if="currentPage < totalPages - 1"
                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-300 bg-slate-700 border border-slate-600 rounded hover:bg-slate-600 hover:border-slate-500 transition duration-200 ease cursor-pointer"
                    @click="goToPage(currentPage + 2)">
                {{ currentPage + 2 }}
            </button>

            <button :disabled="currentPage === totalPages"
                    class="px-3 py-1 min-w-9 min-h-9 text-sm font-normal text-slate-300 bg-slate-700 border border-slate-600 rounded hover:bg-slate-600 hover:border-slate-500 transition duration-200 ease cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                    @click="goToPage(totalPages)">
                Last
            </button>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    currentPage: {
        type: Number,
        required: true,
    },
    totalPages: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(['update:currentPage']);

const goToPage = (page) => {
    if (page >= 1 && page <= props.totalPages) {
        emit('update:currentPage', page);
    }
};
</script>