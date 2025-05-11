<template>
    <div class="w-full md:w-auto">
        <div class="relative w-full max-w-sm min-w-[200px]">
            <input v-model="searchQuery"
                   class="w-full h-10 pl-3 pr-11 rounded border bg-slate-700 text-slate-200 placeholder-slate-400 border-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 hover:border-slate-500 transition shadow-sm"
                   placeholder="Unique identifier..."
                   @keyup.enter="handleSearch">
            <button class="absolute top-1 right-1 h-8 w-8 flex items-center justify-center rounded bg-slate-600 hover:bg-slate-500 transition cursor-pointer"
                    type="button"
                    @click="handleSearch">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="2"
                     stroke="currentColor"
                     class="w-5 h-5 text-slate-200">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    onSearch: {
        type: Function,
        required: true
    }
});

const searchQuery = ref('');

function handleSearch() {
    if (searchQuery.value.trim()) {
        props.onSearch(searchQuery.value.trim());
    }
}
</script>